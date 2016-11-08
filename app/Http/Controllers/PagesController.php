<?php

namespace App\Http\Controllers;

use App\Page;

use Illuminate\Http\Request;
use App\Http\Requests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PagesController extends Controller
{
    public function index()
    {
        if (\Auth::guest()) {
            $pages = Page::all();
            return view('pages.user', compact('pages'));
        }

        if (\Auth::user()->hasRole('admin')) {
            $pages = Page::all();
            return view('pages.index', compact('pages'));
        }
        
        $pages = \Auth::user()->administrated();
        $pages = array_merge($pages, \Auth::user()->subscribed());
        return view('pages.user', compact('pages'));
    }

    public function settings(Page $page)
    {
        if (\Auth::check() && \Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            return view('pages.settings', compact('page'));

        abort(404);
    }

    public function addAdmin(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);

        \Session::flash('message', 'Existing user name is required!');
        \Session::flash('alert-class', 'alert-danger');

        $this->validate($request, [
            'name' => 'required|exists:users'
            // 'name' => ['required' => 'Ime predmeta je obavezno!'],
        ]);

        \Session::flash('message', 'Admin added successfully!');
        \Session::flash('alert-class', 'alert-success');

        $admin = \App\User::where('name', '=', $request->name)->first();

        if ($admin !== null)
            $page->addAdmin($admin);

        return back();
    }

    public function deleteAdmin(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin' ]))
            abort(404);

        \Session::flash('message', 'Admin rights revoked successfully!');
        \Session::flash('alert-class', 'alert-success');

        $admin = \App\User::where('name', '=', $request->name)->first();
        $admin->removeRole($page->id . '.admin');

        return back();
    }

    public function addSubscriber(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);

        \Session::flash('message', 'Existing user name is required!');
        \Session::flash('alert-class', 'alert-danger');

        $this->validate($request, [
            'name' => 'required|exists:users'
            // 'name' => ['required' => 'Ime predmeta je obavezno!'],
        ]);

        \Session::flash('message', 'Subscriber added successfully!');
        \Session::flash('alert-class', 'alert-success');

        $admin = \App\User::where('name', '=', $request->name)->first();

        if ($admin !== null)
            $admin->assignRole($page->id . '.subscriber');

        return back();
    }

    public function deleteSubscriber(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin' ]))
            abort(404);

        \Session::flash('message', 'Subscriber deleted successfully!');
        \Session::flash('alert-class', 'alert-success');

        $admin = \App\User::where('name', '=', $request->name)->first();
        $admin->removeRole($page->id . '.subscriber');

        return back();
    }

    public function create(Request $request)
    {
        \Session::flash('message', 'Link length should be less than 21 character');
        \Session::flash('alert-class', 'alert-danger');

        $this->validate($request, [
            'name' => 'required|max:255',
            'id' => 'required|unique:pages|max:20'
            // 'name' => ['required' => 'Ime predmeta je obavezno!'],
        ]);

        \Session::flash('message', 'Page successfully created!');
        \Session::flash('alert-class', 'alert-success');

        $page = new Page();
        $page->name = $request->name;
        $page->id = $request->id;
        $page->save();

        $page->initialize();

        Role::create(["name" => $request->id. ".admin"]);
        Role::create(["name" => $request->id. ".subscriber"]);

        return back();
    }

    public function delete(Request $request)
    {
        $page = Page::where('id', '=', $request->id)->first();
        $page->delete();
        \Session::flash('message', 'Page successfully removed!');
        \Session::flash('alert-class', 'alert-success');

        return back();
    }

    public function editSidebar(Request $request, Page $page)
    {
        if (!\Auth::check() || !\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);

        $params = array();
        parse_str($request->data, $params);

        if (!isset($params['publicSidebarLink'])) {
            $params['publicSidebarLink'] = [];
        }

        if (!isset($params['subscriberSidebarLink'])) {
            $params['subscriberSidebarLink'] = [];
        }

        if (!isset($params['adminSidebarLink'])) {
            $params['adminSidebarLink'] = [];
        }

        $err = $page->permutateSidebar($params);
        $errmsg = [
                    'success' => 'Sidebar edit was successful',
                    'error' => 'Sidebar edit failed'
                ];

        $response = array(
            'status' => $err,
            'message' => $errmsg[$err],
        );
        return \Response::json($response);
    }
}
