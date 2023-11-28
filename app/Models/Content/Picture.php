<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'sub_title',
        'description',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(config('admin.database.users_model'));
    }

    public function attachments()
    {
        return $this->hasMany(PictureAttachment::class,'picture_id','id');
    }
}
