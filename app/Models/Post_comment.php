<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_comment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = ['likes','dislikes','author','date'];

    public function getLikesAttribute()
    {
        return Comment_like::where('id_comment', $this->id)->get()->count();
    }
    public function getDislikesAttribute()
    {
        return Comment_dislike::where('id_comment', $this->id)->get()->count();
    }
    public function getAuthorAttribute()
    {
        return User::where('id', $this->id_user)->first()->name;
    }
    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d M Y H:i');
    }

}
