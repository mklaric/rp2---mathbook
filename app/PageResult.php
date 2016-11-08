<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageResult extends Model
{
    public function pageModule()
    {
        return $this->belongsTo('App\PageModule')->first();
    }
    public function results()
 	{
 	   		return $this->hasMany('App\Result')->orderBy('updated_at', 'desc');
 	}
}
