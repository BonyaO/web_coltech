<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use App\Filament\Resources\ApplicationResource;
use App\Filament\Resources\ApplicationResource\Widgets\ApplicationOverview;
use App\Jobs\DownloadFilesJob;
use App\Models\Application;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use ZipArchive;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            ApplicationOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Download files')
                ->action(function () {
                    $path = storage_path('app/public/applicants');
                    DownloadFilesJob::dispatchSync($path);

                    return response()->download("$path.zip");
                }),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            \Filament\Tables\Actions\BulkAction::make('download_selected_files')
                ->label('Download Files')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function ($records) {
                    return $this->downloadSelectedFiles($records);
                })
                ->requiresConfirmation()
                ->modalHeading('Download Selected Student Files')
                ->modalDescription('Are you sure you want to download files for the selected students?'),
        ];
    }

    protected function downloadSelectedFiles($records)
    {
        $tempDir = storage_path('app/temp/bulk_download_' . time());
        $zipPath = $tempDir . '.zip';

        // Create temp directory
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zip = new ZipArchive();
        
        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Cannot create zip file');
        }

        $getExtension = function (string $alias, string $file) {
            if ($file) {
                return "$alias." . explode('.', $file)[1];
            }
            return '';
        };

        foreach ($records as $record) {
            // Create a folder for each student in the zip
            $studentFolder = $record->getCode() . '/';
            
            // Add student files to their folder in the zip
            $this->addFileToZip($zip, $record, 'birthcert', $studentFolder, $getExtension);
            $this->addFileToZip($zip, $record, 'passport', $studentFolder, $getExtension);
            $this->addFileToZip($zip, $record, 'bankrecipt', $studentFolder, $getExtension);
            foreach ($record->qualifications as $qualification) {
                if ($qualification->certificate) {
                    $qualFilePath = storage_path('app/public/' . $qualification->certificate);
                    if (file_exists($qualFilePath)) {
                        $qualFileName = $getExtension(
                            str_replace('/', '', $qualification->qualificationType->name ?? 'qualification'),
                            $qualification->certificate
                        );
                        $zip->addFile($qualFilePath, $studentFolder . $qualFileName);
                    }
                }
            }
            
            // Add qualification certificates
            foreach ($record->qualifications as $qualification) {
                if ($qualification->certificate) {
                    $qualFilePath = storage_path('app/public/' . $qualification->certificate);
                    if (file_exists($qualFilePath)) {
                        $qualFileName = $getExtension(
                            str_replace('/', '', $qualification->qualificationType->name ?? 'qualification'),
                            $qualification->certificate
                        );
                        $zip->addFile($qualFilePath, $studentFolder . $qualFileName);
                    }
                }
            }
        }

        $zip->close();

        // Clean up temp directory if it was created but empty
        if (file_exists($tempDir) && is_dir($tempDir)) {
            rmdir($tempDir);
        }

        return response()->download($zipPath, 'selected_students_files.zip')->deleteFileAfterSend();
    }

    private function addFileToZip($zip, $record, $fileField, $studentFolder, $getExtension)
    {
        if ($record[$fileField]) {
            $filePath = storage_path('app/public/' . $record[$fileField]);
            if (file_exists($filePath)) {
                $fileName = $getExtension($fileField, $record[$fileField]);
                $zip->addFile($filePath, $studentFolder . $fileName);
            }
        }
    }
}