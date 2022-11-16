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
  <h4>
    
  <?php  $level = auth()->user()->level;	 ?>
                @if ( $level == "5" )
                    Input Transaksi Material
                @elseif ( $level == "6" )
                    Input Transaksi Upah
                @elseif ( $level == "7" )
                    Input Transaksi Peralatan
                @elseif ( $level == "8" )
                    Acc Request
                @endif
  </h4>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active">Transaksi Request</li>
      <li class="breadcrumb-item active" id="data">{{ $doinvoice3->level }}</li>
      <li class="breadcrumb-item active" id="stat">{{ $doinvoice3->status }}</li>
    </ol>
    </ol>
  </nav>
</div>

<section class="section dashboard">
<div class="row">
<div class="col-lg-12">
<div class="card"> 

    <table id="payment_data" class="table table-bordered table-striped">
      <thead>
        <tr>
        <th scope="col" colspan="8">
          <?php $tgl = date('d M Y', strtotime( $doinvoice3->tanggal )); ?>
          PROJECT : {{ auth()->user()->member->kta }}
            @if ( $doinvoice3->jenis == "MATERIAL")
                <input type="hidden" name="jenis" value="MATERIAL" disabled> 
                <?php $data = "MATERIAL"; ?>
            @elseif ( $doinvoice3->jenis == "UPAH")
                <input type="hidden" name="jenis" value="UPAH" disabled> 
                <?php $data = "UPAH"; ?>
            @elseif ( $doinvoice3->jenis == "PERALATAN")
                <input type="hidden" name="jenis" value="PERALATAN" disabled> 
                <?php $data = "PERALATAN"; ?>
            @endif
        </tr>
        <tr>
        <th scope="col" colspan="2">
          <input type="text" name="note" value="{{ $tgl }}" class="form-control" disabled> 
          <input type="hidden" name="filter_country" id="filter_country" value="{{ $doinvoice3->id }}" class="form-control" disabled> 
          <input type="hidden" name="sid" id="sid" value="{{ $doinvoice3->id }}" class="form-control">
        </th>
        <th scope="col" colspan="1">
            <input type="label" name="kasir" value="{{ $doinvoice3->supplier->nama }} -- {{ $data }} " class="form-control" disabled> 
        </th><!--
        <th scope="col" colspan="1">
            @if ( $doinvoice3->jenis == "MATERIAL")
                <input type="text" name="jenis" value="MATERIAL" class="form-control" disabled> 
            @elseif ( $doinvoice3->jenis == "UPAH")
                <input type="text" name="jenis" value="UPAH" class="form-control" disabled> 
            @elseif ( $doinvoice3->jenis == "PERALATAN")
                <input type="text" name="jenis" value="PERALATAN" class="form-control" disabled> 
            @endif
        </th>-->
        <th scope="col" colspan="2">
        @if ( $level == "8" && $doinvoice3->status <> "ACC" )
            <select name="harga" id="harga" class="form-control" required>
                <option value="0">-- Select Harga --</option>
                <option value="1">Harga Tunai</option>
                <option value="2">Harga Kredit 2 Minggu</option>
                <option value="3">Harga Kredit 1 Bulan</option>
            </select>
        @else
             <input type="text" name="stat2" value="{{ $doinvoice3->status }}" class="form-control" disabled> 
        @endif
        </th>
        <th scope="col" colspan="3">
            <button type="button" name="filter" id="filter" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter Data"><i class="bi bi-filter"></i></button> 
            <button type="button" name="reset" id="reset" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Clear Filter Data"><i class="bi bi-x-lg"></i></button>
            @if ( $level == "11" )
                <button type="button" name="acc" id="acc" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Acc Request"><i class="bi bi-check-circle"></i></button>
            @endif
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#saveprodModal" data-bs-placement="top" title="Tambah Data"><i class="bi bi-plus-lg"></i></button>
            <a href="{{ route('doinvoice_print', ['id' => $doinvoice3->id]) }}" button type="button" class="btn btn-warning" target="_blank"><i class="bi bi-printer"></i></a>
            @if ( $level == "8" && $doinvoice3->status <> "ACC")
                <!-- <button type="button" class="btn btn-info"><i class="ri-checkbox-line me-1"></i> Cek </button> 
                    <a href="#" id="{{ $doinvoice3->id ?? ''}}" class="text-success mx-1 editIcon2"><button type="button" class="btn btn-info"><i class="ri-checkbox-line me-1"></i> Cek </button> </a> -->
                    <a href="#" class="text-success mx-1 editIcon" title="Cek Harga"><button type="button" class="btn btn-info"><i class="ri-checkbox-line me-1"></i> Cek </button> </a>
                    <a href="#" class="text-success mx-1 accIcon" title="Acc Harga"><button type="button" class="btn btn-success"><i class="bi bi-check-circle me-1"></i> Acc </button> </a>
                <!-- <button type="button" class="btn btn-success"><i class="bi bi-check-circle me-1"></i> Acc </button> -->
            @elseif ( $level == "8" && $doinvoice3->status == "ACC")    

                <a href="#" class="text-success mx-1 cancellIcon" title="Cancel Acc"><button type="button" class="btn btn-danger"><i class="bi bi-x-lg me-1"></i> Cancel Acc</button> </a>

            @endif
        </th>
        </tr>
        <tr>
        <th scope="col" width="7%">ID</th>
        <th scope="col" width="7%">Kode</th>
        <th scope="col" width="35%">Product</th>
        <th scope="col" width="6%">Satuan</th>
        <th scope="col" width="10%">Qty</th>
        <th scope="col" width="10%">Harga</th>
        <th scope="col" width="10%">Total</th>
        <th scope="col" width="15%">Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
            <th colspan="4" scope="col" style="text-align:right">Total:</th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th></th>
        </tr>
        </tfoot>
    </table>

