@extends('layouts.backend.app')
@section('title', 'Create Post')
@push('css')
<!-- Bootstrap Select Css -->
<link href="{{asset('public/assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush

@section('content')

<form action="{{route('author.post.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

<div class="row clearfix">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    ADD NEW POST
                    
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
            
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="title" class="form-control" name="title">
                            <label class="form-label">Post Title</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="image">Image</label>
                            <input type="file" id="image" class="form-control" name="image">
                            
                        </div>
                    </div>
                    <div class="form-group">
                            
                            <input type="checkbox" id="publish" class="filled-in" name="status" value="1">
                            <label for="publish">publish</label>
                        
                    </div>
                    
                    

            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    CATEGORIES AND TAGS
                    
                </h2>

            </div>
            <div class="body">
        
            
                    <div class="form-group form-float">
                        <div class="form-line {{$errors->has('categories') ? 'focused error' : ''}}">
                            <label for="categories">Select Category</label>
                            <select name="categories[]" class="form-control show-tick" id="categories" data-live-search="true" multiple>
                                @foreach ($categories as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line {{$errors->has('tags') ? 'focused error' : ''}}">
                            <label for="tags">Select Tags</label>
                            <select name="tags[]" class="form-control show-tick" id="tags" data-live-search="true" multiple>
                                @foreach ($tags as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">submit</button>
                  

            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Body
                </h2>

            </div>
            <div class="body">

                <textarea name="body" id="tinymce" cols="30" rows="10"></textarea>
                
            </div>
        </div>
    </div>
</div>
</form>

@endsection
@push('js')
<!-- TinyMCE -->
<script src="{{asset('public/assets/backend/plugins/tinymce/tinymce.js')}}"></script>
<script>
    //TinyMCE
    tinymce.init({
        selector: "textarea#tinymce",
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = '{{asset('public/assets/backend/plugins/tinymce')}}';
</script>
@endpush


