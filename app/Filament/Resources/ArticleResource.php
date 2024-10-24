<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-m-pencil-square';


    public static function getModelLabel(): string
    {
        return __('cms.article');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label(__('cms.articleFields.title'))
                    ->required()
                    ->maxLength(255),
                FileUpload::make('cover')->label(__('cms.articleFields.cover'))->default(''),
                Select::make('category_id')->label(__('cms.articleFields.category'))
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(fn (Select $component) => $component
                        ->getContainer()
                        ->getComponent('additional_params')
                        ->getChildComponentContainer()
                        ->fill()),
                Grid::make(1)
                    ->schema(function(Get $get) {
                        $fields = [];
                        $category = Category::find($get('category_id'));
//                        dd($category);
                        if ($category) {
                            foreach ($category->additional_params as $item) {
                                if ($item['type'] == 'TextInput') {
                                    $fields[] =  TextInput::make('additional_params.'. $item['name'])->label($item['name']);
                                }
                                if ($item['type'] == 'Textarea') {
                                    $fields[] = Textarea::make('additional_params.'. $item['name'])->label($item['name']);
                                }
                            }
                        }


                        return $fields;
                    })
                    ->key('additional_params')->label(__('cms.articleFields.additional_params')),
                Select::make('tag')
                    ->label(__('cms.articleFields.tag'))
                    ->relationship(name: 'tags', titleAttribute: 'name')
                    ->preload()
                    ->multiple()
                    ->native(false)
                    ->createOptionForm([
                        TextInput::make('name')->label(__('cms.category.name')),
                    ])
                    ->searchable(),
                RichEditor::make('content')->required()->label(__('cms.articleFields.content')),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cover')
                    ->searchable(),
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
                //
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
