<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = ['test_id', 'content'];

    public function pageTest()
    {
        return $this->belongsTo('App\PageTest')->first();
    }

    public function fileentries()
    {
        return $this->hasMany('App\Fileentry')->orderBy('user_id');
    }
}