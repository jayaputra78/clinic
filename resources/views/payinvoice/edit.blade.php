            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Transaksi Kas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
  
                  <form class="row g-1" action="{{ route('payinvoice_simpan') }}" method="POST" id="add_prod_form" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="userid" id="userid" value="{{ Auth::user()->id  }}">
                  <input type="hidden" class="form-control note" id="note" name="note" placeholder="Nomor Kas" required>

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Jenis Transaksi</label>
                      <div class="col-sm-10">
                          <select name="kas_id" id="kas_id2" class="form-select" aria-label="Default select example">
                              <option selected>-- Pilih Transaksi --</option>
                              <option value="PB">Kas Masuk</option>
                              <option value="KB">Kas Keluar</option>
                              <option value="PH">Terima Piutang</option>
                              <option value="KH">Pembayaran Hutang</option>
                              <option value="IT">Inhouse Transfer</option>
                          </select>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                      <div class="col-sm-10">
                          <input type="date" class="form-control" id="tanggal2" name="tanggal" onchange='cetakTanggal()' required>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Akun Kasir Asal</label>
                      <div class="col-sm-10">
                          <select name="cashier_id" id="cashier_id2" class="form-select" aria-label="Default select example">
                              <option selected>-- Pilih Akun Kasir Asal --</option>
                              @foreach ($cashier as $cashier) 
                                  <option value="{{ $cashier->id }}">{{ $cashier->no_rek }} - {{ $cashier->member->kta }} - {{ $cashier->member->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>

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