</div>

<!--
</div> --> 
</div>
</div>
</section>
@include('doinvoice.edit2')
</main>

<script src="{{ asset('baru2/jquery-3.6.0.min.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
<script src="{{ asset('baru2/fm.selectator.jquery.js?cb=29') }}"></script> 


<script type="text/javascript">      
$(function() {

      $(document).ready(function(){

        fill_datatable();
        function fill_datatable(filter_gender = '', filter_country = '')
        {
            var sid = $('#sid').val();
            var dataTable = $('#payment_data').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // converting to interger to find total
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    function numberWithCommas(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    };
                    // computing column Total of the complete result 
                    var qtyTotal = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return numberWithCommas(intVal(a) + intVal(b));
                        }, 0 );
                    var statusTotal = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return numberWithCommas(intVal(a) + intVal(b));
                        }, 0 );
                    // Update footer by showing the total with the reference of the column index 
                    $( api.column( 0 ).footer() ).html('');
                    $( api.column( 1 ).footer() ).html('');
                    $( api.column( 2 ).footer() ).html('');
                    $( api.column( 3 ).footer() ).html('Total');
                    $( api.column( 4 ).footer() ).html(qtyTotal);
                    $( api.column( 5 ).footer() ).html('');
                    $( api.column( 6 ).footer() ).html(statusTotal);
                    $( api.column( 7 ).footer() ).html('');
                },
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('do_index3') }}",
                    data:{filter_gender:filter_gender, filter_country:filter_country, sid:sid}
                },
                columns: [
                    { data:'id', name:'id' },
                    { data:'product.title', name:'product.title' },
                    { data:'product.description', name:'product.description', colspan:2 },
                    { data:'product.satuan', name:'product.satuan' },
                    { data:'qty', name:'qty', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass"  },
                    { data:'harga', name:'harga', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass"  },
                    { data:'status', name:'status', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass" },
                    { data: 'action', name: 'action', orderable: false},
                    
                ],
                fixedColumns:   {
                    left: 1,
                    right: 1
                },
                select: true,
                order: [[0, 'desc']],
                pageLength: 10,
                "paging": false,
                "searching": false
            });
        }

        $('#filter').click(function(){
            var filter_gender = $('#filter_gender').val();
            var filter_country = $('#filter_country').val();

            if(filter_gender != '' ||  filter_country != '')
            {
                $('#payment_data').DataTable().destroy();
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
            $('#payment_data').DataTable().destroy();
            fill_datatable();
        });

        $("#save_prod_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#save_prod_btn").text('Adding...');
            $.ajax({
                url: '{{ route('doinvoice_saves') }}',
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
                    'Payment Added Successfully!',
                    'success'
                    );
                    var oTable = $('#payment_data').dataTable();
                        oTable.fnDraw(false);
                 //  location.reload(true);
                    //reload();
                }
                $("#save_prod_btn").text('Add Payment');
                $("#save_prod_form")[0].reset();
                $("#saveprodModal").modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
                
            });
        });

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
                url: '{{ route('doinvoice_delete') }}',
                method: 'delete',
                data: {id: id, _token: csrf },
                success: function(response) {
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    );
                    var oTable = $('#payment_data').dataTable();
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

        $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                var id = $('#sid').val();
                var harga = $('#harga').val();
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                url: '{{ route('doinvoice_cek') }}',
                method: 'get',
                data: {id: id, harga: harga, _token: csrf },
                success: function(response) {
                    Swal.fire(
                        'Harga Updated !!',
                        'Cek Harga Sukses Bro!',
                        'success'
                    );
                    var oTable = $('#payment_data').dataTable();
                    oTable.fnDraw(false);
                }
                });
        });

        $(document).on('click', '.accIcon', function(e) {
                e.preventDefault();
                var id = $('#sid').val();
                var harga = $('#harga').val();
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                url: '{{ route('doinvoice_acc') }}',
                method: 'get',
                data: {id: id, harga: harga, _token: csrf },
                success: function(response) {
                    Swal.fire(
                        'Request Accepted !!',
                        'Acc Harga Sukses Bro!',
                        'success'
                    );
                    var oTable = $('#payment_data').dataTable();
                    oTable.fnDraw(false);
                }
                });
        });

        $(document).on('click', '.cancellIcon', function(e) {
                e.preventDefault();
                var id = $('#sid').val();
                var harga = $('#harga').val();
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                url: '{{ route('doinvoice_cancellacc') }}',
                method: 'get',
                data: {id: id, harga: harga, _token: csrf },
                success: function(response) {
                    Swal.fire(
                        'Acc Canceled !!',
                        'Acc Harga Sukses Dibatalkan Bro!',
                        'success'
                    );
                    var oTable = $('#payment_data').dataTable();
                    oTable.fnDraw(false);
                }
                });
        });

        $(document).on('click', '.uploadIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                url: '{{ route('doinvoice_editgbr') }}',
                method: 'get',
                data: {id: id, _token: csrf },
                success: function(response) {
                    $("#emp_id").val(response.id);
                }
                });
        });

        $("#upload_prod_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#upload_prod_btn").text('Upload ...');
            $.ajax({
                url: '{{ route('doinvoice_update') }}',
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
                    var oTable = $('#payment_data').dataTable();
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

        $(document).on('change', '.agbrIcon2', function(e) {
           let reader = new FileReader();
           reader.onload = (e) => { 
             $('#gambar_upload2').attr('src', e.target.result); 
           }
           reader.readAsDataURL(this.files[0]); 
        });


        $('#jumlah-input').on('keyup', function(){            
            var dec_value = $('#hari-input').val();
            var dec2_value = $(this).val();
            var value = parseInt(dec_value, 10);
            var berat = parseInt(dec2_value, 10);
            value = isNaN(value) ? 0: value;
            if (value > 0 )
            {
                berat=berat*value;
                $('#qty-input').val(berat);
            }
        });

        $('#hari-input').on('keyup', function(){
            var dec_value = $('#jumlah-input').val();
            var dec2_value = $(this).val();
            var value = parseInt(dec_value, 10);
            var berat = parseInt(dec2_value, 10);
            value = isNaN(value) ? 0: value;

            if (value > 0 )
            {
                berat=berat*value;
                $('#qty-input').val(berat);
            }
        });

    });
});
</script>

<script type="text/javascript">      
    var rupiah = document.getElementById('keluar1');
    rupiah.addEventListener('keyup', function(e) {
        rupiah.value = formatRupiah(this.value, 'Rp. ');
    })

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>

<script type="text/javascript"> 
    $(function () {
        var $activate_selectator = $('#activate_selectator1');
        $activate_selectator.click(function () { 
            var $select = $('#product_id'); 
            if ($select.data('selectator') === undefined) {
                $select.selectator({
                labels: {
                    search: 'Search here...'
                },
                useDimmer: true,
                searchFields: 'value text subtitle right'
                });
                $activate_selectator.val('destroy');
            } else {
                $select.selectator('destroy');
                $activate_selectator.val('activate');
            };
        });   
        $activate_selectator.trigger('click');
    });
</script>

@endsection