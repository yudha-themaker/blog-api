<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['author','comments','post_like','post_dislike','is_i_liked','is_i_disliked','published_date_format'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function post_comment()
    {
        return $this->hasMany(Post_comment::class, 'id_post', 'id');
    }
    public function getCommentsAttribute()
    {
        $result =  Post_comment::where('id_post', $this->id)->get();
        return $result->count();
    }
    public function getAuthorAttribute()
    {
        $result =  User::where('id', $this->id_user)->first();
        return $result->name;
    }
    public function getPostLikeAttribute()
    {
        $result =  Post_like::where('id_post', $this->id)->get();
        return $result->count();
    }
    public function getPostDislikeAttribute()
    {
        $result =  Post_dislike::where('id_post', $this->id)->get();
        return $result->count();
    }
    public function getIsILikedAttribute()
    {
        $result =  Post_like::where('id_post', $this->id)->first();
        return $result ? true : false;
    }
    public function getIsIDislikedAttribute()
    {
        $result =  Post_dislike::where('id_post', $this->id)->first();
        return $result ? true : false;
    }
    public function getPublishedDateFormatAttribute()
    {
        $result =  Carbon::parse($this->published_date)->format('d M Y H:i');
        return $result;
    }
}
