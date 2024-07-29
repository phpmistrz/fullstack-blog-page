<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Movie;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MovieResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MovieResource\RelationManagers;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Treści';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Movie::getForm());
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
                ->url(fn($record) => $record->link)
                ->sortable()
                ->searchable()
                ->openUrlInNewTab(),
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
                
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return ('Filmy');
    }

    public static function getPluralLabel(): ?string
    {
        return ('Filmy');
    }

    public static function getLabel(): ?string
    {
        return ('Film');

    }
}
