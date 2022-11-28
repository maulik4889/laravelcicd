<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feed\CreateFeedRequest;
use App\Http\Requests\Feed\DeleteCommentRequest;
use App\Http\Requests\Feed\FeedCommentRequest;
use App\Http\Requests\Feed\FeedLikeRequest;
use App\Http\Requests\Feed\FeedReportRequest;
use App\Http\Traits\CommonTrait;
use App\Http\Traits\UserTrait;
use App\Interfaces\FeedInterface;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\PostReport;
use App\Models\UserInterest;
use App\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Response;

class FeedsController extends Controller implements FeedInterface
{
    use CommonTrait, UserTrait;

    // this function is used for save post feed data
    public function createFeeds(CreateFeedRequest $request)
    {
        $requested_data = $request->all();
        if (isset($request->image) && !empty($request->image)) {
            // check file extension
            $allowed = ['jpeg', 'png', 'jpg', 'mp4', 'wmv'];
            $filename = $_FILES['image']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            //upload file
            $dynamic_name = time() . '-' . $this->imageDynamicName() . '.' . $ext;
            //dd($ext);
            $image = $request->file('image')->storeAs('public/feed', $dynamic_name);
            if ($image) {
                $image_name = explode('/', $image);
                if ($ext == "mp4") {
                    $type = 1;
                    $saved_Image = $this->feedVideoVersions($image_name[2]);

                } elseif ($ext == "wmv") {
                    $type = 1;
                    $saved_Image = $this->feedVideoVersions($image_name[2]);

                } else {
                    $type = 2;
                    $saved_Image = $this->feedImageVersions($image_name[2]);

                }
            }
            $feed_image = isset($image_name[2]) ? $image_name[2] : '';
        }

        $caption = isset($request->caption) ? $request->caption : '';
        $create_feed = Post::Create([
            'user_id' => $request['data']['id'],
            'caption' => $caption,
            'description' => $request->description,
            'image' => isset($feed_image) ? $feed_image : '',
            'type' => isset($type) ? $type : '',
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        if ($create_feed) {
            $data = \Config::get('success.create_post');
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $error = \Config::get('error.create_post');
            $error['data'] = (object) [];
            return Response::json($error);
        }
    }

    // this function is used when someone like the post and save their details into database
    public function feedLikes(FeedLikeRequest $request)
    {
        $requested_data = $request->all();
        $job_like = '';
        $comment = isset($requested_data['comment']) ? $requested_data['comment'] : '';
        $already_like = PostLike::where('post_id', $request->post_id)->where('user_id', Auth::user()->id)->count();
        if ($already_like == 1) {
            $postLike = PostLike::where('post_id', $request->post_id)->where('user_id', Auth::user()->id)->delete();
            $data = \Config::get('success.feed_like');
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $jobLike = PostLike::create([
                'post_id' => $request->post_id,
                'user_id' => $request['data']['id'],
                'status' => 1,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
            $post_owner = Post::where('id', $request->post_id)->first()->user_id;
            if (Auth::user()->id != $post_owner) {
                $requested_data['sender_id'] = Auth::user()->id;
                $requested_data['receiver_id'] = $post_owner;
                $requested_data['lesson_id'] = 0;
                $requested_data['type'] = 6; //sent a job invite .
                $notification = $this->notifications($requested_data);
            }
            $data = \Config::get('success.feed_like');
            $data['data'] = (object) [];
            return Response::json($data);
        }

    }

    // this function is used for fetch each post likes

    public function getFeedLikes(FeedLikeRequest $request)
    {
        $get_post_like = PostLike::where('post_id', $request->feed_id)
            ->where('status', 1)
            ->with('user')
            ->orderBy('created_at', 'desc')->paginate(\Config::get('variable.page_per_record'));
        if ($get_post_like) {
            $data = \Config::get('success.get_likes');
            $data['data'] = $get_post_like;
        } else {
            $data = \Config::get('error.get_likes');
            $data['data'] = (object) [];
        }
        return Response::json($data);
    }

    
    
    
    // this function is used for fetch feeds posted by me 
    public function myFeeds(Request $request)
    {
        $my_feeds = Post::where('user_id', $request['data']['id'])
            ->select('id', 'user_id', 'image', 'type', 'description', 'caption', 'created_at')
            ->with(['user',
                'comments.user'])
            ->withCount(['likes', 'myLikes'])->withCount(['comments'])->
            orderBy('created_at', 'desc')->paginate(50);
        if ($my_feeds) {
            $data = \Config::get('success.fetch_feed');
            $data['data'] = $my_feeds;
            $data['auth_user_id'] = Auth::user()->id;
        } else {
            $data = \Config::get('error.fetch_feed');
            $data['data'] = (object) [];
        }
        return Response::json($data);
    }

    // this function is used when someone report any feed post
    public function feedReport(FeedReportRequest $request)
    {
        $feed_report = PostReport::create([
            'reported_by' => Auth::user()->id,
            'post_id' => $request->feed_id,
            'reason' => '',
            'comment' => $request->comment,
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        if ($feed_report) {
            $data = \Config::get('success.feed_report');
            $data['data'] = $feed_report;
        } else {
            $data = \Config::get('error.feed_report');
            $data['data'] = (object) [];
        }
        return Response::json($data);
    }

    // this function is used when someone comments on feed post and save their details into database
    public function feedComment(FeedCommentRequest $request)
    {
        $requested_data = $request->all();
        $post_id = $requested_data['post_id'];
        $comment = $requested_data['comment'];
        if ($request->comment_id != 0) {

            $userPostComment = PostComment::where('id', $request->comment_id)->update(['comment' => $request->comment]);
        } else {

            $userPostComment = PostComment::create([
                'post_id' => $post_id,
                'user_id' => Auth::user()->id,
                'comment' => $comment,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
            $post_owner = Post::where('id', $request->post_id)->first()->user_id;
            if (Auth::user()->id != $post_owner) {
                $requested_data['sender_id'] = Auth::user()->id;
                $requested_data['receiver_id'] = $post_owner;
                $requested_data['lesson_id'] =0;
                $requested_data['type'] = 9; //sent a job invite .
                $notification = $this->notifications($requested_data);
            }
        }
        if ($userPostComment) {
            $data = \Config::get('success.post_comment_created');
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $data = \Config::get('error.post_comment_created');
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }
 // this function is used for get each post comments
    public function getPostComment(FeedLikeRequest $request)
    {
        $requested_data = $request->all();
        $getPostComment = PostComment::where('post_id', $requested_data['feed_id'])
            ->with(['user', 'posts'])->orderBy('created_at', 'desc')
            ->paginate(\Config::get('variable.page_per_record'));

        if ($getPostComment) {
            $data = \Config::get('success.get_comments');
            $data['data'] = $getPostComment;
            return Response::json($data);
        } else {
            $data = \Config::get('error.get_comments');
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }
    //this is used when someone delete thier comment from post
    public function deletePostComment(DeleteCommentRequest $request)
    {
        $deletePostComment = PostComment::where('user_id', $request['data']['id'])->where('id', $request->comment_id)->delete();
        if ($deletePostComment) {
            $data = \Config::get('success.delete_comments');
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $data = \Config::get('error.delete_comments');
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }

    // this function is used for delete single feed post 
    public function deleteFeed(Request $request)
    {
        $delete_feed = Post::where('id', $request->post_id)->delete();
        if ($delete_feed) {
            $data['status'] = 200;
            $data['message'] = "Feed delete successfully";
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $data['status'] = 400;
            $data['message'] = "Error in deleting feed";
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }

    // This is used for show single feed post data in user profile section
    public function singleFeedDetail(Request $request)
    {
        $get_detail = Post::where('id', $request->post_id)->first();
        $data['status'] = 200;
        $data['message'] = "Feed delete successfully";
        $data['data'] = $get_detail;
        $data['data']['feed_image'] = str_replace("https://actiskillserver.golivestaging.com/storage/feed/", "", $get_detail->image);

        return Response::json($data);

    }

    // this is for used for edit the post
    public function editFeed(Request $request)
    {
        $get_image = Post::where('id', $request->post_id)->first()->image;
        $feed_image = str_replace("https://matutto.com/backend/storage/feed/", "", $get_image);
        $type = Post::where('id', $request->post_id)->first()->type;
        $requested_data = $request->all();
        if (isset($request->image) && !empty($request->image)) {
            // check file extension
            $allowed = ['jpeg', 'png', 'jpg', 'mp4', 'wmv'];
            $filename = $_FILES['image']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            //upload file
            $dynamic_name = time() . '-' . $this->imageDynamicName() . '.' . $ext;
            //   dd($ext);

            $image = $request->file('image')->storeAs('public/feed', $dynamic_name);
            if ($image) {
                $image_name = explode('/', $image);
                $saved_Image = $this->feedImageVersions($image_name[2]);
            }
            $feed_image = isset($image_name[2]) ? $image_name[2] : '';
            if ($ext == "mp4") {
                $type = 1;
            } elseif ($ext == "wmv") {
                $type = 1;
            } else {
                $type = 2;
            }
        }
        $caption = isset($request->caption) ? $request->caption : '';
        $description = isset($request->description) ? $request->description : '';

        $create_feed = Post::where('id', $request->post_id)->update([
            'user_id' => $request['data']['id'],
            'caption' => $caption,
            'image' => $feed_image,
            'type' => $type,
            'description' => $description,

            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        if ($create_feed) {
            $data['message'] = 'Changes saved';
            $data['status'] = 200;

            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $error = \Config::get('error.create_post');
            $error['data'] = (object) [];
            return Response::json($error);
        }
    }
    //this is for fetch trending feeds on the platform
    public function trendingFeeds(Request $request)
    {

        $trending_feeds = Post::
            select('id', 'user_id', 'image', 'type', 'caption', 'description', 'created_at')
            ->with(['user',
                'comments.user'])->doesnthave('hideJobs')->whereBetween('created_at', [strtotime("-7 day"), time()])
            ->withCount(['likes', 'myLikes', 'follow'])->withCount(['comments'])->
            orderBy('likes_count', 'desc')->paginate(20);
        if ($trending_feeds) {
            $data = \Config::get('success.fetch_feed');
            $data['data'] = $trending_feeds;
            $data['auth_user_id'] = Auth::user()->id;
        } else {
            $data = \Config::get('error.fetch_feed');
            $data['data'] = (object) [];
            $data['auth_user_id'] = Auth::user()->id;

        }
        return Response::json($data);
    }

    //this is for fetch feeds related to my interest
    public function myInterestFeeds(Request $request)
    {
        $my_intersts = UserInterest::where('user_id', Auth::user()->id)->pluck('interest_id');
        $my_intersts_cat = Category::whereIn('id', $my_intersts)->pluck('title');

        $interest_feeds = Post::whereIn('caption', $my_intersts_cat)->
            select('id', 'user_id', 'image', 'type', 'caption', 'description', 'created_at')
            ->with(['user',
                'comments.user'])->doesnthave('hideJobs')
            ->withCount(['likes', 'myLikes', 'follow'])->withCount(['comments'])->
            orderBy('created_at', 'asc')->paginate(20);
        if ($interest_feeds) {
            $data = \Config::get('success.fetch_feed');
            $data['data'] = $interest_feeds;
            $data['auth_user_id'] = Auth::user()->id;

        } else {
            $data = \Config::get('error.fetch_feed');
            $data['data'] = (object) [];
        }
        return Response::json($data);
    }

    //this is for used someone edit their comments on post
    public function editComment(Request $request)
    {
        $edit_comment = PostComment::where('id', $request->comment_id)->update(['comment' => $request->comment, 'updated_at' => time()]);
        if ($edit_comment) {
            $data = \Config::get('success.delete_comments');
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $data = \Config::get('error.delete_comments');
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }

    // this is used for get single comment details by comment id
    public function getSingleComment(Request $request)
    {
        $get_comment = PostComment::where('id', $request->comment_id)->first();
        // dd($request->comment_id);
        if ($get_comment) {
            $data = \Config::get('success.delete_comments');
            $data['data'] = $get_comment;
            return Response::json($data);
        } else {
            $data = \Config::get('error.delete_comments');
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }

}
