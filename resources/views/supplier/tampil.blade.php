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
  <h4>Master Supplier</h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">Supplier</li>
    </ol>
  </nav>
</div>

<!--
<section class="section">
<div class="row">
<div class="col-lg-12">
<div class="card"> -->

<!--
<div class="card-body">        
  <div class="row">
    <div class="col-md-3">

        <button type="button" class="btn btn-primary editIcon2" data-bs-toggle="modal" data-bs-target="#importprodModal"><i class="ri-folder-5-line me-1"></i></button>
        <button type="button" class="btn btn-info editIcon3" data-bs-toggle="modal" data-bs-target="#addprodModal"><i class="bi bi-plus"></i></button>
        <a href="" onclick="this.href='sp_pdf'" button type="button" class="btn btn-danger" target="_blank"><i class="bi bi-file-pdf"></i></a>
        <button type="button" class="btn btn-warning"><i class="bi bi-printer"></i></button>
        <a href="" onclick="this.href='sp_export'" button type="button" class="btn btn-success" target="_blank"><i class="bi bi-file-excel"></i></a>
        
    </div>
            
    <div class="col-md-3">
      <div class="form-group">
        <select name="filter_gender" id="filter_gender" class="form-control" required>
          <option value="">Status</option>
          <option value="OK">Aktif</option>
          <option value="OFF">Non Aktif</option>
        </select>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <select name="filter_country" id="filter_country" class="form-control" required>
          <option value="">Select Kota</option>
          <option value="PONTIANAK">Pontianak</option>
          <option value="SINTANG">Sintang</option>
        </select>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group" align="left">
        <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>
        <button type="button" name="reset" id="reset" class="btn btn-default">Reset</button>
      </div>
    </div>
  
  </div>

</div> -->

<section class="section dashboard">
<div class="row">
<div class="col-lg-12">
<div class="card"> 

    <table id="customer_data" class="table table-bordered table-striped">
      <thead>
        <tr>
        <th scope="col" colspan="2">
            <select name="filter_gender" id="filter_gender" class="form-control" required>
              <option value="">-- Select Status --</option>
              <option value="OK">Aktif</option>
              <option value="OFF">Non Aktif</option>
            </select>
        </th>
        <th scope="col" colspan="1">
            <select name="filter_country" id="filter_country" class="form-control" required>
              <option value="">-- Select Kota --</option>
              <option value="PONTIANAK">Pontianak</option>
              <option value="SINTANG">Sintang</option>
            </select>
        </th>
        <th scope="col" colspan="3">
            <button type="button" name="filter" id="filter" class="btn btn-info"><i class="bi bi-filter"></i></button> 
            <button type="button" name="reset" id="reset" class="btn btn-danger"><i class="bi bi-x-lg"></i></button>

            <button type="button" class="btn btn-primary editIcon2" data-bs-toggle="modal" data-bs-target="#importprodModal"><i class="ri-folder-5-line me-1"></i></button>
            <button type="button" class="btn btn-info editIcon3" data-bs-toggle="modal" data-bs-target="#addprodModal"><i class="bi bi-plus-lg"></i></button>
            <a href="" onclick="this.href='sp_pdf'" button type="button" class="btn btn-danger" target="_blank"><i class="bi bi-file-pdf"></i></a>
            <button type="button" class="btn btn-warning"><i class="bi bi-printer"></i></button>
            <a href="" onclick="this.href='sp_export'" button type="button" class="btn btn-success" target="_blank"><i class="bi bi-file-excel"></i></a>
        </th>
        </tr>
        <tr>
        <th scope="col" width="3%">ID</th>
        <th scope="col" width="20%">Nama</th>
        <th scope="col" width="40%">Alamat</th>
        <th scope="col" width="10%">Kota</th>
        <th scope="col" width="10%">Status</th>
        <th scope="col" width="10%">Action</th>
        </tr>
      </thead>
    </table>

</div>

<!--
</div> --> 
</div>
</div>
</section>

@include('supplier.edit')
</main>

<script src="{{ asset('baru2/jquery-3.6.0.min.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  

<script type="text/javascript">      
$(function() {

  $(document).ready(function(){

    fill_datatable();

    function fill_datatable(filter_gender = '', filter_country = '')
    {
        var dataTable = $('#customer_data').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{ route('sp_index2') }}",
                data:{filter_gender:filter_gender, filter_country:filter_country}
            },
            columns: [
                { data:'id', name:'id' },
                { data:'nama', name:'nama' },
                { data:'alamat', name:'alamat' },
                { data:'kota', name:'kota' },
                { data:'status', name:'status' },
                { data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    }

    $('#filter').click(function(){
        var filter_gender = $('#filter_gender').val();
        var filter_country = $('#filter_country').val();

        if(filter_gender != '' &&  filter_gender != '')
        {
            $('#customer_data').DataTable().destroy();
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
        $('#customer_data').DataTable().destroy();
        fill_datatable();
    });

  });

      $("#add_prod_form").submit(function(e) {
          e.preventDefault();
          const fd = new FormData(this);
          $("#add_prod_btn").text('Adding...');
          $.ajax({
            url: '{{ route('sp_store') }}',
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
                  'Supplier Added Successfully!',
                  'success'
                )

                
                var oTable = $('#customer_data').dataTable();
                    oTable.fnDraw(false);

              }
              
              $("#add_prod_btn").text('Add Supplier');
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
        $.ajax({
          url: '{{ route('sp_edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#nama").val(response.nama);
            $("#alamat").val(response.alamat);
            $("#telp").val(response.telp);
            $("#kota").val(response.kota);
            $("#pic").val(response.pic);
            $("#status").val(response.status);
            $("#emp_id").val(response.id);
            const selectedtext = $('#status').val();
            if (selectedtext == "OK") {
              $('#status3').text("Aktif");
            } else {
              $('#status4').text("Tidak Aktif");
            }
          }
        });
      });

      // update employee ajax request
      $("#edit_prod_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_prod_btn").text('Updating...');
        $.ajax({
          url: '{{ route('sp_update') }}',
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
                'Supplier Updated Successfully!',
                'success'
              )
              var oTable = $('#customer_data').dataTable();
                  oTable.fnDraw(false);
            }
            $("#edit_prod_btn").text('Update Supplier');
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
              url: '{{ route('sp_delete') }}',
              method: 'delete',
              data: {id: id, _token: csrf },
              success: function(response) {
          //      console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )

                var oTable = $('#customer_data').dataTable();
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
                'Supplier Imported Successfully!',
                'success'
              )
              var oTable = $('#customer_data').dataTable();
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