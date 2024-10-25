<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    //
    protected $fillable = ['title', 'content', 'cover', 'category_id', 'additional_params'];

    protected $casts = [
        'additional_params' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tag::class, 'article_tag_relation');
    }

    public function delete(): ?bool
    {
        $this->tags()->detach($this->tags->pluck('id')->toArray());
        return parent::delete();
    }

}
