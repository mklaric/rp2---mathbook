<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Page;
use App\StaticPage;
use App\PageModule;
use App\PageSidebarLink;
use App\PageResult;
use App\Result;

use Illuminate\Http\Request;
use App\Http\Requests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class PageResultsController extends Controller
{
    public function _get(Request $request, Page $page, $module)
    {
        if (\Auth::guest())
            abort('404');
        return $this->show($page);
    }

    public function show(Page $page)
    {
        //when opening results, admins and users get different pages

        if (\Auth::user()->hasRole('admin')) {
            return view('pages.results.admins', compact('page'));
        }
        if (\Auth::check()){
        	return view('pages.results.users', compact('page'));
        }

    }

    public function showFile(Page $page, $fileid )
    {
        if (\Auth::guest())
            abort('404');
        try {
            $result = Result::where('id', '=', $fileid)->first();
            $filename = $result->original_filename;
            $path = storage_path('app/pages/' . $page->id . '/results/'. $filename);
            $ime=$result->link;

            if($result->mime==='text/csv')
            {
                $contents = Storage::disk('local')->get('pages/' . $page->id . '/results/'. $filename);
                $modules = ['csvtable'];
                return view('pages.results.overview', compact('page','contents','modules','ime'));
            }
            else if($result->mime==='application/pdf')
            {
                return Response::make(file_get_contents($path), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$filename.'"'
                ]);
            }
            else
            {
                return Response::download($path, $filename);
            }
        } catch (\Exception $e) {
            abort('404');
        }
    }

    public function AddResult(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);

        $file = $request->filefield;
        $extension = $file->getClientOriginalExtension();

        \Session::flash('message', 'This should be csv,txt od pdf file');
        \Session::flash('alert-class', 'alert-danger');

        $this->validate($request, [
            'filefield' => 'required|mimes:csv,txt,pdf',
        ]);

        \Session::flash('message', 'Result successfully uploaded!');
        \Session::flash('alert-class', 'alert-success');

        Storage::disk('local')->put('pages/' . $page->id . '/results/'. $file->getClientOriginalName(),  File::get($file));


        $res = new Result();
        $res->link=$request->link;
        $res->page_result_id=$page->resultPages()->id;
        $res->mime = $file->getClientMimeType();
        $res->original_filename = $file->getClientOriginalName();
        $res->filename = $file->getFilename().'.'.$extension;
        $page->resultPages()->results()->save($res);
        if($request->notif ==="") $page->addPageNotification("Stigli rezultati");
            else $page->addPageNotification($request->notif);

        return back();

    }

    public function deleteResult(Request $request, Page $page)
    {
        if (!\Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
            abort(404);

        $result = Result::where('id', '=', $request->res_id)->first();
        Storage::disk('local')->delete('pages/' . $page->id . '/results/'. $result->original_filename);
        $result->delete();

        \Session::flash('message', 'Result successfully removed!');
        \Session::flash('alert-class', 'alert-success');

        return back();
    }
}
