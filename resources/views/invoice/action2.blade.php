<!--
<a href="{{ route('sp_edit',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
Edit
</a>
<a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
Delete
</a> -->

<!-- <a href="#" id="{{ $id }}" class="btn btn-primary btn-sm  uploadIcon" title="Upload image" data-bs-toggle="modal" data-bs-target="#uploadprodModal"><i class="bi bi-upload"></i></a> -->
<?php  $level = auth()->user()->level;	 ?>
@if ($level == 4)
    @if($qty > 0 )
        <a href="#" id="{{ $id }}" class="btn btn-danger btn-sm deleteIcon" title="Delete Record"><i class="bi bi-trash"></i></a>
    @endif
@elseif ($level == 5)
    @if ($status == "RUSAK") 
        <a href="#" id="{{ $id }}" class="btn btn-primary btn-sm  uploadIcon" title="Upload image" data-bs-toggle="modal" data-bs-target="#uploadprodModal"><i class="bi bi-upload"></i></a>
 
        @if($tally > 0)
          <a href="#" id="{{ $id }}" class="btn btn-danger btn-sm deleteIcon" title="Delete Record"><i class="bi bi-trash"></i></a>
        @endif

        @if (!empty($image1))
            <a href='{{  asset('storage/images/' . $image1 . '') }}' target='_blank'>
            <img src="{{  asset('storage/images/' . $image1 . '') }}" id="gambar_upload1" alt="" class="profile.img_1" width='50' height='32' halign='center'></a>
        @endif

        @if ($image2 <>"")
            <a href='{{  asset('storage/images/' . $image2 . '') }}' target='_blank'>
            <img src="{{  asset('storage/images/' . $image2 . '') }}" id="gambar_upload1" alt="" class="profile.img_1" width='50' height='32' halign='center'></a>
        @endif
    @else
        @if($tally > 0)
          <a href="#" id="{{ $id }}" class="btn btn-danger btn-sm deleteIcon" title="Delete Record"><i class="bi bi-trash"></i></a>
        @endif
    @endif


@endif