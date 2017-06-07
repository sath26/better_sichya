<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
	
    protected $fillable=['title','slug'];
    /**
     * Get all of the owning commentable models.
     */
   public function threads()
    {
        return $this->morphedByMany('App\Thread', 'taggable');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function notes()
    {
        return $this->morphedByMany('App\Note', 'taggable');
    }
}
