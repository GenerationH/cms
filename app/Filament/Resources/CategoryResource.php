<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('cms.Category');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label(__('cms.category.name'))->required(),
                Textarea::make('description')->label(__('cms.category.description')),
                Repeater::make('additional_params')->label(__('cms.category.additionalParamsName'))
                    ->schema([
                        TextInput::make('name')->label(__('cms.category.additionalParams.name')),
                        Select::make('type')->label(__('cms.category.additionalParams.typeName'))
                            ->options([
                                'TextInput' => __('cms.category.additionalParams.type.TextInput'),
                                'Textarea' => __('cms.category.additionalParams.type.Textarea'),
                            ]),
                    ])->columns(2)->defaultItems(0),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('cms.category.name')),
                Tables\Columns\TextColumn::make('description')->label(__('cms.category.description')),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
