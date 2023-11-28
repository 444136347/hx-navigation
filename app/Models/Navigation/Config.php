<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use SoftDeletes;

    protected $table = 'navigation_configs';

    protected $fillable = [
        'id',
        'type',
        'name',
        'key',
        'string_value',
        'text_value',
        'description',
        'user_id',
        'status'
    ];

    public function user()
    {
       return $this->belongsTo(config('admin.database.users_model'));
    }
}
