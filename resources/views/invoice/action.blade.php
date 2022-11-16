<!--
<a href="{{ route('sp_edit',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
Edit
</a>
<a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
Delete
</a> -->
<!-- <a href="#" id="{{ $id }}" class="text-danger mx-1 deleteIcon"><i class="bi-trash h5"></i></a>	 -->
<?php  $level = auth()->user()->level;	 ?>

@if ($level == 3)
    @if ($status == 1)
        <a href="#" id="{{ $id }}" class="text-success mx-1 editIcon" title="Penugasan Op Tally" data-bs-toggle="modal" data-bs-target="#editprodModal"><i class="bi-person h4"></i></a>
    @else    
        &nbsp<i class="text-secondary bi-person h4">&nbsp</i>
    @endif
@elseif ($level == 4)
    @if ($status == 1)
        <a href="{{ route('invinvoice_index2', ['id' => $id, 'customer_id' => $customer_id]) }}" title="Edit DO" class="text-success mx-1"><i class="bi-pencil-square h5"></i></a>
    @elseif ($status == 2)
        @if ($tally == $modal)
             <a href="#" id="{{ $id }}" title="Tagih Tally" class="text-warning mx-1 uploadIcon" data-bs-toggle="modal" data-bs-target="#uploadprodModal" class="text-info mx-1 uploadIcon"><i class="bi bi-currency-dollar h5"></i></a>
        @else
            &nbsp<i class="text-secondary bi bi-currency-dollar h5" title="Tally Belum Selesai" >&nbsp</i>
        @endif
    @elseif ($status == 3)
        <a href="{{ route('invinvoice_print2', ['id' => $id]) }}" title="Cetak Sertifikat"  target="_blank" id="' . $id . '" class="text-success mx-1 printIcon"><i class="bi bi-file-earmark-pdf-fill h5"></i></a>  
    @endif
@elseif ($level == 5)
    @if ($status == 2)
        <a href="{{ route('invinvoice_index2', ['id' => $id, 'customer_id' => $customer_id]) }}" title="Proses Tally" class="text-success mx-1"><i class="bi-badge-tm h4"></i></a>
    @else
        &nbsp<i class="text-secondary bi-badge-tm h4" title="Belum Penugasan" >&nbsp</i>
    @endif
@endif
<a href="{{ route('invinvoice_print', ['id' => $id]) }}" target="_blank" id="' . $id . '" title="Cetak Faktur / BA"  class="text-danger mx-1 printIcon"><i class="bi-printer h4"></i></a>

<!-- <a href="#" id="{{ $id }}" title="Upload image" data-bs-toggle="modal" data-bs-target="#uploadprodModal" class="text-info mx-1 uploadIcon"><i class="bi bi-upload h5"></i></a> -->

<!-- <a href="#" id="{{ $id }}" class="text-danger mx-1 deleteIcon"><i class="bi-trash h5"></i></a> -->
