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
use File;


class CategoryController extends Controller
{
   
    public function index()
    {
  
       
        $categories = Category::latest()->get();

        return view('admin.category.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.category.create');
    }


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


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::find($id);

        return view('admin.category.edit', compact('category'));

    }


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
           //location for new image 
           $category_location = public_path('image/category/'.$image_name);
           $slider_location = public_path('image/slider/'.$image_name);
           //resize image for category and upload temp 
           $category_image = Image::make($image)->resize(1600,479)->save($category_location);
           $slider_image = Image::make($image)->resize(500,333)->save($slider_location);

            //Delete Old Category Image 
           $category_image_path = public_path('image/category/'.$category->image);
            $slider_image_path = public_path('image/slider/'.$category->image);
            
            if (File::exists($category_image_path)) {
                File::delete($category_image_path);
            }
                
            if (File::exists($slider_image_path)) {
                File::delete($slider_image_path);
            }

           $category->image = $image_name;

       }
        
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->update();
        Toastr::success('Category Updated successful!', 'success');
        return redirect(route('admin.category.index'));
    }



    public function destroy($id)
    {
        $category = Category::find($id);

        $category_image_path = public_path('image/category/'.$category->image);
        $slider_image_path = public_path('image/slider/'.$category->image);

        if (File::exists($category_image_path)) {
            File::delete($category_image_path);
        }
        if (File::exists($slider_image_path)) {
            File::delete($slider_image_path);

        }
        $category->delete();
        Toastr::success('Category Deleted successful!', 'success');
        return redirect(route('admin.category.index'));
    }
}
