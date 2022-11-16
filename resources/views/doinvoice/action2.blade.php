<!--
<a href="{{ route('sp_edit',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
Edit
</a>
<a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
Delete
</a> -->

<a href="#" id="{{ $id }}" class="btn btn-primary btn-sm  uploadIcon" title="Upload image" data-bs-toggle="modal" data-bs-target="#uploadprodModal"><i class="bi bi-upload"></i></a>
<a href="#" id="{{ $id }}" class="btn btn-danger btn-sm deleteIcon" title="Delete Record"><i class="bi bi-trash"></i></a>

@if( $image1 )
<a href="{{ asset('storage/images/'. $image1 .'') }}" id="{{ $id }}" class="btn btn-info btn-sm" title="Image1" target="_blank"><i class="bx bx-image"></i></a>&nbsp;
@endif

@if( $image2 )
<a href="{{ asset('storage/images/'. $image2 .'') }}" id="{{ $id }}" class="btn btn-success btn-sm" target="_blank"><i class="bx bx-image"></i></a>&nbsp;
@endif