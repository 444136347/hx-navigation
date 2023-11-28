<?php

namespace App\Models\Visits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use SoftDeletes;

    protected $table = 'visit_pages';
}
