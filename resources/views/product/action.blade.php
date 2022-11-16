<!--
<a href="{{ route('sp_edit',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
Edit
</a>
<a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
Delete
</a> -->
<a href="#" id="{{ $id }}" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editprodModal"><i class="bi-pencil-square h5"></i></a>
<a href="#" id="{{ $id }}" class="text-danger mx-1 deleteIcon"><i class="bi-trash h5"></i></a>		