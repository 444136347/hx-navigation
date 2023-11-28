<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArticleContent extends Model
{
    use SoftDeletes;

    protected $table = 'article_contents';

    protected $fillable = [
        'content'
    ];
}
