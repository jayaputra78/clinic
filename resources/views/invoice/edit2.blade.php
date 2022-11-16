    
<!-- == start form tambah === -->
<div class="modal fade" id="saveprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Input Transaksi DO
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
                <input type="hidden" name="invoice_id" value="{{ $doinvoice3->id }}">
                <input type="hidden" name="jenis" value="{{ $doinvoice3->jenis }}">
                <input type="hidden" name="qty" id="qty" value=0>

                <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Pilih Product</label>
                <div class="col-sm-10">
                <select class="form-control" style="width: 100%;" name="product_id" id="product_id">
                <option selected="selected">-- Pilih Product --</option>    
                    @foreach ($productsm as $row) 
                        <option value="{{ $row->id }}" data-subtitle="{{ $row->satuan }}" data-left="{{ asset('assets/img/noimage.png') }}" data-right="{{ $row->price }}" data-price="{{ $row->price }}">{{ $row->id }} - {{ $row->title }} - {{ $row->description}} </option>
                    @endforeach
                    <input value="activate" id="activate_selectator1" type="hidden"> 
                </select>                  
                </div>
                </div>

                @if (auth()->user()->level == 5)
                    <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Pilih Masalah</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width: 100%;" name="status" id="status">
                            <option selected="selected">-- Pilih Masalah Produk --</option>    
                            <option value="RUSAK">PRODUK RUSAK </option>
                            <option value="HILANG">PRODUK HILANG </option>
                        </select>                  
                    </div>
                    </div>
                @else
                    <input type="hidden" name="status" value="">
                @endif


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Qty</label>
                    <div class="col-sm-10">     
                        <input type="text" name="tally" id="qty-input" class="form-control">
                        <input type="hidden" name="price" id="price" value=0 class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Berat</label>
                    <div class="col-sm-10">     
                        <input type="text" name="berat" id="berat" class="form-control">
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

<div class="modal fade" id="tallyModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Proses Tally
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="row g-1" action="#" method="POST" id="save_tally_form" enctype="multipart/form-data">
                
                @csrf
                <input type="hidden" name="userid" id="userid" value="{{ Auth::user()->id  }}">
                <input type="hidden" name="id" id="id" value="{{ $doinvoice3->id }}">
                <input type="hidden" name="note" id="note" value="{{ $doinvoice3->note }}">
                <input type="hidden" name="member_id" value="{{ $doinvoice3->member_id }}">
                <input type="hidden" name="invoice_id" value="{{ $doinvoice3->id }}">
                <input type="hidden" name="jenis" value="{{ $doinvoice3->jenis }}">
                <input type="hidden" name="product_id" value="1">
                <input type="hidden" name="price" id="price" value=0>
                <input type="hidden" name="status" id="status" value="TALLY">
                <input type="hidden" name="qty" id="qty" value=0>

                <div class="col-sm-12" align="center">     
                 <input type="text" name="tally" id="input1" value=1  class="form-control" style="font-size: 88pt">
                <button class="form-control btn btn-primary increment-btn" style="font-size: 44pt">T A M B A H</button>   
                </div>


            </div>     
            <div class="modal-footer">
                    <button type="submit" id="save_tally_btn" class="btn btn-info mx-1">Simpan</a>
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
            </div>

            </form>
      
      </div>
  </div>
</div>

<!-- ===================== Start Upload Image ====================== -->
<div class="modal fade" id="uploadprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Gambar Product Rusak</h5>

              
              <form class="row g-1" action="#" method="POST" id="upload_prod_form" enctype="multipart/form-data">
                <input type="hiddenp" name="emp_id" id="emp_id">
                @csrf
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>File Browser 1</label>
                    <div class="col-sm-10">     
                        <br><img src="{{ asset('storage/images/15.jpg') }}" id="gambar_upload1" alt="..." class="profile.img_4" width='110' height='130' halign='center'>
                        <input type="file" name="image1a" id="image1a" class="form-control agbrIcon1" accept="image/*" capture="camera">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>File Browser 2</label>
                    <div class="col-sm-10">     
                        <br><img src="{{ asset('storage/images/15.jpg') }}" id="gambar_upload2" alt="..." class="profile.img_4" width='110' height='130' halign='center'>
                        <input type="file" name="image2a" id="image2a" class="form-control agbrIcon2" accept="image/*" capture="camera">
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

<div class="modal fade" id="uploadcontModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                Upload Gambar Container
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

              
              <form class="row g-1" action="#" method="POST" id="upload_cont_form" enctype="multipart/form-data">
                <input type="hidden" name="emp_id1" id="emp_id1">
                @csrf
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>Sebelum Buka Segel</label>
                    <div class="col-sm-10">     
                        <br><img src="{{ asset('storage/images/15.jpg') }}" id="gambar_upload3" alt="..." class="profile.img_4" width='110' height='70' halign='center'>
                        <input type="file" name="image3a" id="image3a" class="form-control agbrIcon3" accept="image/*" capture="camera">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>Foto Segel</label>
                    <div class="col-sm-10">     
                        <br><img src="{{ asset('storage/images/15.jpg') }}" id="gambar_upload4" alt="..." class="profile.img_4" width='110' height='70' halign='center'>
                        <input type="file" name="image4a" id="image4a" class="form-control agbrIcon4" accept="image/*" capture="camera">
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>Setelah Buka Segel</label>
                    <div class="col-sm-10">     
                        <br><img src="{{ asset('storage/images/15.jpg') }}" id="gambar_upload5" alt="..." class="profile.img_4" width='110' height='70' halign='center'>
                        <input type="file" name="image5a" id="image5a" class="form-control agbrIcon5" accept="image/*" capture="camera">
                    </div>
                </div>



                </div>
                <div class="modal-footer">
                        <button type="submit" id="upload_cont_btn" class="btn btn-info mx-1">Upload</a>
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                </div>

              </form>

            </div>
        
          </div>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="uploadvideoModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                Upload Video
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

              
              <form class="row g-1" action="#" method="POST" id="upload_video_form" enctype="multipart/form-data">
                <input type="hidden" name="emp_id2" id="emp_id2">
                @csrf
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>Upload Video</label>
                    <div class="col-sm-10">     
                        
                        <video width="300" height="150" autoplay loop muted controls>
                            <source src="{{  asset('storage/images/video/' . $doinvoice3->video1 . '') }}" id="video_upload1" type="video/mp4" autoplay=0 halign='center'> 
                        </video>
                        <input type="file" class="form-control mx-1 avideoIcon1" name="video1" id="video1" placeholder="Video Muat" accept="video/*" capture="camera">   
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                        <button type="submit" id="upload_video_btn" class="btn btn-info mx-1">Upload Video</a>
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                </div>

              </form>

            </div>
        
          </div>
          </div>
      </div>
  </div>
</div>