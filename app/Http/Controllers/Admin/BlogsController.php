<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CommonTrait;
use App\Models\Blog;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    use CommonTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*get list of all blogs */
    public function getList(Request $request)
    {

        $blogs = '';
        $title = "Manage Blogs";
      
            $blogs = Blog::orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        
        return view('admin.blogs.list', compact('blogs', 'title'));

    }

    /* show a form to add blig */
    public function getAdd()
    {
        $title = "Add Blogs";
        return view('admin.blogs.add', compact('title'));

    }

    /* insert blog into Database */

    public function postAdd(Request $request)
    {
        # validation on blog name,description and image

        $rules = $this->validate($request, [
            'title' => 'required|max:255|unique:blogs,title',
            'url_title' => 'required|max:255|unique:blogs,url_title',

            'description' => 'required',
            'tag_description' => 'required',
            'tag' => 'required',

            'image' => 'required|image|max:200000',

        ]);

        # store data into database
        if (isset($request->image) && !empty($request->image)) {

            // check file extension
            $allowed = ['jpeg', 'png', 'jpg'];
            $filename = $_FILES['image']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            //upload file
            $dynamic_name = time() . '-' . $this->imageDynamicName() . '.' . $ext;
            $image = $request->file('image')->storeAs('public/category', $dynamic_name);

            if ($image) {
                $image_name = explode('/', $image);
                $saved_Image = $this->categoryImageVersions($image_name[2]);
            }

            $icon = isset($image_name[2]) ? $image_name[2] : '';
        }
        $blog = Blog::Create([
            'title' => $request->title,
            'description' => $request->description,
            'tag' => $request->tag,
            'tag_description' => $request->tag_description,
'url_title'=>$request->url_title,
            'image' => isset($icon) ? $icon : '',
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        #redirect to all blog list blog
        return redirect()->route('admin.blogs.get')->with([
            'flash_level' => 'success',
            'flash_message' => 'Blog has been added successfully.',
        ]);

    }
    
    /* show a form to edit blog */
    public function getEdit($id)
    {
        $title = "Edit blog";
        $blog = Blog::findOrFail($id);

        return view('admin.blogs.edit', compact('blog', 'title'));
    }

    /* update blog into Database */
    public function postEdit($id, Request $request)
    {
        $blog = Blog::find($id);
        $rules = $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'tag_description' => 'required',
            'tag' => 'required',
            'image' => 'image|max:200000',
            'url_title' => 'required|max:255',


        ]);

        if (isset($request->image) && !empty($request->image)) {


            // check file extension
            $allowed = ['jpeg', 'png', 'jpg'];
            $filename = $_FILES['image']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            //upload file
            $dynamic_name = time() . '-' . $this->imageDynamicName() . '.' . $ext;
            $image = $request->file('image')->storeAs('public/category', $dynamic_name);

            if ($image) {
                $image_name = explode('/', $image);
                $saved_Image = $this->categoryImageVersions($image_name[2]);
            }

            $icon = isset($image_name[2]) ? $image_name[2] : '';

       

        }

        
$image=Blog::where('id',$id)->first()->image;
        # update data
        $blog = Blog::where('id',$id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'tag' => $request->tag,
            'tag_description' => $request->tag_description,
            'image' => isset($icon) ? $icon : $image,
            'url_title'=> $request->url_title,
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        

        return redirect()->route('admin.blogs.get')->with([
            'flash_level' => 'success',
            'flash_message' => 'Blog has been updated successfully.',
        ]);
    }

    /* delete blog into Database */

    public function delete(Request $request)
    {
        $data = [];
        $blog = Blog::destroy($request->id);

        if ($blog) {
            $data["status"] = 200;
            $data["response"] = 'Blog deleted successfully.';

        } else {
            $data["status"] = 400;
            $data["response"] = 'There was an error while deleting blog.';
        }
        echo json_encode($data);
    }

    /* chnage status blog  */

    public function status(Request $request)
    {
        $data = [];
        $blog = Blog::find($request->id);
// return $blog;
        # update data
        $blog = $blog->update(['status' => $request->status]);
        if ($blog) {
            if ($request->status == 1) {

                $data["status"] = 200;
                $data["response"] = 'blog enabled sucessfully.';
            } else {

                $data["status"] = 200;
                $data["response"] = 'Blog disabled sucessfully.';
            }

        } else {
            $data["status"] = 400;
            $data["response"] = 'There was an error while stuats change blog.';
        }

        echo json_encode($data);
    }

}
