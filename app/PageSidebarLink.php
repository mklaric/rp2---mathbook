<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageSidebarLink extends Model
{
    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function pageModule()
    {
        return $this->belongsTo('App\PageModule');
    }
}
