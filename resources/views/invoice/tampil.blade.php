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
  <h4>Input Transaksi DO</h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">Transaksi DO</li>
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
        <th scope="col" colspan="3">
            <select name="filter_gender" id="filter_gender" class="form-control" required>
                <option value="">-- Select Status --</option>
                <option value="1">DO</option>
                <option value="2">TALLY</option>
                <option value="3">TAGIH</option>                  
            </select>
        </th>
        <th scope="col" colspan="3">
            <select name="filter_country" id="filter_country" class="form-control" required>
                <option value="">-- Select Jenis --</option>
                <option value="MUAT">MUAT CONTAINER</option>
                <option value="BONGKAR">BONGKAR CONTAINER</option>
                <option value="MUATCARGO">MUAT CARGO</option>
                <option value="BONGKARCARGO">BONGKAR CARGO</option>
                <option value="MUATCURAH">MUAT CURAH</option>
                <option value="BONGKARCURAH">BONGKAR CURAH</option>
            </select>
        </th>
        <th scope="col" colspan="5">
            <button type="button" name="filter" id="filter" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter Data"><i class="bi bi-filter"></i></button> 
            <button type="button" name="reset" id="reset" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Clear Filter Data"><i class="bi bi-x-lg"></i></button>
            
            <?php  $level = auth()->user()->level;	 ?>
            @if (( $level == "4" ))

                <button type="button" class="btn btn-info editIcon3" data-bs-toggle="modal" data-bs-target="#addprodModal" data-bs-placement="top" title="Tambah Data"><i class="bi bi-plus-lg"></i></button>

            @endif
            <!-- <a href="" onclick="this.href='sp_pdf'" button type="button" class="btn btn-warning" target="_blank"><i class="bi bi-printer"></i></a> -->
        </th>
        </tr>
        <tr>
        <th scope="col" width="4%">ID</th>
        <th scope="col" width="8%">Tanggal</th>
        <th scope="col" width="7%">Jenis</th>
        <th scope="col" width="5%">Status</th>
        <th scope="col" width="10%">No Cont.</th>
        <th scope="col" width="20%">Gudang</th>
        <th scope="col" width="5%">Qty</th>
        <th scope="col" width="5%">Tally</th>
        <th scope="col" width="10%">Petugas</th>
        @if (( $level == "4" ))
            <th scope="col" width="11%" style="text-align:right">Tagihan</th>
        @else
            <th scope="col" width="11%">Jadwal</th>
        @endif
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
@include('invoice.edit')
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
                    url: "{{ route('inv_index2') }}",
                    data:{filter_gender:filter_gender, filter_country:filter_country}
                },
                columns: [
                    { data:'id', name:'id' },
                    { data:'tanggal1', name:'tanggal1' },
                    { data:'jenis', name:'jenis' },
                    { data:'status', name:'status' },
                    { data:'note', name:'note' },
                    { data:'warehouse.nama', name:'warehouse.nama' },
                    { data:'modal', name:'modal', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass" },
                    { data:'tally', name:'tally', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass" },
                    { data:'user', name:'user' },
                    { data:'tanggal2', name:'tanggal2',className: "rightClass" },
                    { data: 'action', name: 'action', orderable: false},
                ],
                fixedColumns:   {
                    left: 1,
                    right: 1
                },
                select: true,
                order: [[3, 'asc'],[0, 'desc']],
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

        $("#jenis").click(function() {
            var jenis_value = $(this).val();
            if (jenis_value == "MUAT") {
                $("#read2").html('<label class="col-sm-2 col-form-label">No Container</label><div class="col-sm-10"><input type="text" class="form-control" id="note" name="note" required></div>'); 
                $("#read3").html('<label class="col-sm-2 col-form-label">Pelabuhan Tujuan</label><div class="col-sm-10"><select name="harbor_id" id="harbor_id" class="form-select" aria-label="Default select example"><option selected>-- Pilih Pelabuhan --</option>@foreach ($harbors as $row) <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->nama }}</option>@endforeach</select></div>');
                $("#read4").html('<label class="col-sm-2 col-form-label">Perusahaan Tally</label><div class="col-sm-10"><select name="ptally_id" id="ptally_id" class="form-select" aria-label="Default select example"><option selected>-- Pilih Perusahaan Tally --</option>@foreach ($members as $row) <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->name }}</option>@endforeach</select></div>');                    
            } else if (jenis_value == "BONGKAR") {
                $("#read2").html('<div class="row mb-3"><label class="col-sm-2 col-form-label">No Container</label><div class="col-sm-10"><input type="text" class="form-control" id="note" name="note" required></div></div>');     
                $("#read3").html('');
                $("#read4").html('');                               
            } else {
                $("#read2").html('');
                $("#read3").html('');
                $("#read4").html('');
            };
        });

        $(document).on('click', '.uploadIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                    url: '{{ route('invinvoice_editegf') }}',
                    method: 'get',
                    data: {id: id, _token: csrf },
                    success: function(response) {
                        $("#emp_id4").val(response.id);
                        $("#no_do2").val(response.nodo);
                    }
                });
        });

        $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                    url: '{{ route('invinvoice_edittugas') }}',
                    method: 'get',
                    data: {id: id, _token: csrf },
                    success: function(response) {
                        $("#emp_id5").val(response.id);
                        $("#no_do3").val(response.nodo);
                    }
                });
        });

        $("#upload_prod_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#upload_prod_btn").text('Tagih ...');
            $.ajax({
                url: '{{ route('invinvoice_update2') }}',
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
                    'Update Tagihan Successfully!',
                    'success'
                    );
                    var oTable = $('#do_data').dataTable();
                        oTable.fnDraw(false);
                }
                $("#upload_prod_btn").text('Tagih');
                $("#upload_prod_form")[0].reset();
                $("#uploadprodModal").modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
                
            });
        });

        $("#edit_prod_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_prod_btn").text('Tugaskan ...');
            $.ajax({
                url: '{{ route('invinvoice_update3') }}',
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
                    'Update Penugasan Successfully!',
                    'success'
                    );
                    var oTable = $('#do_data').dataTable();
                        oTable.fnDraw(false);
                }
                $("#edit_prod_btn").text('Tugaskan');
                $("#edit_prod_form")[0].reset();
                $("#editprodModal").modal('hide');
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