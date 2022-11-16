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
      <li class="breadcrumb-item active">Transaksi Request</li>
      <li class="breadcrumb-item active" id="data">{{ $doinvoice3->nodo }}</li>
      <li class="breadcrumb-item active" id="stat">{{ $doinvoice3->jenis }}</li>
    </ol>
    </ol>
  </nav>
</div>

<section class="section dashboard">
<div class="row">
<div class="col-lg-12">
<div class="card"> 

    <table id="do_data" class="table table-bordered table-striped">
      <thead>
        <tr>
        <th scope="col" colspan="6">
          <?php $tgl = date('d M Y', strtotime( $doinvoice3->tgldo )); ?>
          CUSTOMER NAME : {{ $doinvoice3->customer->name  }} ( {{ $doinvoice3->jenis }} ) 
          <input type="text" name="tanggal" value="{{ $tgl }}" class="form-control" disabled> 
          <input type="hidden" name="filter_country" id="filter_country" value="{{ $doinvoice3->id }}" class="form-control" disabled> 
          <input type="hidden" name="sid" id="sid" value="{{ $doinvoice3->id }}" class="form-control">
          <input type="label" name="nodo" value="{{ $doinvoice3->nodo }}" class="form-control" disabled> 
            @if ( $doinvoice3->jenis == "MUAT")
                <input type="hidden" name="jenis" value="MUAT" disabled> 
                <?php $data = "MUAT"; ?>
            @elseif ( $doinvoice3->jenis == "BONGKAR")
                <input type="hidden" name="jenis" value="BONGKAR" disabled> 
                <?php $data = "BONGKAR"; ?>
            @elseif ( $doinvoice3->jenis == "MUATCARGO")
                <input type="hidden" name="jenis" value="MUATCARGO" disabled> 
                <?php $data = "MUATCARGO"; ?>
            @endif
            </th>

        </tr>
        <tr>
               
        <th scope="col" colspan="6">
            <?php  $level = auth()->user()->level;	 ?>
            @if (( $level == "4" ))
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#saveprodModal" data-bs-placement="top" title="Tambah Data"><i class="bi bi-plus-lg"></i></button>
                <a href="{{ route('invinvoice_print', ['id' => $doinvoice3->id]) }}" button type="button" class="btn btn-warning" target="_blank"><i class="bi bi-printer"></i></a>
            @elseif (( $level == "5" ))
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#saveprodModal" data-bs-placement="top" title="Tambah Data Produk Rusak"><i class="bi bi-plus-lg"></i></button>
                <button type="button" class="btn btn-warning uploadIcon1" data-bs-toggle="modal" data-bs-target="#uploadcontModal" data-bs-placement="top" title="Upload Foto Container"><i class="bi bi-upload"></i></button>                
                <button type="button" class="btn btn-success uploadIcon2" data-bs-toggle="modal" data-bs-target="#uploadvideoModal" data-bs-placement="top" title="Upload Video Tally"><i class="bi bi-camera-reels"></i></button>     
                <button type="button" class="btn btn-danger tally" data-bs-toggle="modal" data-bs-target="#tallyModal" data-bs-placement="top" title="Proses Tally"><i class="bi bi-fonts"></i></button>             
            @endif

                @if (!empty( $doinvoice3->image1 ))
                    <a href='{{  asset('storage/images/' . $doinvoice3->image1 . '') }}' target='_blank'>
                    <img src="{{  asset('storage/images/' . $doinvoice3->image1 . '') }}" id="gambar_upload1" alt="" class="profile.img_1" width='40' height='37' halign='center'></a>
                @endif

                @if (!empty( $doinvoice3->image2 ))
                    <a href='{{  asset('storage/images/' . $doinvoice3->image2 . '') }}' target='_blank'>
                    <img src="{{  asset('storage/images/' . $doinvoice3->image2 . '') }}" id="gambar_upload1" alt="" class="profile.img_1" width='40' height='37' halign='center'></a>
                @endif

                @if (!empty( $doinvoice3->image3 ))
                    <a href='{{  asset('storage/images/' . $doinvoice3->image3 . '') }}' target='_blank'>
                    <img src="{{  asset('storage/images/' . $doinvoice3->image3 . '') }}" id="gambar_upload1" alt="" class="profile.img_1" width='40' height='37' halign='center'></a>
                @endif
        </th>
        </tr>
        <tr>
        <th scope="col" width="7%">ID</th>
        <th scope="col" width="35%">Product</th>
        <th scope="col" width="10%">Qty</th>
        <th scope="col" width="10%">T.Muat</th>
        <th scope="col" width="30%">Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
            <th colspan="2" scope="col" style="text-align:right">Total:</th>
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
@include('invoice.edit2')
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
            var dataTable = $('#do_data').DataTable({
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
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return numberWithCommas(intVal(a) + intVal(b));
                        }, 0 );
                    var tallyTotal = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return numberWithCommas(intVal(a) + intVal(b));
                        }, 0 );
                    // Update footer by showing the total with the reference of the column index 
                    $( api.column( 0 ).footer() ).html('');
                    $( api.column( 1 ).footer() ).html('Total');
                    $( api.column( 2 ).footer() ).html(qtyTotal);
                    $( api.column( 3 ).footer() ).html(tallyTotal);
                    $( api.column( 4 ).footer() ).html('');
                },
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('inv_index3') }}",
                    data:{filter_gender:filter_gender, filter_country:filter_country, sid:sid}
                },
                columns: [
                    { data:'id', name:'id' },
                    { data:'prod', name:'prod'},
                    { data:'qty', name:'qty', render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass" },
                    { data:'tally', name:'tally' , render: $.fn.dataTable.render.number( ',', '.', 0, '' ),  className: "rightClass" },
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

        $("#save_prod_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#save_prod_btn").text('Adding...');
            $.ajax({
                url: '{{ route('invinvoice_saves') }}',
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
                    );
                    var oTable = $('#do_data').dataTable();
                        oTable.fnDraw(false);
                }
                $("#save_prod_btn").text('Add Product');
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
                url: '{{ route('invinvoice_delete') }}',
                method: 'delete',
                data: {id: id, _token: csrf },
                success: function(response) {
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    );
                    var oTable = $('#do_data').dataTable();
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
                url: '{{ route('invinvoice_cek') }}',
                method: 'get',
                data: {id: id, harga: harga, _token: csrf },
                success: function(response) {
                    Swal.fire(
                        'Harga Updated !!',
                        'Cek Harga Sukses Bro!',
                        'success'
                    );
                    var oTable = $('#do_data').dataTable();
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
                url: '{{ route('invinvoice_acc') }}',
                method: 'get',
                data: {id: id, harga: harga, _token: csrf },
                success: function(response) {
                    Swal.fire(
                        'Request Accepted !!',
                        'Acc Harga Sukses Bro!',
                        'success'
                    );
                    var oTable = $('#do_data').dataTable();
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
                url: '{{ route('invinvoice_cancellacc') }}',
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
                url: '{{ route('invinvoice_editgbr') }}',
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
                url: '{{ route('invinvoice_update') }}',
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

        $(document).on('change', '.agbrIcon2', function(e) {
           let reader = new FileReader();
           reader.onload = (e) => { 
             $('#gambar_upload2').attr('src', e.target.result); 
           }
           reader.readAsDataURL(this.files[0]); 
        });

        $(document).on('click', '.uploadIcon1', function(e) {
                e.preventDefault();
                let sid = $("#sid").val();
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                url: '{{ route('invinvoice_uploadcont') }}',
                method: 'get',
                data: {sid: sid, _token: csrf },
                success: function(response) {
                    $("#emp_id1").val(response.id);
                }
                });
        });

        $(document).on('change', '.agbrIcon3', function(e) {
           let reader = new FileReader();
           reader.onload = (e) => { 
             $('#gambar_upload3').attr('src', e.target.result); 
           }
           reader.readAsDataURL(this.files[0]); 
        });

        $(document).on('change', '.agbrIcon4', function(e) {
           let reader = new FileReader();
           reader.onload = (e) => { 
             $('#gambar_upload4').attr('src', e.target.result); 
           }
           reader.readAsDataURL(this.files[0]); 
        });

        $(document).on('change', '.agbrIcon5', function(e) {
           let reader = new FileReader();
           reader.onload = (e) => { 
             $('#gambar_upload5').attr('src', e.target.result); 
           }
           reader.readAsDataURL(this.files[0]); 
        });

        $("#upload_cont_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#upload_cont_btn").text('Upload ...');
            $.ajax({
                url: '{{ route('invinvoice_updatecont') }}',
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
                $("#upload_cont_btn").text('Upload');
                $("#upload_cont_form")[0].reset();
                $("#uploadcontModal").modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
                
            });
        });

        $(document).on('click', '.uploadIcon2', function(e) {
                e.preventDefault();
                let sid = $("#sid").val();
                let csrf = '{{ csrf_token() }}';
                $.ajax({
                url: '{{ route('invinvoice_uploadvideo') }}',
                method: 'get',
                data: {sid: sid, _token: csrf },
                success: function(response) {
                    $("#emp_id2").val(response.id);
                }
                });
        });

        $("#upload_video_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#upload_video_btn").text('Upload ...');
            $.ajax({
                url: '{{ route('invinvoice_updatevideo') }}',
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
                    'Video Uploaded Successfully!',
                    'success'
                    );
                    var oTable = $('#do_data').dataTable();
                        oTable.fnDraw(false);
                }
                $("#upload_video_btn").text('Upload');
                $("#upload_video_form")[0].reset();
                $("#uploadvideoModal").modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
                
            });
        });

        $(document).on('click', '.increment-btn', function(e) {
            e.preventDefault();
            var inc_value = $('#input1').val();
            var value = parseInt(inc_value, 10);
            value = isNaN(value) ? 0: value;
            if (value < 100000000 ) {
                value++;
                $('#input1').val(value);
            }
        });

        
        $("#save_tally_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#save_tally_btn").text('Simpan ...');
            $.ajax({
                url: '{{ route('invinvoice_saves') }}',
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
                    'Tally Update Successfully!',
                    'success'
                    );
                    var oTable = $('#do_data').dataTable();
                        oTable.fnDraw(false);
                }
                $("#Save_tally_btn").text('Simpan');
                $("#save_tally_form")[0].reset();
                $("#tallyModal").modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
                
            });
        });

    //    $(document).on('change', '.avideoIcon1', function(e) {  
    //        let reader = new FileReader();
     //       reader.onload = (e) => { 
    //        $('#video_upload1').attr('src', e.target.result); 
    //        }
    //        reader.readAsDataURL(this.files[0]);                    
     //   });

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