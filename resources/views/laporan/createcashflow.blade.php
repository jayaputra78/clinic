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
  <h4>Cetak Laporan Cashflow</h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">Cetak</li>
      <li class="breadcrumb-item active">Lap Cashflow Project</li>
      
    </ol>
  </nav>
</div>

<section class="section dashboard">
<div class="row">
<div class="col-lg-12">
<div class="card"> 
  <div class="card-body">

    <form>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Jenis Laporan</label>
            <div class="col-sm-10">
                    <select name="id" id="id" class="form-select" aria-label="Default select example">  
                        <option value="">-- Jenis Laporan -- </option>
                        <option value="1">Laporan Cashflow</option>
                    </select>
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Member</label>
            <div class="col-sm-10">
                <select name="member_id" id="member_id" class="form-select" aria-label="Default select example">
                    <option value="">-- Select Member --</option>
                    @foreach ($member as $row) 
                        <option value="{{ $row->id }}">{{ $row->kta }} - {{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
            <a href="" onclick="this.href='laporan_cashflow/' + document.getElementById('id').value + '/' + document.getElementById('member_id').value" target="_blank"
                class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Export PDF"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</button></a>
                <!--
                <a href="" onclick="this.href='export_cashier/' + document.getElementById('tglawal').value + '/' + document.getElementById('tglakhir').value+ '/' + document.getElementById('id').value + '/' + document.getElementById('kasir_id').value" target="_blank"
                class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Export XLS"><i class="bi bi-file-excel me-1"></i>Cetak XLS</button></a>
                -->
            </div>
        </div>

  </div>
</div>

<!--
</div> --> 
</div>
</div>
</section>
</main>

<script src="{{ asset('baru2/jquery-3.6.0.min.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  

<script>
    // set default tanggal saat ini
    document.querySelector('#tglawal').value = new Date().toISOString().substring(0, 10);
    document.querySelector('#tglakhir').value = new Date().toISOString().substring(0, 10);

    // fungsi onchange cetak nilai
    function cetakTanggal() {
        var tanggal = document.querySelector('#tanggal').value;
        document.querySelector('#cetak').innerHTML = tanggal;
    }
</script>
@endsection