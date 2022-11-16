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
      <li class="breadcrumb-item active" id="data">{{ $payinvoice3->note }}</li>
      <li class="breadcrumb-item active">{{ $payinvoice3->id }}</li>
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
        <th scope="col" colspan="9">
          <?php $tgl = date('d M Y', strtotime( $payinvoice3->tanggal )); ?>
          PROJECT : {{ auth()->user()->member->kta }}
        </tr>
        <tr>
        <th scope="col" colspan="2">
          <input type="text" name="note" value="{{ $tgl }}" class="form-control" disabled> 
          <input type="hidden" name="filter_country" id="filter_country" value="{{ $payinvoice3->id }}" class="form-control" disabled> 
          <input type="hidden" name="sid" id="sid" value="{{ $payinvoice3->id }}" class="form-control">
        </th>
        <th scope="col" colspan="2">
            <input type="label" name="kasir" value="{{ $payinvoice3->cashier->bank }}" class="form-control" disabled> 
        </th>
        <th scope="col" colspan="1">
            @if ( $payinvoice3->image1 == "PB")
                <input type="text" name="status" value="KAS MASUK" class="form-control" disabled> 
            @elseif ( $payinvoice3->image1 == "PH")
                <input type="text" name="status" value="{{ $payinvoice3->customer->name }}" class="form-control" disabled> 
            @elseif ( $payinvoice3->image1 == "KB")
                <input type="text" name="status" value="KAS KELUAR" class="form-control" disabled> 
            @elseif ( $payinvoice3->image1 == "KH")
                <input type="text" name="status" value="{{ $payinvoice3->supplier->nama }}" class="form-control" disabled> 
            @elseif ( $payinvoice3->image1 == "IT")
                <input type="text" name="status" value="INHOUSE TRANSFER" class="form-control" disabled> 
            @endif
        </th>
        <th scope="col" colspan="4">
            <button type="button" name="filter" id="filter" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter Data"><i class="bi bi-filter"></i></button> 
            <button type="button" name="reset" id="reset" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Clear Filter Data"><i class="bi bi-x-lg"></i></button>
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#saveprodModal" data-bs-placement="top" title="Tambah Data"><i class="bi bi-plus-lg"></i></button>
            <a href="" onclick="this.href='sp_pdf'" button type="button" class="btn btn-warning" target="_blank"><i class="bi bi-printer"></i></a>
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
      <tfoot>
        <tr>
            <th colspan="5" scope="col" style="text-align:right">Total:</th>
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
@include('payinvoice.edit2')
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
                    var masukTotal = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return numberWithCommas(intVal(a) + intVal(b));
                        }, 0 );
                    var keluarTotal = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return numberWithCommas(intVal(a) + intVal(b));
                        }, 0 );
                    // Update footer by showing the total with the reference of the column index 
                    $( api.column( 0 ).footer() ).html('');
                    $( api.column( 1 ).footer() ).html('');
                    $( api.column( 2 ).footer() ).html('');
                    $( api.column( 3 ).footer() ).html('');
                    $( api.column( 4 ).footer() ).html('Total');
                    $( api.column( 5 ).footer() ).html(masukTotal);
                    $( api.column( 6 ).footer() ).html(keluarTotal);
                    $( api.column( 7 ).footer() ).html('');
                },
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('pay_index3') }}",
                    data:{filter_gender:filter_gender, filter_country:filter_country, sid:sid}
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
                url: '{{ route('payinvoice_saves') }}',
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
                   location.reload(true);
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
                url: '{{ route('payinvoice_delete') }}',
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

        function reload() {
            let id = $(this).attr('#supplier_id');
            $.ajax({
                url: '{{ route('payinvoice_reload') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert("test");
                    $("#doinvoice_id").append('<option>---Pilih Bro---</option>');
                    $.each(res,function(id, supplier_id, note, jenis,saldo,saldo2){
                        $("#doinvoice_id").append('<option value="' + id + '" data-subtitle="" data-left="{{ asset('assets/img/noimage.png') }}" data-right="' + saldo  + '" data-price="' + $saldo2 + '">[TAGIHAN ' + jenis + 'NO ' + id + '-' +  note + '</option>');
                    });
                // $("#read3").html('<label class="col-sm-2 col-form-label">Pilih Tagihan</label><div class="col-sm-10"><select class="form-control" style="width: 100%;" name="doinvoice_id" id="doinvoice_id"><option selected="selected" value="user_id">Select One</option>@foreach ($result2s as $result) <option value="{{ $result->id }}" data-subtitle="" data-left="{{ asset("assets/img/noimage.png") }}" data-right="{{ $result->saldo }}" data-price="{{ $result->saldo2 }}">[TAGIHAN {{ $result->jenis }} NO {{ $result->id }} ] - {{ $result->note}} - {{ $result->saldo }}</option>@endforeach <input value="activate" id="activate_selectator1" type="hidden"></select>');
                }
            });
        };

        $("#doinvoice_id").change(function () {
            var id = this.value;
            $.ajax({
                url: '{{ route('payinvoice_reload2') }}', 
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //  alert(response.note);
                    $("#keluar").val(response.saldo2);
                }
            });
        }); 

      });

    $('#demo-2').inputpicker({
            data:[
                {value:"1",text:"jQuery", description: "This is the description of the text 1 BRO"},
                {value:"2",text:"Script", description: "This is the description of the text 2."},
                {value:"3",text:"Net", description: "This is the description of the text 3."},
            ],
            fields:[
                {name:'value',text:'Id'},
                {name:'text',text:'Title'},
                {name:'description',text:'Description'}
            ],
            headShow: true,
            fieldText : 'text',
            fieldValue: 'value',
            filterOpen: true
    });

    $('#demo-3').inputpicker({
        url: 'http://127.0.0.1:8000/api/tagihan',
        fields:['id','note','saldo'],
        fieldText:'saldo',
        fieldValue:'id',
        filterOpen: true,
        headShow: true
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
            var $select = $('#doinvoice_id'); 
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