<?php
namespace App\Http\Traits;

use App\Models\UserInterest;
use App\Models\UserCategory;
use App\Models\UserSubject;
use App\Models\UserQualificationDocument;
use App\Models\UserQualification ;
use App\Models\ScheduleLesson;
use App\Models\AvailabilityTiming;
use App\Models\TeacherAddress;
use App\User;
use Auth;
use Image;

trait UserTrait
{
    private function userImageVersions($name)
    {
        $main_dir = storage_path() . '/app/public/user';
        $thumb_dir = storage_path() . '/app/public/user/thumb';
        $medium_dir = storage_path() . '/app/public/user/medium';
$x_small=storage_path() . '/app/public/user/x_small';
        if (!file_exists($thumb_dir)) {
            mkdir($thumb_dir, 0777);
            chmod($thumb_dir, 0777);
        }
        
        if (!file_exists($medium_dir)) {
            mkdir($medium_dir, 0777);
            chmod($medium_dir, 0777);
        }
        if (!file_exists($x_small)) {
            mkdir($x_small, 0777);
            chmod($x_small, 0777);
        }


        if (file_exists($main_dir . '/' . $name)) {
            chmod($main_dir . '/' . $name, 0777);
            Image::make($main_dir . '/' . $name)->resize(60, 60)->save($thumb_dir . '/' . $name);
            chmod($thumb_dir . '/' . $name, 0777);
            Image::make($main_dir . '/' . $name)->resize(133, 133)->save($medium_dir . '/' . $name);
            chmod($medium_dir . '/' . $name, 0777);
            Image::make($main_dir . '/' . $name)->resize(40, 40)->save($x_small . '/' . $name);
            chmod($x_small . '/' . $name, 0777);
        }
        return $name;
    }

    private function getVerificationCode($length = 12)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    /* function to send a verification email */

