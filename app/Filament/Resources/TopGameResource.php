<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\TopGame;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TopGameResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TopGameResource\RelationManagers;

class TopGameResource extends Resource
{
    protected static ?string $model = TopGame::class;


    protected static ?string $navigationGroup = 'Gry';

    public static function form(Form $form): Form
    {
        return $form
            ->schema( TopGame::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('created_at', 'desc')
        ->columns([
            ImageColumn::make('thumbnail')
                ->label('Miniaturka')
                ->circular(),
            TextColumn::make('title')
                ->label('Tytuł')
                ->sortable()
                ->searchable(),
            TextColumn::make('posts_count')
                ->label('Liczba postów')
                ->counts('posts')
                ->sortable(),
            ImageColumn::make('categories.thumbnail')
                ->label('Kategorie')
                ->circular()
                ->stacked()
                ->limit(3)
                ->limitedRemainingText(),
            ImageColumn::make('tag.thumbnail')
                ->label('Tagi')
                ->circular()
                ->stacked()
                ->limit(3)
                ->limitedRemainingText(),
            TextColumn::make('created_at')
                ->label('Data utworzenia')
                ->dateTime()
                ->sortable()
                ->formatStateUsing(function ($state) {
                    return $state->format('d-m-Y');
                })
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label('Data modyfikacji')
                ->dateTime()
                ->sortable()
                ->formatStateUsing(function ($state) {
                    return $state->format('d-m-Y');
                })
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

  

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTopGames::route('/'),
            'create' => Pages\CreateTopGame::route('/create'),
            'edit' => Pages\EditTopGame::route('/{record}/edit'),
        ];
    }

    
    public static function getNavigationLabel(): string
    {
        return ('Top Games');
    }

    public static function getPluralLabel(): ?string
    {
        return ('Top Games');
    }

    public static function getLabel(): ?string
    {
        return ('Top Game');

    }
}
