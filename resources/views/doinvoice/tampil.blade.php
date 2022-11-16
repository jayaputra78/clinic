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
  <h4>Input Transaksi Request</h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">Transaksi Request</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
<div class="row">
<div class="col-lg-12">
<div class="card"> 
<div class="card-body">
    <table id="do_data" class="table table-bordered table-striped">
      <thead>
        <tr>
        <th scope="col" colspan="2">
            <select name="filter_gender" id="filter_gender" class="form-control" required>
                <option value="">-- Select Jenis Transaksi --</option>
                <?php  $level = auth()->user()->level;	 ?>
                @if ( $level == "5" )
                    <option value="MATERIAL">MATERIAL</option>
                @elseif ( $level == "6" )
                    <option value="UPAH">UPAH</option>
                @elseif ( $level == "7" )
                    <option value="PERALATAN">PERALATAN</option>
                @else
                    <option value="MATERIAL">MATERIAL</option>
                    <option value="UPAH">UPAH</option>
                    <option value="PERALATAN">PERALATAN</option>
                @endif
                    
            </select>
        </th>
        <th scope="col" colspan="3">
            <select name="filter_country" id="filter_country" class="form-control" required>
                <option value="">-- Select Status --</option>
                <option value="ORDER">ORDER</option>
                <option value="CEK HARGA">CEK HARGA</option>
                <option value="ACC">ACC</option>
            </select>
        </th>
        <th scope="col" colspan="4">
            <button type="button" name="filter" id="filter" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter Data"><i class="bi bi-filter"></i></button> 
            <button type="button" name="reset" id="reset" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Clear Filter Data"><i class="bi bi-x-lg"></i></button>
            
            <?php  $level = auth()->user()->level;	 ?>
            @if (( $level == "5" ) || ( $level == "6" ) || ( $level == "7" ))

                <button type="button" class="btn btn-info editIcon3" data-bs-toggle="modal" data-bs-target="#addprodModal" data-bs-placement="top" title="Tambah Data"><i class="bi bi-plus-lg"></i></button>

            @endif
            <!-- <a href="" onclick="this.href='sp_pdf'" button type="button" class="btn btn-warning" target="_blank"><i class="bi bi-printer"></i></a> -->
        </th>
        </tr>
        <tr>
        <th scope="col" width="5%">ID</th>
        <th scope="col" width="25%">Project</th>
        <th scope="col" width="10%">Tanggal</th>
        <th scope="col" width="10%">Jenis</th>
        <th scope="col" width="10%">Supplier</th>
        <th scope="col" width="5%">Total Item</th>
        <th scope="col" width="10%">Sisa Tagihan</th>
        <th scope="col" width="10%">Status</th>
        <th scope="col" width="15%">Action</th>
        </tr>
      </thead>
    </table>

</div>

<!--
</div> --> 
</div>
</div>
</div>
</section>
@include('doinvoice.edit')
</main>

<script src="{{ asset('baru2/jquery-3.6.0.min.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  

<script type="text/javascript">      
$(function() {

      $(document).ready(function(){

        fill_datatable();

        function fill_datatable(filter_gender = '', filter_country = '')
        {
            var dataTable = $('#do_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('do_index2') }}",
                    data:{filter_gender:filter_gender, filter_country:filter_country}
                },
                columns: [
                    { data:'id', name:'id' },
                    { data:'member.kta', name:'member.kta' },
                    { data:'tanggal', name:'tanggal' },
                    { data:'jenis', name:'jenis' },
                    { data:'supplier.nama', name:'supplier.nama' },
                    { data:'item', name:'item', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass"  },
                    { data:'total', name:'total', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass"  },
                    { data:'status', name:'status' },
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
                $('#do_data').DataTable().destroy();
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
            $('#do_data').DataTable().destroy();
            fill_datatable();
        });

        $("#kas_id2").click(function() {
            var jenis_value = $(this).val();
            if (jenis_value == "PH") {
                $("#read3").html('<label class="col-sm-2 col-form-label">Customer</label><div class="col-sm-10"><select name="customer_id" class="form-select" aria-label="Default select example"><option value="">-- Select --</option>@foreach ($results as $result)  <option value="{{ $result->customer_id }}">{{ $result->customer->name }}</option> @endforeach</select></div>');                                          
            } else if (jenis_value == "KH") {
                $("#read3").html('<label class="col-sm-2 col-form-label">Supplier</label><div class="col-sm-10"><select name="supplier_id" class="form-select" aria-label="Default select example"><option value="">-- Select --</option>@foreach ($result2s as $result)  <option value="{{ $result->supplier_id }}">{{ $result->supplier->nama }}</option> @endforeach</select></div>');   
            } else if (jenis_value == "IT") {
                $("#read3").html('<label class="col-sm-2 col-form-label">Rekening Project Tujuan</label><div class="col-sm-10"><select name="cashier2_id" class="form-select" aria-label="Default select example"><option value="">-- Select --</option>@foreach ($cashier2 as $result)  <option value="{{ $result->id }}">{{ $result->bank }} - {{ $result->member->kta }} - {{ $result->member->name }}</option> @endforeach</select></div>'); 
            } else {
                $("#read3").html('');
            };
        });

        $(document).on('click', '.uploadIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                    url: '{{ route('doinvoice_editegf') }}',
                    method: 'get',
                    data: {id: id, _token: csrf },
                    success: function(response) {
                        $("#emp_id3").val(response.id);
                        $("#status3").val(response.status);
                    }
                });
        });

        $("#upload_prod_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#upload_prod_btn").text('Upload ...');
            $.ajax({
                url: '{{ route('doinvoice_update2') }}',
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
                    'Images Uploaded Successfully!',
                    'success'
                    );
                    var oTable = $('#do_data').dataTable();
                        oTable.fnDraw(false);
                }
                $("#upload_prod_btn").text('Upload');
                $("#upload_prod_form")[0].reset();
                $("#uploadprodModal").modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
                
            });
        });

        $(document).on('change', '.agbrIcon1', function(e) {
           let reader = new FileReader();
           reader.onload = (e) => { 
             $('#gambar_upload1').attr('src', e.target.result); 
           }
           reader.readAsDataURL(this.files[0]); 
        });


      });
 
});
</script>

<script>
    // set default tanggal saat ini
    document.querySelector('#tanggal2').value = new Date().toISOString().substring(0, 10);

    // fungsi onchange cetak nilai
    function cetakTanggal() {
        var tanggal = document.querySelector('#tanggal').value;
        document.querySelector('#cetak').innerHTML = tanggal;
    }
</script>
@endsection