<?php

namespace App\Services;

use App\Models\Article as ArticleModel;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class Article
{
    public static function updateCategoryCount($categoryId)
    {
        $categoryArticleCount = ArticleModel::where('category_id', $categoryId)->count();
        Category::where('id', $categoryId)->update(['count' => $categoryArticleCount]);
    }

    public static function updateTagsCount($tags)
    {
        foreach ($tags as $tag) {
            $tagId = is_numeric($tag) ? $tag : $tag->id;;
            $tagArticleCount = DB::table('article_tag_relation')->where('tag_id', $tagId)->count();
            Tag::where('id', $tagId)->update(['count' => $tagArticleCount]);
        }
    }
}
