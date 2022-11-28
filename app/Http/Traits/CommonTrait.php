<?php
namespace App\Http\Traits;

use Image;
use App\User;
use App\Models\BookedLesson;
use App\Models\Notification;
use Auth;
use DB;
trait CommonTrait
{
    public function imageDynamicName()
    {
        #Available alpha characters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(1000000, 9999999)
            . $characters[rand(0, 5)];
        $string = str_shuffle($pin);
        return $string;
    }

    public function categoryImageVersions($name)
    {
        $main_dir = storage_path() . '/app/public/category';
        $thumb_dir = storage_path() . '/app/public/category/thumb';
        $medium_dir = storage_path() . '/app/public/category/medium';

        if (!file_exists($thumb_dir)) {
            mkdir($thumb_dir, 0777);
            chmod($thumb_dir, 0777);
        }
        if (!file_exists($medium_dir)) {
            mkdir($medium_dir, 0777);
            chmod($medium_dir, 0777);
        }
        if (file_exists($main_dir . '/' . $name)) {
            chmod($main_dir . '/' . $name, 0777);
            Image::make($main_dir . '/' . $name)->resize(110, 110)->save($thumb_dir . '/' . $name);
            chmod($thumb_dir . '/' . $name, 0777);
            Image::make($main_dir . '/' . $name)->resize(257, 257)->save($medium_dir . '/' . $name);
            chmod($medium_dir . '/' . $name, 0777);
        }
        return $name;
    }
    public function subcategoryImageVersions($name)
    {
        $main_dir = storage_path() . '/app/public/category/categorycomplete';
        $thumb_dir = storage_path() . '/app/public/category/categorycomplete/thumb';

        if (!file_exists($thumb_dir)) {
            mkdir($thumb_dir, 0777);
            chmod($thumb_dir, 0777);
        }

        if (file_exists($main_dir . '/' . $name)) {
            chmod($main_dir . '/' . $name, 0777);
            Image::make($main_dir . '/' . $name)->resize(110, 110)->save($thumb_dir . '/' . $name);
            chmod($thumb_dir . '/' . $name, 0777);
        }
        return $name;
    }
    
    public function feedImageVersions($name)
    {
        $main_dir = storage_path() . '/app/public/feed';
        $thumb_dir = storage_path() . '/app/public/feed/thumb';

        
        if (file_exists($main_dir . '/' . $name)) {
            // chmod($main_dir . '/' . $name, 0777)->resize(500, 950)->save($main_dir . '/' . $name);
            chmod($main_dir . '/' . $name, 0777);
            Image::make($main_dir . '/' . $name)->save($main_dir . '/' . $name);
            chmod($main_dir . '/' . $name, 0777);
        }
        return $name;
    }
    public function feedVideoVersions($name)
    {
        $main_dir = storage_path() . '/app/public/feed';
        if (file_exists($main_dir . '/' . $name)) {
            chmod($main_dir . '/' . $name, 0777);
        }
        return $name;
    }
    
    public function notifications($requested_data)
    {
        //$requested_data = $request->all(); 
        $requested_data['user_id']= Auth::user()->id;
        $notification = Notification::Create([
            'sender_id' => $requested_data['user_id'],
            'receiver_id' =>$requested_data['receiver_id'],
            'lesson_id' => $requested_data['lesson_id'],
            'type' =>$requested_data['type'],
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        if ($notification) {
            return true;
        } else {
            return false;
        }
    }
    public function documentImageVersions($name)
    {
        $main_dir = storage_path() . '/app/public/user-document/';
        $thumb_dir = storage_path() . '/app/public/user-document/thumb';

        if (!file_exists($thumb_dir)) {
            mkdir($thumb_dir, 0777);
            chmod($thumb_dir, 0777);
        }

        if (file_exists($main_dir . '/' . $name)) {
            chmod($main_dir . '/' . $name, 0777);
            Image::make($main_dir . '/' . $name)->resize(110, 110)->save($thumb_dir . '/' . $name);
            chmod($thumb_dir . '/' . $name, 0777);
        }
        return $name;
    }
    
               
}
