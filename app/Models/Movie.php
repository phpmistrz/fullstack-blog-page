<?php

namespace App\Models;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'link',
        'thumbnail',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
    // RELATIONS
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function topGames(): BelongsToMany
    {
        return $this->belongsToMany(TopGame::class);
    }

    public function completedGames(): BelongsToMany
    {
        return $this->belongsToMany(CompletedGame::class);
    }
    // FORM

    public static function getForm(): array
    {
        return [
            TextInput::make('title')
                ->label('Tytuł')
                ->unique(ignoreRecord: true)
                ->required()
                ->minLength(3)
                ->maxLength(255)
                ->live(debounce: 1000)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

            TextInput::make('slug')
                ->label('Slug')
                ->readOnly()
                ->required()
                ->minLength(3)
                ->maxLength(255),

           TextInput::make('link')
           ->label('Link')
           ->url()
           ->required()
           ->columnSpanFull()
           ,
                
            FileUpload::make('thumbnail')
                ->label('Miniaturka')
                ->required()
                ->directory('thumbnails-movie')
                ->image()
                ->optimize('webp')
                ->maxSize(4096)
                ->imageEditor()
                ->imageEditorAspectRatios([
                    null,
                    '16:9',
                    '4:3',
                    '1:1',
                ])
                ->columnSpanFull(),

            Fieldset::make('Powiązania')
                ->schema([
                    Select::make('category_id')
                        ->label('Kategoria')
                        ->relationship('categories', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required()
                        ->placeholder('Można wybrać kilka')
                        ->createOptionForm(Category::getForm()),
                    Select::make('tag_id')
                        ->label('Tag')
                        ->relationship('tags', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->placeholder('Można wybrać kilka')
                        ->createOptionForm(Tag::getForm()),
                    Select::make('completed_game_id')
                        ->label('Ukończona gra')
                        ->relationship('completedGames', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->placeholder('Można wybrać kilka')
                        ->createOptionForm(CompletedGame::getForm()),
                    Select::make('top_game_id')
                        ->label('Topowe gry')
                        ->relationship('topGames', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->placeholder('Można wybrać kilka')
                        ->createOptionForm(TopGame::getForm()),
                    Select::make('post_id')
                        ->label('Post')
                        ->relationship('posts', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->placeholder('Można wybrać kilka'),
                ])
        ];
    }
}
