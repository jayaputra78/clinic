<!--
<a href="{{ route('sp_edit',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
Edit
</a>
<a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
Delete
</a> -->
<!-- <a href="#" id="{{ $id }}" class="text-danger mx-1 deleteIcon"><i class="bi-trash h5"></i></a>	 -->

<a href="{{ route('doinvoice_index2', ['id' => $id, 'supplier_id' => $supplier_id]) }}" class="text-success mx-1"><i class="bi-pencil-square h5"></i></a>
<!-- <a href="doinvoice_print/'. $emp->id . '" target="_blank" id="' . $emp->id . '" class="text-danger mx-1 printIcon"><i class="bi-printer h4"></i></a> -->

<a href="#" id="{{ $id }}" title="Upload image" data-bs-toggle="modal" data-bs-target="#uploadprodModal" class="text-info mx-1 uploadIcon"><i class="bi bi-upload h5"></i></a>

@if( $image1 )
<a href="{{ asset('storage/images/'. $image1 .'') }}" id="{{ $id }}" title="Image1" target="_blank" class="text-primary mx-1"><i class="bi bi-card-image h5"></i></a>&nbsp;
@else
<i class="bi bi-three-dots h5"></i>&nbsp;
@endif

@if ( $item==0 )
<a href="#" id="{{ $id }}" class="text-danger mx-1 deleteIcon"><i class="bi-trash h5"></i></a>
@endif