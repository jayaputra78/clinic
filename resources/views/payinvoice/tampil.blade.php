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
  <h4>Input Transaksi Kasir</h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">Transaksi Kasir</li>
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
        <th scope="col" colspan="3">
            <select name="filter_gender" id="filter_gender" class="form-control" required>
                <option value="">-- Select Jenis Transaksi --</option>
                <option value="PB">Kas Masuk</option>
                <option value="KB">Kas Keluar</option>
                <option value="PH">Terima Piutang</option>
                <option value="KH">Pembayaran Hutang</option>
                <option value="IT">Inhouse Transfer</option>
            </select>
        </th>
        <th scope="col" colspan="2">
            <select name="filter_country" id="filter_country" class="form-control" required>
            <option value="">-- Select Akun Kasir --</option>
                @foreach ($cashier as $row)
                    <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->bank }}</option>
                @endforeach
            </select>
        </th>
        <th scope="col" colspan="4">
            <button type="button" name="filter" id="filter" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter Data"><i class="bi bi-filter"></i></button> 
            <button type="button" name="reset" id="reset" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Clear Filter Data"><i class="bi bi-x-lg"></i></button>

            <button type="button" class="btn btn-info editIcon3" data-bs-toggle="modal" data-bs-target="#addprodModal" data-bs-placement="top" title="Tambah Data"><i class="bi bi-plus-lg"></i></button>
        </th>
        </tr>
        <tr>
        <th scope="col" width="5%">ID</th>
        <th scope="col" width="10%">No Kas</th>
        <th scope="col" width="10%">Tanggal</th>
        <th scope="col" width="10%">Akun Kasir</th>
        <th scope="col" width="30%">Keterangan</th>
        <th scope="col" width="10%">Masuk</th>
        <th scope="col" width="10%">Keluar</th>
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
@include('payinvoice.edit')
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
                    url: "{{ route('pay_index2') }}",
                    data:{filter_gender:filter_gender, filter_country:filter_country}
                },
                columns: [
                    { data:'id', name:'id' },
                    { data:'payinvoice.note', name:'payinvoice.note' },
                    { data:'tanggal', name:'tanggal' },
                    { data:'cashier.bank', name:'cashier.bank' },
                    { data:'keterangan', name:'keterangan' },
                    { data:'masuk', name:'masuk', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass"  },
                    { data:'keluar', name:'keluar', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass"  },
                    { data: 'action', name: 'action', orderable: false},
                ],
                fixedColumns:   {
                    left: 1,
                    right: 1
                },
                select: true,
                order: [[2, 'desc']],
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