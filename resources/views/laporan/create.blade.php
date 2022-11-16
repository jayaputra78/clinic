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
  <h4>Cetak Laporan Bahan/Upah</h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">Cetak</li>
      <li class="breadcrumb-item active">Lap Bahan & Upah</li>
      
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
  <div class="card-body">
    <!-- <h5 class="card-title">Cetak Laporan Bahan dan Upah</h5> -->

    <form>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Jenis Laporan</label>
            <div class="col-sm-10">
                <select name="id" id="id" class="form-select" aria-label="Default select example">
                    <option selected>-- Pilih Laporan --</option>
                    @if ( auth()->user()->level == 5 )
                        <option value="1">Laporan Pemakaian Material</option>
                        <option value="3">Laporan Pemakaian Perlengkapan</option>
                    @elseif ( auth()->user()->level == 6 )
                        <option value="4">Laporan Pembayaran Upah</option>
                    @elseif ( auth()->user()->level == 7 )
                        <option value="2">Laporan Pemakaian Peralatan</option>
                    @elseif ( auth()->user()->level == 8 )
                        <option value="1">Laporan Pemakaian Material</option>
                        <option value="2">Laporan Pemakaian Peralatan</option>
                        <option value="4">Laporan Pemakaian Upah</option>
                        <option value="5">Laporan Semua</option>
                    @else
                        <option value="1">Laporan Pemakaian Material</option>
                        <option value="2">Laporan Pemakaian Peralatan</option>
                        <option value="4">Laporan Pemakaian Upah</option>
                        <option value="5">Laporan Semua</option>
                    @endif
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Group</label>
            <div class="col-sm-10">
                <select name="group" id="group" class="form-select" aria-label="Default select example">
                    <option selected>-- Pilih Listing --</option>
                    <option value="1">Listing Keseluruhan</option>
                    <option value="2">Listing Per PO</option>
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Project</label>
            <div class="col-sm-10">
                <select name="member_id" id="member_id"  class="form-select" aria-label="Default select example">
                    <option selected value="">-- Pilih Project --</option>
                    @foreach ($member as $row) 
                        <option value="{{ $row->id }}">[{{ $row->id }}] - {{ $row->kta }} - {{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <a href="" onclick="this.href='laporan_jual/' + document.getElementById('id').value+ '/' + document.getElementById('member_id').value + '/' + document.getElementById('group').value"  target="_blank"
                class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Export PDF"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</button></a>
                <a href="" onclick="this.href='lapjual_export/' + document.getElementById('id').value+ '/' + document.getElementById('member_id').value + '/' + document.getElementById('group').value" target="_blank"
                class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Export XLS"><i class="bi bi-file-excel me-1"></i>Cetak XLS</button></a>
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

<script type="text/javascript">      
$(function() {

});
</script>
@endsection