@extends('layouts.backend.app')
@section('title', 'Post')
@push('css')
<link rel="stylesheet" href="{{asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('public/css/sweetalert.min.css')}}">

@endpush

@section('content')

        <div class="block-header">
            <a class="btn btn-primary waves-effect" href="{{route('admin.post.create')}}">
                <i class="material-icons">add</i>
                <span>Create Post</span>
            </a>
        </div>

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    POSTS LIST &nbsp;<span class="badge bg-info">{{$posts->count()}}</span>
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>sl.</th>
                                    <th>Post Name</th>
                                    <th>Author</th>
                                    <th>Image</th>
                                    <th>Views</th>
                                    <th>Is Approved</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>sl.</th>
                                    <th>Post Name</th>
                                    <th>Author</th>
                                    <th>Image</th>
                                    <th>Views</th>
                                    <th>Is Approved</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php    
                                $i=1;
                                @endphp
                                @foreach ($posts as $item)


                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{Str::limit($item->title,10)}}</td>
                                    <td>{{$item->user->name}}</td>
                                <td><img width="50px" src="{{asset('public/image/post/'.$item->image)}}" alt=""></td>
                                    <td>{{$item->view_count}}</td>
                                    <td>@if($item->is_approved == 0) 
                                        <span class="badge bg-red">Pending</span>
                                        @else 
                                        <span class="badge bg-green">Approved</span>
                                        @endif
                                    </td>
                                    <td>@if($item->status == 0) 
                                        <span class="badge bg-red">Pending</span>
                                        @else 
                                        <span class="badge bg-green">Published</span>
                                        @endif</td>
                                <td style="display:inline-block">
                                    <a class="btn btn-info" href="{{route('admin.post.show',$item->id)}}"><i class="material-icons">visibility</i></a>
                                    <a class="btn btn-primary" href="{{route('admin.post.edit',$item->id)}}"><i class="material-icons">edit</i></a> 

                                     <button onclick="deletePost({{$item->id}})" class="btn btn-danger" type="submit" value="Delete" ><i class="material-icons">delete</i></button>
                                
                                    <form id="delete-from-{{$item->id}}" style="display: inline" action="{{route('admin.post.destroy',$item->id)}}" method="POST"> @csrf @method('DELETE') </form> 
                                </td>
                                </tr>
                                    
                                @endforeach
                                



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->


@endsection
@push('js')
<script src="{{asset('public/js/sweetalert.min.js')}}"></script>
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

<script type="text/javascript">
    function deletePost(id){
        const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: true
})

swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    event.preventDefault();
    document.getElementById('delete-from-'+id).submit();
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Your Data  is safe :)',
      'error'
    )
  }
});
    }
</script>
@endpush