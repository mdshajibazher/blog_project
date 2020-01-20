<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  
       
        $categories = Category::latest()->get();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        
        if($request->hasFile('image')){
            //get form image
           $image = $request->file('image');
           $slug = Str::slug($request->name);
           $current_date = Carbon::now()->toDateString();
           //get unique name for image
           $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();
           //location
           $category_location = public_path('image/category/'.$image_name);
           $slider_location = public_path('image/slider/'.$image_name);

           //resize image for category and upload
           $category_image = Image::make($image)->resize(1600,479)->save($category_location);
           $slider_image = Image::make($image)->resize(500,333)->save($slider_location);

       }
        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->image = $image_name;
        $category->save();
        Toastr::success('Category added successful!', 'success');
        return redirect(route('admin.category.index'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return view('admin.category.edit', compact('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::find($id);
        if($request->hasFile('image')){
            //get form image
           $image = $request->file('image');
           $slug = Str::slug($request->name);
           $current_date = Carbon::now()->toDateString();
           //get unique name for image
           $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();
           //location
           $category_location = public_path('image/category/'.$image_name);
           $slider_location = public_path('image/slider/'.$image_name);


            
           //resize image for category and upload
           $category_image = Image::make($image)->resize(1600,479)->save($category_location);
        //    //Delete Old Category Image 
        //    if(public_path()->exists('image/category/'.$category_location->image)){
        //     public_path()->delete('image/category'.$category_location->image); 
        // }

           $slider_image = Image::make($image)->resize(500,333)->save($slider_location);
           //Delete Old Slider Image 
        //    if(public_path()->exists('image/slider'.$cacategory_locationt->image)){
        //        public_path()->delete('image/slider'.$category_location->image); 
        //    }

           $category->image = $image_name;

       }
        
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->update();
        Toastr::success('Category Updated successful!', 'success');
        return redirect(route('admin.category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
