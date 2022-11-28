<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /* get list of all pages */

    public function getList()
    {

        $pages = '';
        $title = "Manage pages";
        $delete_latest_id = Page::where('meta_key', 'delete_account')->latest()->first();
        $policy_latest_id = Page::where('meta_key', 'privacy_policy')->latest()->first();
        $term_latest_id = Page::where('meta_key', 'term')->latest()->first();
        $pages = Page::orderBy('created_at', 'desc')->paginate(\Config::get('variable.page_per_record'));
        return view('admin.pages.list', compact('pages', 'title', 'delete_latest_id', 'policy_latest_id', 'term_latest_id'));
    }

    /* show a form to add pages */

    public function getAdd()
    {
        $title = "Add page";

        return view('admin.pages.add', compact('title'));
    }

    /* insert pages into Database */

    public function postAdd(Request $request)
    {
        # validation on pages name

        $rules = $this->validate($request, [
            //  'name'      => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:pages,meta_key',
            'name' => 'required|max:255|unique:pages,meta_key',
            'content' => 'required',
        ]);

        $created_at = strtotime("now");
        # store data into database

        $pages = Page::Create([
            'meta_key' => $request->name,
            'meta_value' => $request->content,
            'status' => 1,
            'created_at' => $created_at,
        ]);

        #redirect to all pages list page
        return redirect()->route('admin.pages.get')->with([
            'flash_level' => 'success',
            'flash_message' => 'Page has been added successfully.',
        ]);
    }

    /* show a form to edit pages */

    public function getEdit($id)
    {
        $title = "Edit page";

        $pages = Page::findOrFail($id);

        return view('admin.pages.edit', compact('pages', 'title'));
    }

    /* update pages into Database */

    public function postEdit($id, Request $request)
    {
        $pages = Page::find($id);
        # validate required & unique pages name & required content
        $rules = $this->validate($request, [
            'name' => 'required|max:255',
            'content' => 'required',
        ]);
        $created_at = strtotime("now");
        $version = (int) $pages->version;
        $new_version = ++$version;

        # update data
        //         $pages = $pages->update([
        //                'meta_key' => $request->name,
        //                'meta_value' => $request->content
        //              ]);
        if ($request->name == 'privacy_policy') {
            $name = 'Privacy Policy';
        } elseif ($request->name == 'term') {
            $name = 'Terms & Conditions';
        } elseif ($request->name == 'delete_account') {
            $name = 'Delete Account';
        }
        $pages = Page::Create([
            'version' => $new_version,
            'meta_key' => $request->name,
            'name' => $name,
            'meta_value' => $request->content,
            'status' => 1,
            'created_at' => $created_at,
        ]);

        if ($request->name == 'privacy_policy') {
            User::where('role_id', '!=', 1)->update([
                'subscribed_privacy_policy' => '',
            ]);
        } elseif ($request->name == 'term') {
            User::where('role_id', '!=', 1)->update([
                'subscribed_term_condition' => '',
            ]);
        }

        return redirect()->route('admin.pages.get')->with([
            'flash_level' => 'success',
            'flash_message' => 'Page has been updated successfully.',
        ]);
    }

    /* delete pages into Database */

    public function delete(Request $request)
    {
        $data = [];
        $pages = Page::destroy($request->id);

        if ($pages) {
            $data["status"] = 200;
            $data["response"] = 'Page deleted successfully.';
        } else {
            $data["status"] = 400;
            $data["response"] = 'There was an error while deleting pages.';
        }
        echo json_encode($data);
    }

    /* chnage status pages  */

    public function status(Request $request)
    {
        $data = [];
        $pages = Page::find($request->id);

        # update data
        $pages = $pages->update(['status' => $request->status]);

        if ($pages) {
            $data["status"] = 200;
            $data["response"] = 'Page Status Chnaged successfully.';
        } else {
            $data["status"] = 400;
            $data["response"] = 'There was an error while stuats change page.';
        }
        echo json_encode($data);
    }

    public function getPageData($version, $slug)
    {
        $v = explode("v", $version);
        $post = Page::where('meta_key', $slug)
            ->latest()
            ->first();
        return view('pages.page', ['post' => $post]);
    }

}