    private function sendVerificationMail($register_data)
    {
        $email = trim($register_data["email"]);
        $admin_email = Config::get('variable.ADMIN_EMAIL');
        $frontend_url = Config::get('variable.FRONTEND_URL');
        $user = User::where('email', $email)->first();
        Mail::send('user.register', ['data' => array("verification_token" => $register_data["verification_token"], "email" => $email,
            "frontend_url" => $frontend_url, "name" => $user->name)], function ($message) use ($email, $admin_email) {
            $message->from($admin_email, 'INAR');
            $message->to(trim($email), 'INAR')->subject('INAR : Verify Account');
        });
    }
    private function userProfile($id)
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://server.profileservice.com/api/profile/getPersonalProfile', [
            'query' => ['user_id' => $id],
        ]);
        $response = $request->getBody()->getContents();
        return $response;
    }

    private function interestSkillSubjects($requested_data)
    {
        // $check=UserInterest::where('user_id',Auth::user()->id)->count();
        $check_cat=UserCategory::where('user_id',Auth::user()->id)->count();

        $check_sub=UserSubject::where('user_id',Auth::user()->id)->count();

if($check_cat==0 && $check_sub==0 )
{
        $skills  = $subjects = [];
        $submit_skills  = $submit_subjects = false;

        $subj="".$requested_data["subjects"]."";
        $subject= (explode(",",$subj));

        $skil="".$requested_data["skills"]."";
        $skill= (explode(",",$skil));

        // $inters="".$requested_data["interests"]."";
        // $interest= (explode(",",$inters));

        // if (isset($requested_data["interests"]) && !empty($requested_data["interests"])) {
        //     foreach ($interest as $data) {
        //         $interests[] = [
        //             'user_id' => Auth::user()->id,
        //             'interest_id' => $data,
        //             'status' => 1,
        //             'created_at' => time(),
        //             'updated_at' => time(),

        //         ];
        //     }
        // }
        if (isset($requested_data["skills"]) && !empty($requested_data["skills"])) {
            foreach ($skill as $data) {
                $skills[] = [
                    'user_id' => Auth::user()->id,
                    'subject_id' => $data,
                    'status' => 1,
                    'created_at' => time(),
                    'updated_at' => time(),

                ];
            }
        }

        if (isset($requested_data["subjects"]) && !empty($requested_data["subjects"])) {
            foreach ($subject as $data) {
                $subjects[] = [
                    'user_id' => Auth::user()->id,
                    'category_id' => $data,
                    'status' => 1,
                    'created_at' => time(),
                    'updated_at' => time(),

                ];
            }
        }

        $submit_skills = UserSubject::insert($skills);
        // $submit_interests = UserInterest::insert($interests);
        $submit_subjects = UserCategory::insert($subjects);

    }else {
        // $delete=UserInterest::where('user_id',Auth::user()->id)->delete();
        $delete_sub=UserSubject::where('user_id',Auth::user()->id)->delete();

        $delete_skill=UserCategory::where('user_id',Auth::user()->id)->delete();
            //return true;
            $skills  = $subjects = [];
        $submit_skills  = $submit_subjects = false;

        $subj="".$requested_data["subjects"]."";
        $subject= (explode(",",$subj));

        $skil="".$requested_data["skills"]."";
        $skill= (explode(",",$skil));

        // $inters="".$requested_data["interests"]."";
        // $interest= (explode(",",$inters));

      
        if (isset($requested_data["skills"]) && !empty($requested_data["skills"])) {
            foreach ($skill as $data) {
                $skills[] = [
                    'user_id' => Auth::user()->id,
                    'subject_id' => $data,
                    'status' => 1,
                    'created_at' => time(),
                    'updated_at' => time(),

                ];
            }
        }

        if (isset($requested_data["subjects"]) && !empty($requested_data["subjects"])) {
            foreach ($subject as $data) {
                $subjects[] = [
                    'user_id' => Auth::user()->id,
                    'category_id' => $data,
                    'status' => 1,
                    'created_at' => time(),
                    'updated_at' => time(),

                ];
            }
        }

        $submit_skills = UserSubject::insert($skills);
        // $submit_interests = UserInterest::insert($interests);
        $submit_subjects = UserCategory::insert($subjects);
        }

        if ($submit_skills  && $submit_subjects) {
            return true;
            
        } 
        else{
            return false;

        }
    }
    private function qualificationDocuments($requested_data)
    {
        $my_documents = $qualifications = [];
        $submit_qualifications = $submit_documents = false;

        if (isset($requested_data["qualifications"]) && !empty($requested_data["qualifications"])) {
            foreach ($requested_data["qualifications"] as $data) {
                $qualifications[] = [
                    'user_id' => Auth::user()->id,
                    'qualification_id' => $data['type'],
                    'status' => 1,
                    'created_at' => time(),
                    'updated_at' => time(),

                ];
            }
        }
        if (isset($requested_data["image"]) && !empty($requested_data["image"])) {
        foreach ($requested_data["image"] as $k => $file) {
            $random = rand(10,10000);
            $my_documents[] = [
                'user_id' => Auth::user()->id,
                'qualification_document' => $random.time() . '.' . $file->getClientOriginalName(),
                'created_at' => time(),
                'updated_at' => time(),
            ];
            
            $image_data[$k]['media_name'] = $random.time() . '.' . $file->getClientOriginalName();

            $destinationPath = public_path('/images/user-document');

            $image =  $file->storeAs('public/user-document', $image_data[$k]['media_name']);

             $image_name = explode('/', $image);
             $saved_Image = $this->documentImageVersions($image_name[2]);
      
        }   
    }
        $submit_qualifications = UserQualification::insert($qualifications);

        $submit_documents = UserQualificationDocument::insert($my_documents);

        if ($submit_qualifications && $submit_documents) {
            return true;
            
        } else {
            return false;
        }
    }
    private function lessonSchedules($requested_data,$lesson_id)
    {
     
        $books = json_decode($requested_data['timings']);
        //dd($books);

        foreach($books as $timing) {
            $availability_timings = AvailabilityTiming::create([
            'lesson_id' => $lesson_id,
            'from_timing' => strtotime(".$timing->start_time."),
            'to_timing' => strtotime(".$timing->end_time."),
            'status'=>1,
            'created_at' => time(),
            'updated_at' => time(),
        ]); 
        }
    if ($availability_timings) {
        return true;
        
    } else {
        return false;
    }
}

private function addAddresses($requested_data,$lesson_id)
{
        $address = TeacherAddress::create([
            'user_id' => Auth::user()->id,
            'lesson_id' => $lesson_id,
            'address' => $requested_data['address'],
            'city' => $requested_data['city'],
            'postal_code' => '',
            'lat' =>$requested_data['lat'],
            'lng' =>$requested_data['lng'],
            'status'=> 1,
            'created_at' => time(),
            'updated_at' => time(),

        ]); 
    
    //dd($address);
if ($address) {
    return true;
    
} else {
    return false;
}
}


}
