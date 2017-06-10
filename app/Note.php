<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
      protected $fillable = [
        'file_name', 'file_size', 'mimes_type','user_id','title','description'
    ];
      public function user()
    {
        return $this->belongsTo(User::class);
    }
        public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
