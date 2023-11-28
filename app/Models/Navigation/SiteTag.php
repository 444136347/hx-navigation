<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Model;

class SiteTag extends Model
{
    protected $table = 'navigation_site_tags';

    protected $fillable = [
        'id',
        'tag_id',
        'site_id',
    ];
}
