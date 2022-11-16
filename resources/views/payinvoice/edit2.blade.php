    
<!-- == start form tambah === -->
<div class="modal fade" id="saveprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    
                    @if ( $payinvoice3->image1 == "KB" )
                            Input Transaksi Kas Keluar
                    @elseif ( $payinvoice3->image1 == "PB" )
                            Input Transaksi Kas Terima
                    @elseif ( $payinvoice3->image1 == "KH" )
                            Input Transaksi Pembayaran Hutang
                    @elseif ( $payinvoice3->image1 == "PH" )
                            Input Transaksi Penerimaan Piutang
                    @elseif ( $payinvoice3->image1 == "IT" )
                            Input Transaksi Transfer Inhouse
                    @endif
                
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="row g-1" action="#" method="POST" id="save_prod_form" enctype="multipart/form-data">
                
                @csrf
                <input type="hidden" name="userid" id="userid" value="{{ Auth::user()->id  }}">
                <input type="hidden" name="account_id2" id="account_id3" value="{{ $payinvoice3->cashier->account_id }}"> 
                <input type="hidden" name="id" id="id" value="{{ $payinvoice3->id }}">
                <input type="hidden" name="note" id="note" value="{{ $payinvoice3->note }}">
                <input type="hidden" name="cashier_id" id="cashier_id" value="{{ $payinvoice3->cashier_id }}">
                <input type="hidden" name="member_id" value="{{ $payinvoice3->cashier->member->id }}">
                <input type="hidden" name="payinvoice_id" value="{{ $payinvoice3->id }}">
                <input type="hidden" name="tanggal" value="{{ $payinvoice3->tanggal }}">
                <input type="hidden" value="1" name="qty">
                <input type="hidden" name="jenis" value="{{ $payinvoice3->image1 }}">
                <input type="hidden" name="filter_country" id="filter_country" value="{{ $payinvoice3->id }}">
                <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $payinvoice3->supplier_id }}">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Rekening</label>
                    <div class="col-sm-10">
                            @if ( $payinvoice3->image1 == "KB" )
                                    <select name="account_id" id="account_id2" class="form-select" aria-label="Default select example">
                                    <option selected>-- Pilih Rekening --</option>
                                    @foreach ($accounts as $row) 
                                        <option value="{{ $row->id }}">{{ $row->account }} - {{ $row->keterangan }}</option>
                                    @endforeach
                                    </select>
                            @elseif ( $payinvoice3->image1 == "PB" )
                                    <select name="account_id" id="account_id2" class="form-select" aria-label="Default select example">
                                    <option selected>-- Pilih Rekening --</option>
                                    @foreach ($account2s as $row) 
                                        <option value="{{ $row->id }}">{{ $row->account }} - {{ $row->keterangan }}</option>
                                    @endforeach
                                    </select>
                            @elseif ( $payinvoice3->image1 == "KH" )
                                    <input type="hidden" value="15" name="account_id" class="form-control">15 - HUTANG DAGANG
                            @elseif ( $payinvoice3->image1 == "PH" )
                                    <input type="hidden" value="8" name="account_id" class="form-control">8 - PIUTANG DAGANG
                            @elseif ( $payinvoice3->image1 == "IT" )
                                    <input type="hidden" value="3" name="account_id" class="form-control">3 - AYAT SILANG
                            @endif
                          
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                            @if (( $payinvoice3->image1 == "KB" ) || ( $payinvoice3->image1 == "PB" ))
                                <input type="text" class="form-control" id="keterangan2" name="keterangan" required>
                            @elseif ( $payinvoice3->image1 == "IT" )
                                <input type="hidden" class="form-control" id="keterangan2" value="KAS PROYEK" name="keterangan">KAS PROYEK
                            @elseif ( $payinvoice3->image1 == "KH" )
                                <input type="hidden" class="form-control" id="keterangan2" value="BAYAR KE {{ $payinvoice3->supplier->nama }}" name="keterangan">BAYAR KE {{ $payinvoice3->supplier->nama }}
                            @elseif ( $payinvoice3->image1 == "PH" )
                                <input type="hidden" class="form-control" id="keterangan2" value="TERIMA DARI {{ $payinvoice3->customer->name }}" name="keterangan">TERIMA DARI {{ $payinvoice3->customer->name }}
                            @endif                                
                    </div>
                </div>


                @if ( $payinvoice3->image1 == "KH" )                        
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Pilih Tagihan</label>
                        <div class="col-sm-10">
                            <select class="form-control" style="width: 100%;" name="doinvoice_id" id="doinvoice_id">
                                <option selected="selected" value="user_id">-- Pilih Tagihan --</option>     
                                    @foreach ($result2s as $result) 
                                            <option value="{{ $result->id }}" data-subtitle="" data-left="{{ asset('assets/img/noimage.png') }}" data-right="{{ $result->saldo }}" data-price="{{ $result->saldo2 }}">[TAGIHAN {{ $result->jenis }} NO {{ $result->id }} ] - {{ $result->note}} </option>
                                    @endforeach
                                <input value="activate" id="activate_selectator1" type="hidden"> 
                            </select>                
                        </div>
                    </div>
                @endif


                <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jumlah Bayar</label>
                    <div class="col-sm-10">
                        @if (( $payinvoice3->image1 == "PB" ) || ( $payinvoice3->image1 == "PH" ))  
                            <input type="text" name="masuk" id="masuk" class="form-control" required>
                            <input type="hidden" value=0 name="keluar" class="form-control" required>
                        @elseif (( $payinvoice3->image1 == "KB" ) || ( $payinvoice3->image1 == "IT" ))  
                            <input type="hidden" value=0 name="masuk" class="form-control" required>
                            <input type="text" name="keluar" id="keluar" class="form-control">
                        @elseif ( $payinvoice3->image1 == "KH" )
                            <input type="hidden" value=0 name="masuk" class="form-control" required>
                            <input type="text" name="keluar" id="keluar" class="form-control">
                        @endif
                    </div>
                </div>

            </div>
                
            <div class="modal-footer">
                    <button type="submit" id="save_prod_btn" class="btn btn-info mx-1">Simpan</a>
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
            </div>

            </form>
      
      </div>
  </div>
</div>
<!-- ============== END ========================= -->

