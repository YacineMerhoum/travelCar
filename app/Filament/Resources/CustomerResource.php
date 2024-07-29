<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('firstname')
                    ->required()
                    ->label('First Name'),
                Forms\Components\TextInput::make('lastname')
                    ->required()
                    ->label('Last Name'),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Email'),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->password()
                    ->label('Password'),
                Forms\Components\Select::make('role')
                    ->required()
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->label('Role'),
                Forms\Components\TextInput::make('avatar')
                    ->label('Avatar'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname')
                    ->label('First Name')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('lastname')
                    ->label('Last Name')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->disableClick(),
                Tables\Columns\TextColumn::make('avatar')
                    ->label('Avatar')
                    ->disableClick(),
            ])
            ->filters([
                // Ajoutez vos filtres ici si nécessaire
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
