<?php

namespace App\Admin\Repositories\Content;

use App\Models\Content\Article as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Article extends EloquentRepository
{
    protected $eloquentClass = Model::class;
}
