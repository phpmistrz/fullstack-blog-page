<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use IbrahimBougaoua\FilamentRatingStar\Columns\RatingStarColumn;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Treści';

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
                    ->url(fn ($record) => url($record->slug))
                    ->description(fn (Post $record) => Str::limit(strip_tags($record->content), 40))
                    ->sortable()
                    ->searchable()
                    ->openUrlInNewTab(),
                IconColumn::make('featured')
                    ->label('Polecany')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Data publikacji')
                    ->dateTime()
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return $state->format('d-m-Y | H:i');
                    })
                    ->color(function ($state) {
                        if ($state <= Carbon::now()) {
                            return 'success';
                        } else {
                            return 'danger';
                        }
                    })
                    ->sortable(),
                RatingStarColumn::make('rating')
                    ->label('Ocena')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return ('Posty');
    }

    public static function getPluralLabel(): ?string
    {
        return ('Posty');
    }

    public static function getLabel(): ?string
    {
        return ('Post');
    }
}
