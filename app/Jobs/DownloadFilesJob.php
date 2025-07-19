<?php

namespace App\Jobs;

use App\Models\Application;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;

class DownloadFilesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected string $path;

    /**
     * Create a new job instance.
     */
    public function __construct(string $path)
    {
        if (file_exists($path) || is_dir($path)) {
            exec('rm -rf '.escapeshellarg($path));
        }
        mkdir($path, 0755, true);
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $zipPath = $this->path . '.zip';
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

        foreach (Application::take(4)->get() as $record) {
            $userDirectory = $this->path . '/' . $record->getCode();
            if (!file_exists($userDirectory)) {
                mkdir($userDirectory, 0755, true);
            }

            // Create folder structure in zip for each student
            $studentFolder = $record->getCode() . '/';

            $addFileToZip = function (string $fileField) use ($zip, $getExtension, $record, $studentFolder) {
                if ($record[$fileField]) {
                    $filePath = storage_path('app/public/' . $record[$fileField]);
                    if (file_exists($filePath)) {
                        $fileName = $getExtension($fileField, $record[$fileField]);
                        $zip->addFile($filePath, $studentFolder . $fileName);
                    }
                }
            };

            // Add student files
            $addFileToZip('birthcert');
            $addFileToZip('passport');
            $addFileToZip('bankrecipt');

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

        Notification::make()
            ->success()
            ->title('Your file is ready for download')
            ->send();
    }
}