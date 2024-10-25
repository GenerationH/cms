<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    private $oldTags = null;
    private $oldCategoryId = 0;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $this->oldTags = DB::table('article_tag_relation')->where('article_id', $this->getRecord()->id)->pluck('tag_id')->toArray();
        $this->oldCategoryId = $this->getRecord()->category_id;;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $suc = $record->update($data);
        if ($suc) {
            // 判断 category 是否有改变，如果有改变，则更新新旧的 category 的 count
            if ($this->oldCategoryId != $data['category_id']) {
                \App\Services\Article::updateCategoryCount($this->oldCategoryId);
                \App\Services\Article::updateCategoryCount($this->getRecord()['category_id']);
            }
            \App\Services\Article::updateTagsCount($this->oldTags);
            \App\Services\Article::updateTagsCount($this->getRecord()->tags);
        }

        return $record;
    }
}
