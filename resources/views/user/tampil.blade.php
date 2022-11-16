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
  <h4>Master User</h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">User</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
<div class="row">
<div class="col-lg-12">
<div class="card"> 

    <table id="cashier_data" class="table table-bordered table-striped">
      <thead>
        <tr>
        <th scope="col" colspan="2">
            <select name="filter_gender" id="filter_gender" class="form-control" required>
            @php $level = auth()->user()->level; @endphp
            @if($level > 1)
                <option value="">-- Select Level --</option>
                <option value="2">Owner</option>
                <option value="3">Manager</option>
                <option value="4">Keuangan</option>
                <option value="5">Operator</option>
            @else
                <option value="">-- Select Level --</option>
                <option value="1">Administrator</option>
                <option value="2">Owner</option>
                <option value="3">Manager</option>
                <option value="4">Keuangan</option>
                <option value="5">Operator</option>
            @endif
            </select>
        </th>
        <th scope="col" colspan="1">
            <select name="filter_country" id="filter_country" class="form-control" required>
            @php $level = auth()->user()->level; @endphp
            @if ($level > 1)
                <option value="{{ auth()->user()->member_id }}" selected disabled>{{ auth()->user()->member_id }} - {{ auth()->user()->member->name }}</option>
            @else
                <option value="">-- Select Member --</option>
                @foreach ($members as $row)
                  <option value="{{ $row->id }}">{{ $row->kta }}</option>
                @endforeach
            @endif
            </select>
            </select>
        </th>
        <th scope="col" colspan="3">
            <button type="button" name="filter" id="filter" class="btn btn-info"><i class="bi bi-filter"></i></button> 
            <button type="button" name="reset" id="reset" class="btn btn-danger"><i class="bi bi-x-lg"></i></button>

            <button type="button" class="btn btn-primary editIcon2" data-bs-toggle="modal" data-bs-target="#importprodModal"><i class="ri-folder-5-line me-1"></i></button>
            <button type="button" class="btn btn-info editIcon3" data-bs-toggle="modal" data-bs-target="#addprodModal"><i class="bi bi-plus-lg"></i></button>
            <a href="" onclick="this.href='user_pdf'" button type="button" class="btn btn-danger" target="_blank"><i class="bi bi-file-pdf"></i></a>
            <button type="button" class="btn btn-warning"><i class="bi bi-printer"></i></button>
            <a href="" onclick="this.href='user_export'" button type="button" class="btn btn-success" target="_blank"><i class="bi bi-file-excel"></i></a>
        </th>
        </tr>
        <tr>
        <th scope="col" width="15%">Nama User</th>
        <th scope="col" width="10%">Username</th>
        <th scope="col" width="35%">Project</th>
        <th scope="col" width="10%">ID Project</th>
        <th scope="col" width="10%">Level</th>
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

@include('user.edit')
</main>

<script src="{{ asset('baru2/jquery-3.6.0.min.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  

<script type="text/javascript">      
$(function() {

      $(document).ready(function(){

        fill_datatable();

        function fill_datatable(filter_gender = '', filter_country = '')
        {
            var dataTable = $('#cashier_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('user_index2') }}",
                    data:{filter_gender:filter_gender, filter_country:filter_country}
                },
                columns: [
                    { data:'name', name:'name' },
                    { data:'email', name:'email' },
                    { data:'member.kta', name:'member.kta' },
                    { data:'member_id', name:'member_id' },
                    { data:'status', name:'status' },
                    { data: 'action', name: 'action', orderable: false},
                ],
                fixedColumns:   {
                    left: 1,
                    right: 1
                },
                select: true,
                order: [[2, 'asc']],
                pageLength: 10
            });
        }

        $('#filter').click(function(){
            var filter_gender = $('#filter_gender').val();
            var filter_country = $('#filter_country').val();

            if(filter_gender != '' ||  filter_country != '')
            {
                $('#cashier_data').DataTable().destroy();
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
            $('#cashier_data').DataTable().destroy();
            fill_datatable();
        });

      });

       // add ajax request  
      $("#add_prod_form").submit(function(e) {
          e.preventDefault();
          const fd = new FormData(this);
          $("#add_prod_btn").text('Adding...');
          $.ajax({
            url: '{{ route('user_store') }}',
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
                  'Account Added Successfully!',
                  'success'
                )                
                var oTable = $('#cashier_data').dataTable();
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
        $.ajax({
          url: '{{ route('user_edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#name").val(response.name);
            $("#email").val(response.email);
            $("#member_id").val(response.member_id);
            $("#level").val(response.level);
            $("#emp_id").val(response.id);
            const selectedtext = $('#level').val();
            if (selectedtext == 1) {
              $('#status1').text("1 - Admin");
            } else if (selectedtext == 2) {
              $('#status2').text("2 - Owner");
            } else if (selectedtext == 3) {
              $('#status3').text("3 - Manager");
            } else if (selectedtext == 4) {
              $('#status4').text("4 - Keuangan");
            } else if (selectedtext == 5) {
              $('#status5').text("5 - Operator");
            } else if (selectedtext == 6) {
              $('#status6').text("6 - Upah");
            } else if (selectedtext == 7) {
              $('#status7').text("7 - Peralatan");
            } else if (selectedtext == 8) {
              $('#status7').text("8 - Admin Proyek");
            }
          }
        });
      });

      // update ajax request
      $("#edit_prod_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_prod_btn").text('Updating...');
        $.ajax({
          url: '{{ route('user_update') }}',
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
                'User Updated Successfully!',
                'success'
              )
              var oTable = $('#cashier_data').dataTable();
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
              url: '{{ route('user_delete') }}',
              method: 'delete',
              data: {id: id, _token: csrf },
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                var oTable = $('#cashier_data').dataTable();
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
                'Cashier Imported Successfully!',
                'success'
              )
              var oTable = $('#cashier_data').dataTable();
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