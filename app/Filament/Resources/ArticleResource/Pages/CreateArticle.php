<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function afterCreate(): void
    {
        $categoryArticleCount = Article::where('category_id', $this->getRecord()['category_id'])->count();
        Category::where('id', $this->getRecord()['category_id'])->update(['count' => $categoryArticleCount]);
        foreach ($this->getRecord()['tags'] as $tag) {
            $tagArticleCount = Db::table('article_tag_relation')->where('tag_id', $tag['id'])->count();
            Tag::where('id', $tag['id'])->update(['count' => $tagArticleCount]);
        }
    }
}
