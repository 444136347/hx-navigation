<?php

namespace App\Admin\Repositories\Content;

use App\Models\Content\Picture as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Picture extends EloquentRepository
{
    protected $eloquentClass = Model::class;
}
