<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'thumbnail',
        'type',
        'meta_title',
        'meta_description',
        'read_time',
        'like_count',
        'user_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
