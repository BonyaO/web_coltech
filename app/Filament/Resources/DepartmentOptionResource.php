<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentOptionResource\Pages;
use App\Models\DepartmentOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DepartmentOptionResource extends Resource
{
    protected static ?string $model = DepartmentOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('level')
                    ->options(DepartmentOption::LEVELS)
                    ->required()
                    ->native(false)
                    ->placeholder('Select a level'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'year_1' => 'success',
                        'year_3' => 'warning',
                        'year_4' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => DepartmentOption::LEVELS[$state] ?? $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->options(DepartmentOption::LEVELS)
                    ->placeholder('All Levels'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartmentOptions::route('/'),
            'create' => Pages\CreateDepartmentOption::route('/create'),
            'edit' => Pages\EditDepartmentOption::route('/{record}/edit'),
        ];
    }
}