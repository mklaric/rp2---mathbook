<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageTest;
use App\PageModule;
use App\PageSidebarLink;
use App\Task;
use App\Fileentry;
use App\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class PageTestsController extends Controller
{
    public function _get(Request $request, Page $page, $module)
    {
        return $this->show($page, $module);
    }

    public function show($page, $module)
    {
        if (\Auth::guest())
            abort('404');
        $test = PageTest::where('id', '=', $module->id)->first();
        $tasks = $test -> tasks;
        $subscribers = $page -> subscribers();
        $i = 0;
        foreach ($tasks as $task)
        {
            $i = $i+1;
        }
        $count = $i;

        if (\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
        {
            if(!$test->isSetTest)
                return view('pages.modules.test.PageTestAdminSet', compact('page', 'module'));
            else if($test->isSetTest && $test->numTasks > 0)
                return view('pages.modules.test.PageTestAdmin', compact('page', 'module', 'test'));
            else
                return view('pages.modules.test.PageTestAdminShowFiles', compact('page', 'test', 'subscribers', 'tasks', 'count'));
        }

        if (\Auth::user()->hasRole($page->id . '.subscriber'))
        {
            if(!$test->isSetTest)
                return view('pages.modules.test.PageTestSubscriberNoTest', compact('page', 'module'));
            else if($test->isSetTest && $test->numTasks > 0)
                return view('pages.modules.test.PageTestSubscriberTest', compact('page','module','tasks'));
            else
                return view('pages.modules.test.PageTestSubscriberTestFinish', compact('page'));

        }
    }

    public function create(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);

        \Session::flash('message', 'Link length should be less than 21 character');
        \Session::flash('alert-class', 'alert-danger');

        $this->validate($request, [
            'name' => 'required|max:255',
            'link' => 'required|max:20',
            'page_id' => 'required'
        ]);

        \Session::flash('message', 'Test page successfully created!');
        \Session::flash('alert-class', 'alert-success');

        $p = new PageTest();
        $p->link = $request->link;
        $p->isSetTest = false;
        $p->numTasks = 0;

        $config = [
            'immutable' => false,
            'type' => 'subscriber',
            'name' => $request->name,
            'link' => $request->link,
            'icon' => 'fa-calculator'
        ];
        $page->addModule($p, $config);

        return back();
    }

    public function delete(Request $request, Page $page)
    {
        $test = PageTest::where('id', '=', $request->id)->first();
        $tasks = $test-> tasks;
        $user = \Auth::user();
        foreach($tasks as $task)
        {
            \Storage::disk('local')->delete('pages/' . $page->id . '/tests/' . $test->link . '/' . $user->id . '/' . $task->id . '/solution.zip');
        }
        $path = storage_path('app/pages/' . $page->id . '/tests/');
        $success = File::deleteDirectory($path);
        PageModule::where('id', '=', $test->page_module_id)->delete();
        Task::where('page_test_id','=', $test->id)->delete();
        PageSidebarLink::where('page_module_id', '=', $test->page_module_id)->delete();
        $test->delete();

        \Session::flash('message', 'Tests page successfully removed!');
        \Session::flash('alert-class', 'alert-success');

        return back();
    }

    public function generateTest(Page $page, Request $request)
    {
        if(!isset($request->NumOfTasks) || (intval($request->NumOfTasks) < 1 || intval($request->NumOfTasks) > 50 ))
        {
            \Session::flash('message', 'Test has to have between 1 and 50 tasks');
            \Session::flash('alert-class', 'alert-danger');
            return back();
        }
    	$test = PageTest::where('id', '=', $request->test_id)->first();
        $test->numTasks = $request->NumOfTasks;
        $test->isSetTest = false;
        $test->save();
        return view('pages.modules.test.PageTestAdminTasksTest', compact('page','test'));
    }

    public function generateTextofTasks(Page $page, Request $request)
    {
        $test = PageTest::where('id', '=', $request->test_id)->first();
        $num = $test->numTasks;

        for($i = 0; $i < $num; $i++)
        {
            $j = 'tekst' . (string)($i+1);
            $t = new Task();
            $t->page_test_id = $test->id;
            $t->content = $request->input($j);
            $t->save();
        }

        $test->isSetTest = true;
        $test->save();
        return view('pages.modules.test.PageTestAdmin', compact('page','test'));
    }

    public function showUploadedFiles(Page $page, Request $request)
    {
        $test = PageTest::where('id', '=', $request->test_id)->first();
        $subscribers = $page -> subscribers();
        $tasks = $test -> tasks;
        $i = 0;
        foreach ($tasks as $task)
        {
            $i = $i+1;
        }
        $test->isSetTest = true;
        $test->numTasks = -100;
        $test->save();
        $count = $i;
        return redirect('pages/' . $page->id . '/' . $test->link);
    }

    public function addFile(Request $request, Page $page)
    {

        $this->validate($request, [
            'filefield' => 'required|mimes:zip',
        ]);

        \Session::flash('message', 'File successfully uploaded!');
        \Session::flash('alert-class', 'alert-success');


        $test = PageTest::where('id', '=', $request->test_id)->first();
        $user = \Auth::user();
        $file = $request->filefield;
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put('pages/' . $page->id . '/tests/' . $test->link . '/' . $user->id . '/' . $request->task_id . '/' . 'solution.zip',  File::get($file));
        $entry = new Fileentry();
        $entry->mime = $file->getClientMimeType();
        $entry->original_filename = $file->getClientOriginalName();
        $entry->filename = $file->getFilename().'.'.$extension;
        $entry->user_id = $user->id;
        $entry->task_id = $request->task_id;

        $entry->save();

        return back();
    }

    public function showFile(Page $page, User $user, Task $task)
    {

        $zip = Fileentry::where('task_id', '=', $task->id)->where('user_id', '=', $user->id)->first();
        if($zip === null)
        {
            \Session::flash('message', 'File is not uploaded by subscriber');
            \Session::flash('alert-class', 'alert-danger');
            return back();
        }
        $test = PageTest::where('id', '=', $task->page_test_id)->first();
        $link = $test->link;
        $path = storage_path('app/pages/' . $page->id . '/tests/'. $link . '/' . $user->id . '/' . $task->id . '/solution.zip' );
        return Response::download($path);
    }

}
