<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'navigation_messages';

    protected $fillable = [
        'id',
        'title',
        'text',
        'link',
        'description',
        'order',
        'user_id',
        'status' // 状态, 1启用, 0禁用
    ];

    public function user()
    {
       return $this->belongsTo(config('admin.database.users_model'));
    }
}
