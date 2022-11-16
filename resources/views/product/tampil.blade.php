@extends('layout.index')
@section('content')
@parent

<!-- ============= 
Catatan untuk modul ini ..
MOdul ini masih menggunakan manual dari data table..  
harus dilakukan perubahan pada script  location.reload(true);
======================== -->

<main id="main" class="main">

<div class="pagetitle">
  <h4>Master Product</h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">Product</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
<div class="row">
<div class="col-lg-12">
<div class="card"> 

    <table id="product_data" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th scope="col" colspan="5">
          MEMBER : {{ auth()->user()->member->name }}
        </tr>
        <tr>
        <th scope="col" colspan="2">
            <select name="filter_gender" id="filter_gender" class="form-control" required>
            <option value="">-- Select Akun Member --</option>
                <?php  $level = auth()->user()->level;	 ?>
                @if ( $level > 1 )
                    <option value="{{ Auth::user()->member->id }}">{{ Auth::user()->member->id }} - {{ Auth::user()->member->name }} </option>
                @else
                    @foreach ($members as $row)
                        <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->name }}</option>
                    @endforeach
                @endif
            </select>
        </th>
        <th scope="col" colspan="1">
            <select name="filter_country" id="filter_country" class="form-control" required>
              <option value="">-- Select Jenis --</option>
              <option value="MATERIAL">MATERIAL</option>
              <option value="PERALATAN">PERALATAN</option>
            </select>
        </th>
        <th scope="col" colspan="3">
            <button type="button" name="filter" id="filter" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter Data"><i class="bi bi-filter"></i></button> 
            <button type="button" name="reset" id="reset" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Clear Filter Data"><i class="bi bi-x-lg"></i></button>

            <button type="button" class="btn btn-primary editIcon2" data-bs-toggle="modal" data-bs-target="#importprodModal" data-bs-placement="top" title="Import"><i class="ri-folder-5-line me-1"></i></button>
            <button type="button" class="btn btn-info editIcon3" data-bs-toggle="modal" data-bs-target="#addprodModal" data-bs-placement="top" title="New Data"><i class="bi bi-plus-lg"></i></button>
            <a href="" onclick="this.href='prod_pdf'" button type="button" class="btn btn-danger" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Export PDF"><i class="bi bi-file-pdf"></i></a>
            <a href="" onclick="this.href='prod_export'" button type="button" class="btn btn-success" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Export Xls"><i class="bi bi-file-excel"></i></a>
        </th>
        </tr>
        <tr>
        <th scope="col" width="4%">ID</th>
        <th scope="col" width="10%">Kategori</th>
        <th scope="col" width="20%">Produk</th>
        <th scope="col" width="4%">Satuan</th>
        <th scope="col" width="8%">Action</th>
        </tr>
      </thead>
    </table>

</div>

<!--
</div> --> 
</div>
</div>
</section>

@include('product.edit')
</main>

<script src="{{ asset('baru2/jquery-3.6.0.min.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  

<script type="text/javascript">      
$(function() {

      $(document).ready(function(){

        fill_datatable();

        function fill_datatable(filter_gender = '', filter_country = '')
        {
            var dataTable = $('#product_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('prod_index2') }}",
                    data:{filter_gender:filter_gender, filter_country:filter_country}
                },
                columns: [
                    { data:'id', name:'id' },
                    { data:'group.description', name:'group.description' },
                    { data:'description', name:'description' },
                    { data:'satuan', name:'satuan' },
                    { data: 'action', name: 'action', orderable: false},
                ],
                fixedColumns:   {
                    left: 1,
                    right: 1
                },
                select: true,
                order: [[0, 'desc']],
                pageLength: 10
            });
        }

        $('#filter').click(function(){
            var filter_gender = $('#filter_gender').val();
            var filter_country = $('#filter_country').val();

            if(filter_gender != '' ||  filter_country != '')
            {
                $('#product_data').DataTable().destroy();
                fill_datatable(filter_gender, filter_country);
            }
            else
            {
                alert('Select Both filter option');
            }
        });

        $('#reset').click(function(){
            $('#filter_gender').val('');
            $('#filter_country').val('');
            $('#product_data').DataTable().destroy();
            fill_datatable();
        });

      });

      $("#add_prod_form").submit(function(e) {
          e.preventDefault();
          const fd = new FormData(this);
          $("#add_prod_btn").text('Adding...');
          $.ajax({
            url: '{{ route('prod_store') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.status == 200) {
                Swal.fire(
                  'Added!',
                  'Product Added Successfully!',
                  'success'
                )                
                var oTable = $('#product_data').dataTable();
                    oTable.fnDraw(false);
              }      
              $("#add_prod_btn").text('Add Cashier');
              $("#add_prod_form")[0].reset();
              $("#addprodModal").modal('hide');
              fill_datatable();
              },
              error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
              }
              
          });
      });

       // edit ajax request
       $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let group = $(this).attr('product.group.description');
        $.ajax({
          url: '{{ route('prod_edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#title").val(response.title);
            $("#description").val(response.description);
            $("#group_id").val(response.group_id);
            $("#jenis").val(response.jenis);
            $("#satuan").val(response.satuan);
            $("#emp_id").val(response.id);
          }
        });
      });

      // update employee ajax request
      $("#edit_prod_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_prod_btn").text('Updating...');
        $.ajax({
          url: '{{ route('prod_update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Product Updated Successfully!',
                'success'
              )
              var oTable = $('#product_data').dataTable();
                  oTable.fnDraw(false);
            }
            $("#edit_prod_btn").text('Update Cashier');
            $("#edit_prod_form")[0].reset();
            $("#editprodModal").modal('hide');
          },
          error: function (request, status, error) {
              alert(request.responseText);
          }
        });
      });

      // delete employee ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('prod_delete') }}',
              method: 'delete',
              data: {id: id, _token: csrf },
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                var oTable = $('#product_data').dataTable();
                  oTable.fnDraw(false);
              },
                error: function (xhr, ajaxOptions, thrownError) {
                  alert(xhr.status);
                  alert(thrownError);
                }
            });
          }
        })
      });

      // Import form
      $("#import_prod_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#import_prod_btn").text('Import...');
        $.ajax({
          url: '{{ route('sp_import') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'group Imported Successfully!',
                'success'
              )
              var oTable = $('#group_data').dataTable();
                  oTable.fnDraw(false);
            }
            $("#import_prod_btn").text('Import Supplier');
            $("#import_prod_form")[0].reset();
            $("#importprodModal").modal('hide');
          },
          error: function (request, status, error) {
              alert(request.responseText);
          }
        });
      });

});
</script>
@endsection