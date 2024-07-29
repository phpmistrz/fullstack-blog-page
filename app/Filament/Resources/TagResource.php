<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TagResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TagResource\RelationManagers;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Kategorie i Tagi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Tag::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            
                ->defaultSort('posts_count','desc')
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return ('Tagi');
    }

    public static function getPluralLabel(): ?string
    {
        return ('Tagi');
    }

    public static function getLabel(): ?string
    {
        return ('Tag');
    }
}
