@extends('layouts.backend.app')
@section('title', 'Category')
@push('css')
<link rel="stylesheet" href="{{asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}">
@endpush

@section('content')
<div class="row clearfix">
    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    EDIT Category
                    <small>With floating label</small>
                </h2>

            </div>
            <div class="body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                
           
            <form action="{{route('admin.category.update',$category->id )}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                    <div class="form-group form-float">
                        <div class="form-line">
                        <input type="text" id="name" class="form-control" name="name" value="{{$category->name}}">
                            <label class="form-label">Category Name</label>
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="file" id="image" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="form-group">
                    <img width="100%" src="{{asset('public/image/category/'.$category->image)}}" alt="">
                    </div>
                    
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">submit</button>
                    <a class="btn btn-danger m-t-15 waves-effect" href="{{route('admin.category.index')}}">back</a>
                </form>
            
            </div>
        </div>
    </div>
</div>


@endsection
@push('js')
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
<script src="{{asset('public/assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>
@endpush


