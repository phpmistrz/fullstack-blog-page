<?php

namespace App\Models;

use Filament\Forms\Set;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\DateTimePicker;
use Mokhosh\FilamentRating\Components\Rating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
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
        'content',
        'thumbnail',
        'gallery',
        'rating',
        'featured',
        'published_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'gallery' => 'array',
        'featured' => 'boolean',
        'published_at' => 'datetime',
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

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
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

    public static function getSteps(): array
    {
        return [
            Step::make('Treść')
                ->icon('heroicon-o-pencil')
                ->columns(2)
                ->schema([

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

                    RichEditor::make('content')
                        ->label('Treść')
                        ->required()
                        ->columnSpanFull(),

                    Rating::make('rating')
                        ->label('Ocena')
                        ->allowZero()
                        ->default(0),

                    Toggle::make('featured')
                        ->label('Polecany')
                        ->columnSpanFull(),

                ]),

            Step::make('Zdjęcia')
                ->icon('heroicon-o-photo')
                ->schema([
                    FileUpload::make('thumbnail')
                        ->label('Miniaturka')
                        ->required()
                        ->directory('thumbnails-post')
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

                    FileUpload::make('gallery')
                        ->label('Galeria')
                        ->required()
                        ->directory('images-post')
                        ->image()
                        ->optimize('webp')
                        ->maxSize(4096)
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->panelLayout('grid')
                        ->minFiles(3)
                        ->maxFiles(9)
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            null,
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->columnSpanFull()

                ]),

            Step::make('Powiązania')
                ->icon('heroicon-o-arrows-right-left')
                ->schema([

                    Select::make('category_id')
                        ->label('Kategoria')
                        ->relationship('categories', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required()
                        ->placeholder('Można wybrać kilka')
                    // ->createOptionAction(Category::getForm())
                    ,

                    Select::make('tag_id')
                        ->label('Tag')
                        ->relationship('tags', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required()
                        ->placeholder('Można wybrać kilka')
                    // ->createOptionAction(Tag::getForm())
                    ,
                    Select::make('movie_id')
                        ->label('Film')
                        ->relationship('movies', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->placeholder('Można wybrać kilka'),
                    Select::make('completed_game_id')
                        ->label('Ukończona gra')
                        ->relationship(
                            'completedGames',
                            'title',
                            function ($query) {
                                $currentYear = Carbon::now()->format('Y');
                                $query->where('year', $currentYear);
                            }
                        )
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->placeholder('Można wybrać kilka'),
                    Select::make('top_game_id')
                        ->label('Top of the Top')
                        ->relationship('topGames', 'title')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->placeholder('Można wybrać kilka'),
                ]),

            Step::make('Publikacja')
                ->icon('heroicon-o-clock')
                ->schema([
                    DateTimePicker::make('published_at')
                        ->label('Data publikacji')
                        ->columns(1)
                        ->default(now())
                        ->required()

                ])
        ];
    }




    //             Forms\Components\DateTimePicker::make('published_at')
    //                 ->required(),

}
