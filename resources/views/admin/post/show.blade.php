@extends('layouts.backend.app')
@section('title', 'Create Post')
@push('css')


@section('content')

<a class="btn btn-info mb-5" href="{{Route('admin.post.index')}}">back</a>
@if($post->is_approved == 0)
    <button type="button" class="btn btn-warning pull-right" onclick="approvePost({{$post->id}})">
        <i class="material-icons">done</i>
        <span>Approve</span>
    </button>

<form method="POST" action="{{route('admin.post.approve',$post->id)}}" id="approval-from" style="display: none">
    @csrf
    @method('PUT')
</form>
@else
<button type="button" class="btn btn-success pull-right" disabled>
    <i class="material-icons">done</i>
    <span>Approved</span>
</button>

@endif
<br><br>
<div class="row clearfix">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2 style="color: #000">
                {{$post->title}} <small><strong>Posted By : <a href="">{{$post->user->name}}</a></strong> On {{$post->created_at}}</small>
                    
                </h2>

            </div>
            <div class="body">

                {!!$post->body!!}
            
                    
                    

            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                    CATEGORIES
                </h2>
            </div>
            <div class="body">
                
               @foreach ($post->categories as $item)
                  <span class="label bg-cyan">{{$item->name}}</span>
               @endforeach

            </div>
        </div>

      
        <div class="card">
            <div class="header bg-green">
                <h2>
                    Tags 
                    
                </h2>

            </div>
            <div class="body">
                
               @foreach ($post->tags as $item)
                  <span class="label bg-green">{{$item->name}}</span>
               @endforeach

                  

            </div>
        </div>

              
        <div class="card">
            <div class="header bg-green">
                <h2>
                    Image 
                    
                </h2>

            </div>
            <div class="body">
                
            <img class="img-responsive thumbnail" src="{{asset('public/image/post/'.$post->image)}}" alt="">

                  

            </div>
        </div>

    </div>
</div>


@endsection
@push('js')
<!-- TinyMCE -->
<script src="{{asset('public/assets/backend/plugins/tinymce/tinymce.js')}}"></script>
<script src="{{asset('public/js/sweetalert.min.js')}}"></script>


<script type="text/javascript">
    function approvePost(id){
        const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: true
})

swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You Wanted to approve this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, approve it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    event.preventDefault();
    document.getElementById('approval-from').submit();
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'This Post remain Pending :)',
      'info'
    )
  }
});
    }

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


