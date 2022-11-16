    
<!-- == start form tambah === -->
<div class="modal fade" id="saveprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                      
                <?php  $level = auth()->user()->level;	 ?>
                @if ( $level == "5" )
                    Input Transaksi Material
                @elseif ( $level == "6" )
                    @if ($doinvoice3->payment == "KASBON")
                        Input Transaksi Upah - Kasbon
                    @else
                         Input Transaksi Upah
                    @endif
                @elseif ( $level == "7" )
                    Input Transaksi Peralatan
                @elseif ( $level == "8" )
                    Acc Request
                @endif
                
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="row g-1" action="#" method="POST" id="save_prod_form" enctype="multipart/form-data">
                
                @csrf
                <input type="hidden" name="userid" id="userid" value="{{ Auth::user()->id  }}">
                <input type="hidden" name="id" id="id" value="{{ $doinvoice3->id }}">
                <input type="hidden" name="note" id="note" value="{{ $doinvoice3->note }}">
                <input type="hidden" name="member_id" value="{{ $doinvoice3->member_id }}">
                <input type="hidden" name="doinvoice_id" value="{{ $doinvoice3->id }}">
                <input type="hidden" name="supplier_id" value="{{ $doinvoice3->supplier_id }}">
                <input type="hidden" name="tanggal" value="{{ $doinvoice3->tanggal }}">
                <input type="hidden" name="jenis" value="{{ $doinvoice3->jenis }}">
                <input type="hidden" name="status" value="{{ $doinvoice3->status }}">
                <input type="hidden" name="payment" value="{{ $doinvoice3->payment }}">
                           
                                 
                                    @if ( $level == "5" )
                                    <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Pilih Product</label>
                                    <div class="col-sm-10">
                                    <select class="form-control" style="width: 100%;" name="product_id" id="product_id">
                                    <option selected="selected">-- Pilih Product --</option>    
                                        @foreach ($productsm as $row) 
                                            <option value="{{ $row->id }}" data-subtitle="{{ $row->satuan }}" data-left="{{ asset('assets/img/noimage.png') }}" data-right="{{ $row->price_b1 }}" data-price="{{ $row->price_b1 }}">{{ $row->id }} - {{ $row->title }} - {{ $row->description}} </option>
                                        @endforeach
                                        <input value="activate" id="activate_selectator1" type="hidden"> 
                                    </select>  
                                                  
                                        </div>
                                    </div>
                                    @elseif ( $level == "6" )
                                        @if ($doinvoice3->payment == "KASBON")
                                            <!-- <input type="hidden" name="product_id" id="product_id2" value="16556"> -->
                                            @foreach ($productkb as $row) 
                                                <input type="hidden" name="product_id" id="product_id2" value="{{ $row->id }}"> 
                                                <!--
                                                <option value="{{ $row->id }}" data-subtitle="{{ $row->satuan }}" data-left="{{ asset('assets/img/noimage.png') }}" data-right="{{ $row->price_b1 }}" data-price="{{ $row->price_b1 }}" selected="selected" enabled>{{ $row->id }} - {{ $row->title }} - {{ $row->description}}</option>
                                                -->
                                            @endforeach      
                                        @else 
                                        <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Pilih Product</label>
                                        <div class="col-sm-10">

                                        <select class="form-control" style="width: 100%;" name="product_id" id="product_id">
                                        <option selected="selected">-- Pilih Product --</option>    
                                            @foreach ($productsu as $row) 
                                                <option value="{{ $row->id }}" data-subtitle="{{ $row->satuan }}" data-left="{{ asset('assets/img/noimage.png') }}" data-right="{{ $row->price_b1 }}" data-price="{{ $row->price_b1 }}">{{ $row->id }} - {{ $row->title }} - {{ $row->description}}</option>
                                            @endforeach
                                            <input value="activate" id="activate_selectator1" type="hidden"> 
                                        </select>  
                                        </div>
                                        </div>
                                        @endif
                                    @elseif ( $level == "7" )

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Pilih Product</label>
                                        <div class="col-sm-10">
                                    <select class="form-control" style="width: 100%;" name="product_id" id="product_id">
                                    <option selected="selected">-- Pilih Product --</option>    
                                        @foreach ($productsp as $row) 
                                            <option value="{{ $row->id }}" data-subtitle="{{ $row->satuan }}" data-left="{{ asset('assets/img/noimage.png') }}" data-right="{{ $row->price_b1 }}" data-price="{{ $row->price_b1 }}">{{ $row->id }} - {{ $row->title }} - {{ $row->description}} </option>
                                        @endforeach
                                        <input value="activate" id="activate_selectator1" type="hidden"> 
                                    </select>  
                                    </div>
                                        </div>
                                    @endif


                @if (($level=="6") && ($doinvoice3->payment<>"KASBON"))

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Nama Pekerjaan</label>
                        <div class="col-sm-10">  
                            <input id="pekerjaan-input" type="text" name="pekerjaan" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Persen Pekerjaan</label>
                        <div class="col-sm-10">  
                            <input id="persen-input" type="number" name="persen" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Jumlah Pekerja</label>
                        <div class="col-sm-10">  
                            <input id="jumlah-input" type="number" name="jumlah" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Jumlah Hari</label>
                        <div class="col-sm-10">  
                            <input id="hari-input" type="number" name="hari" class="form-control" required>
                        </div>
                    </div>

                @else
                    <input id="jumlah-input2" type="hidden" name="jumlah" value="" class="form-control-lg jumlah-input text-center input-sm" placeholder="Jumlah Pekerja" required>
                    <input id="hari-input2" type="hidden" name="hari" value=""  class="form-control-lg hari-input text-center input-sm" placeholder="Jumlah Hari" required>
                    <input id="pekerjaan-input2" type="hidden" name="pekerjaan" value="" class="form-control-lg pekerjaan-input text-center input-sm" placeholder="Nama Pekerjaan" required>
                    <input id="persen-input2" type="hidden" name="persen" value="" class="form-control-lg persen-input text-center input-sm" placeholder="Persentase (%) Progress" required>
                @endif


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">
                    @if (( $level == "5" ) || ( $level == "7" ))         
                        Qty
                    @else
                        @if ($doinvoice3->payment=="KASBON")
                            Jumlah (Rp)
                        @else
                            Qty ( hari x Pekerja )
                        @endif
                    @endif
                    </label>
                    <div class="col-sm-10">     
                        @if (( $level == "5" ) || ( $level == "7" ))                  
                            <input type="text" name="qty" id="qty" class="form-control">
                            <input type="hidden" name="price" id="price" value=0 class="form-control">
                        @else
                            @if ($doinvoice3->payment=="KASBON")
                                <input type="hidden" name="qty" id="qty" class="form-control" value=1>
                                <input type="text" name="price" id="price" value=0 class="form-control">
                            @else
                                <input type="text" name="qty" id="qty-input" class="form-control">
                                <input type="hidden" name="price" id="price" value=0 class="form-control">
                            @endif
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


<!-- ===================== Start Upload Image ====================== -->

<div class="modal fade" id="uploadprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Gambar Perkembangan Pekerjaan</h5>

              
              <form class="row g-1" action="#" method="POST" id="upload_prod_form" enctype="multipart/form-data">
                <input type="hidden" name="emp_id" id="emp_id">
                @csrf
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>File Browser 1</label>
                    <div class="col-sm-10">     
                        <br><img src="{{ asset('storage/images/15.jpg') }}" id="gambar_upload1" alt="..." class="profile.img_4" width='110' height='130' halign='center'>
                        <input type="file" name="image1a" id="image1a" class="form-control agbrIcon1">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>File Browser 2</label>
                    <div class="col-sm-10">     
                        <br><img src="{{ asset('storage/images/15.jpg') }}" id="gambar_upload2" alt="..." class="profile.img_4" width='110' height='130' halign='center'>
                        <input type="file" name="image2a" id="image2a" class="form-control agbrIcon2">
                    </div>
                </div>

                <div class="text-center">
                  <button type="submit" id="upload_prod_btn" class="btn btn-primary">Upload</button>
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                </div>
              </form>

            </div>
        
          </div>
          </div>
      </div>
  </div>
</div>

<!-- ===================== End Upload Image ====================== -->