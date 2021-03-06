<?php

namespace App\Http\Controllers\Author;

use App\Tag;
use App\Post;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\PostUpdateRequest;
use App\Http\Requests\Admin\PostValidationRequest;
use App\Notifications\NewAuthorPost;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::User()->posts()->latest()->get();
        return view('author.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostValidationRequest $request)
    {
        if($request->hasFile('image')){
            //get form image
           $image = $request->file('image');
           $slug = Str::slug($request->title);
           $current_date = Carbon::now()->toDateString();
           //get unique name for image
           $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();
           //location for new image 
           $image_location = public_path('image/post/'.$image_name);
           //resize image for category and upload temp 
           $post_image = Image::make($image)->resize(1600,1066)->save($image_location);

       }
        $post = new Post;
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->image = $image_name;
        $post->body = $request->body;
        if(isset($request->status)){
            $post->status = $request->status;
        }else{
            $post->status = 0;
        }
        $post->is_approved = 0;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);
        $users= User::where('role_id', 1)->get();
        Notification::send($users, new NewAuthorPost($post));
        Toastr::success('Post Inserted To Databse successful!', 'success');
        return redirect(route('author.post.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->user_id != Auth::id()){
            Toastr::error('You are not Authorized to Access this Post !', 'success');
        return redirect()->back();
        }else{
            return view('author.post.show',compact('post'));
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->user_id != Auth::id()){
        Toastr::error('You are not Authorized to Access this Post !', 'success');
        return redirect()->back();
        }else{
            $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit',compact('post','categories', 'tags'));
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        
        if($post->user_id != Auth::id()){
            Toastr::error('You are not Authorized to Access this Post !', 'success');
        return redirect()->back();
        }else{
        if($request->hasFile('image')){
            //get form image
           $image = $request->file('image');
           $slug = Str::slug($request->title);
           $current_date = Carbon::now()->toDateString();
           //get unique name for image
           $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();
           //location for new image 
           $image_location = public_path('image/post/'.$image_name);
            //Delete Old Post Image 
            $post_image_path = public_path('image/post/'.$post->image);
            
            if (File::exists($post_image_path)) {
                File::delete($post_image_path);
            }

           //resize image for category and upload temp 
           $post_image = Image::make($image)->resize(1600,1066)->save($image_location);
            

       }
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        if($request->hasFile('image')){
            $post->image = $image_name;
        }else{
            $post->image =  $post->image;
        }
        $post->body = $request->body;
        if(isset($request->status)){
            $post->status = $request->status;
        }else{
            $post->status = 0;
        }
        $post->is_approved = 0;
        $post->update();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post Updated To Databse successful!', 'success');
        return redirect(route('author.post.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        
        if($post->user_id != Auth::id()){
            Toastr::error('You are not Authorized to Access this Post !', 'success');
        return redirect()->back();
        }else{
        $post_image_path = public_path('image/post/'.$post->image);

        if (File::exists($post_image_path)) {
            File::delete($post_image_path);
        }       
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Post Deleted successful!', 'success');
        return redirect(route('author.post.index'));
    }
}
}
