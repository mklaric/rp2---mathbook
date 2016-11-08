<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;

class ModulesController extends Controller
{
    public function handler(Request $request, Page $page, $module)
    {
        if ($request->isMethod('GET')) {
            switch($module) {
                case 'notifications':
                    return \App::make("App\Http\Controllers\NotificationsController")->pageNotifications($page);

                case 'settings':
                    return \App::make("App\Http\Controllers\PagesController")->settings($page);
            }
        }

        $method = $request->method();

        $haveNoTable = ['PageNotifications', 'PageSettings'];
        foreach($page->modules as $m) {
            if (in_array($m->type, $haveNoTable))
                continue;
            $tmp = "\App\\" . $m->type;
            $mod = $tmp::where('page_module_id', '=', $m->id)->first();
            if (isset($mod->link) && $mod->link === $module) {
                $class = "App\Http\Controllers\\" . $m->type  . "sController";
                if (class_exists($class)) {
                    $obj = \App::make("App\Http\Controllers\\" . $m->type  . "sController");
                    $_method = '_' . $method;
                    if (method_exists($obj, $_method))
                        return $obj->$_method($request, $page, $mod);
                    else
                        abort(404);
                } else {
                    return view('pages.modules.' . $m->type, compact('page', 'module'));
                }
            }
        }

        abort(404);
    }

    public function create(Request $request, Page $page, $module)
    {
        $tmp = "\App\\" . $module;
        $class = "App\Http\Controllers\\" . $module  . "sController";
        if (class_exists($class)) {
            $obj = \App::make("App\Http\Controllers\\" . $module  . "sController");
            if (method_exists($obj, '_create'))
                return $obj->_create($request, $page);
        }

        abort(404);
    }
}
