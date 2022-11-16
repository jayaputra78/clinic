            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Rekening</h5>

             
              <form class="row g-1" action="#" method="POST" id="add_prod_form" enctype="multipart/form-data">
                @csrf
                
                <div class="col-12">
                  <label for="account2" class="form-label">Kode</label>
                  <input type="text" name="account" id="account2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="keterangan2" class="form-label">Rekening</label>
                  <input type="text" name="keterangan" id="keterangan2" class="form-control">
                </div>


                <div class="col-12">
                    <label for="chart_id2" class="form-label">Group</label>
                    <select name="chart_id" id="chart_id2" class="form-control">
                    <option value="">---- Select Group ---- </option>
                        @foreach ($charts as $row)
                            <option value="{{ $row->id }}">{{ $row->chart }} - {{ $row->keterangan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                  <label for="kelompok2" class="form-label">Kelompok</label>
                         <select name="kelompok" id="kelompok2" class="form-control" required>
                            <option value="">---- Pilih Kelompok ----</option>
                            <option value="1">AKTIVA</option>
                            <option value="2">PASSIVA</option>
                            <option value="3">MODAL</option>
                            <option value="4">PENDAPATAN</option>
                            <option value="5">BIAYA</option>
                        </select>
                </div>

                <div class="text-center">
                  <button type="submit" id="add_prod_btn" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                </div>
              </form>

            </div>
        
          </div>
          </div>
      </div>
  </div>
</div>
<!-- ============== END ========================= -->

<!-- == start form Ubah === -->
<div class="modal fade" id="editprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Supplier</h5>

              
              <form class="row g-1" action="#" method="POST" id="edit_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                @csrf

                <div class="col-12">
                  <label for="account" class="form-label">Kode</label>
                  <input type="text" name="account" id="account" class="form-control">
                </div>

                <div class="col-12">
                  <label for="keterangan" class="form-label">Rekening</label>
                  <input type="text" name="keterangan" id="keterangan" class="form-control">
                </div>


                <div class="col-12">
                    <label for="chart_id" class="form-label">Group</label>
                    <select name="chart_id" id="chart_id" class="form-control">
                    <option value="">-- Select Group --</option>
                    @foreach ($charts as $row)
                        <option value="{{ $row->id }}">{{ $row->chart }} - {{ $row->keterangan }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="col-12">
                  <label for="kelompok" class="form-label">Kelompok</label>
                        <select name="kelompok" id="kelompok" class="form-control" required>
                            <option value="1" id="status1">AKTIVA</option>
                            <option value="2" id="status2">PASSIVA</option>
                            <option value="3" id="status3">MODAL</option>
                            <option value="4" id="status4">PENDAPATAN</option>
                            <option value="5" id="status5">BIAYA</option>
                        </select>
                </div>

                <div class="text-center">
                  <button type="submit" id="edit_prod_btn" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                </div>
              </form>

            </div>
        
          </div>
          </div>
      </div>
  </div>
</div>
<!-- ============== END ============= -->


<!-- == start form Upload === -->
<div class="modal fade" id="importprodModal_" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Import File Excel Cashier</h5>

              
              <form class="row g-1" action="#" method="POST" id="import_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                @csrf

                <div class="col-12">
                  <label for="filexlsimport" class="form-label">File Xls Cashier</label>
                  <input type="file" name="filexlsimport" id="filexlsimport" class="form-control">
                </div>

                <div class="text-center">
                  <button type="submit" id="import_prod_btn" class="btn btn-primary">Import</button>
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                </div>
              </form>

            </div>
        
          </div>
          </div>
      </div>
  </div>
</div>
<!-- ============== END ============= -->