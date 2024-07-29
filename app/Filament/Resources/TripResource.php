<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Models\Trips;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TripResource extends Resource
{
    protected static ?string $model = Trips::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('starting_point')
                    ->required()
                    ->label('Starting Point'),
                Forms\Components\TextInput::make('ending_point')
                    ->required()
                    ->label('Ending Point'),
                Forms\Components\DateTimePicker::make('starting_at')
                    ->required()
                    ->label('Starting At'),
                Forms\Components\TextInput::make('available_places')
                    ->required()
                    ->numeric()
                    ->label('Available Places'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->label('Price'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'lastname')
                    ->required()
                    ->label('User'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('starting_point')
                    ->label('Starting Point')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('ending_point')
                    ->label('Ending Point')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('starting_at')
                    ->label('Starting At')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('available_places')
                    ->label('Available Places')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('user.lastname')
                    ->label('User')
                    ->disableClick(),
            ])
            ->filters([
                // Ajoutez vos filtres ici si nécessaire
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Définir les relations si nécessaire
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
