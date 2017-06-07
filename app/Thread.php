<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use CommentableTrait;
    protected $fillable=['title','slug','body','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

       public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
