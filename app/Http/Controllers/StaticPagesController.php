<?php

namespace App\Http\Controllers;

use App\Page;
use App\StaticPage;
use App\PageModule;
use App\PageSidebarLink;

use Illuminate\Http\Request;
use App\Http\Requests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StaticPagesController extends Controller
{
    public function _create(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);

        \Session::flash('message', 'Link length should be less than 21 character');
        \Session::flash('alert-class', 'alert-danger');

        $this->validate($request, [
            'name' => 'required|max:255',
            'link' => 'required|max:20'
        ]);

        \Session::flash('message', 'Static page successfully created!');
        \Session::flash('alert-class', 'alert-success');

        StaticPage::_create($request->name, $request->link, $page);

        return back();
    }

    public function _get($request, $page, $module)
    {
        if (\Auth::check() && \Auth::user()->hasAnyRole(['admin', $page->id . '.admin'])) {
            $buttons[0] = (object) [
                                    'label' => 'Icon',
                                    'id' => 'changeIcon',
                                    'link' => '#',
                                    'color' => 'red',
                                    'icon' => $module->pageModule()->sidebarLink()->first()->icon
                                ];
            $buttons[1] = (object) [
                                    'label' => 'Preferences',
                                    'id' => 'preferences',
                                    'link' => '#',
                                    'color' => 'green',
                                    'icon' => 'fa-cog'
                                ];

            $main = (object) ['label' => 'Edit', 'id' => 'edit', 'link' => '#'];
            $fab = (object) ['buttons' => $buttons, 'main' => $main];
        }

        $modules = ['fab', 'window', 'static'];

        return view('pages.modules.StaticPage', compact('page', 'module', 'fab', 'modules'));
    }

    public function _put(Request $request, Page $page, $module)
    {
        if (!\Auth::check() || !\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);

        $this->validate($request, [
            'name' => 'max:255',
            'link' => 'max:20',
            'icon' => 'max:255'
        ]);

        $name = null;
        $link = null;
        $icon = null;
        $content = null;
        if (isset($request->name))
            $name = $request->name;
        if (isset($request->link))
            $link = $request->link;
        if (isset($request->icon))
            $icon = $request->icon;
        if (isset($request->content))
            $content = $request->content;

        $params = [
            'name' => $name,
            'link' => $link,
            'icon' => $icon,
            'content' => $content
        ];

        $err = StaticPage::_edit($module, $page, $params);

        $errmsg = [
                    'success' => 'Static page edit was successful',
                    'error' => 'Static page edit failed'
                ];

        $response = array(
            'status' => $err,
            'message' => $errmsg[$err]
        );
        return \Response::json($response);
    }

    public function _delete(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);


        $this->validate($request, [
            'id' => 'required'
        ]);

        StaticPage::_delete($request->id, $page);

        \Session::flash('message', 'Static page successfully removed!');
        \Session::flash('alert-class', 'alert-success');

        return back();
    }
}
