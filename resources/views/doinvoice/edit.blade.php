            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                
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

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
  
                  <form class="row g-1" action="{{ route('doinvoice_simpan') }}" method="POST" id="add_prod_form" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="userid" id="userid" value="{{ Auth::user()->id  }}">
                  <input type="hidden" name="status" id="status" value="ORDER">

                    @if ( $level == "5" )
                        <input type="hidden" name="jenis" id="jenis" value="MATERIAL">
                    @elseif ( $level == "6" )
                        <input type="hidden" name="jenis" id="jenis" value="UPAH">
                    @elseif ( $level == "7" )
                        <input type="hidden" name="jenis" id="jenis" value="PERALATAN">
                    @endif 

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Catatan</label>
                      <div class="col-sm-10">
                            <input type="text" class="form-control" id="note" name="note" required>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                      <div class="col-sm-10">
                          <input type="date" class="form-control" id="tanggal2" name="tanggal" onchange='cetakTanggal()' required>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Supplier / Mandor </label>
                      <div class="col-sm-10">
                          <select name="supplier_id" id="supplier_id" class="form-select" aria-label="Default select example">
                              <option selected>-- Pilih Supplier --</option>
                              @foreach ($suppliers as $row) 
                                  <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->nama }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>


                  @if ( $level == "6" )
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Form Payment Upah </label>
                        <div class="col-sm-10">
                            <select name="payment" id="payment" class="form-select" aria-label="Default select example">
                                <option selected>-- Pilih Payment Upah --</option>
                                <option value="KASBON">Kas Bon</option>
                                <option value="UPAH">Upah Tukang</option>
                            </select>
                        </div>
                    </div>
                  @endif

                  <div class="row mb-3" id="read3">
                  </div>

            </div>
                
            <div class="modal-footer">
                    <button type="submit" id="add_prod_btn" class="btn btn-info">Next</a>
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
            </div>

            </form>
      
      </div>
  </div>
</div>
<!-- ============== END ========================= -->

<!-- == start form Ubah === -->
<div class="modal fade" id="editprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
      
            <div class="modal-header">
                <h5 class="modal-title">Input Transaksi Kas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            
              
              <form class="row g-1" action="#" method="POST" id="edit_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                @csrf
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jenis Transaksi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kas_id" name="kas_id">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Akun Kasir 2</label>
                    <div class="col-sm-10">
                          <input type="text" class="form-control" id="cashier_id" name="cashier_id" value=""> 
                    </div>
                </div>

            </div>
                
            <div class="modal-footer">
                <button type="submit" id="edit_prod_btn" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
            
            </div>
            </form>

      </div>
  </div>
</div>
<!-- ============== END ============= -->

<!-- ===================== Start Upload Image ====================== -->

<div class="modal fade" id="uploadprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Gambar Nota Supplier</h5>

              
              <form class="row g-1" action="#" method="POST" id="upload_prod_form" enctype="multipart/form-data">
                <input type="hidden" name="emp_id3" id="emp_id3">
                @csrf
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center"><br><br>File Browser 1</label>
                    <div class="col-sm-10">     
                        <br><img src="{{ asset('storage/images/15.jpg') }}" id="gambar_upload1" alt="..." class="profile.img_4" width='110' height='130' halign='center'>
                        <input type="file" name="image1a" id="image1a" class="form-control agbrIcon1">
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
