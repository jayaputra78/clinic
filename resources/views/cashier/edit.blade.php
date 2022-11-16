            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Cashier</h5>

             
              <form class="row g-1" action="#" method="POST" id="add_prod_form" enctype="multipart/form-data">
                @csrf
                
                <div class="col-12">
                  <label for="nama2" class="form-label">Kode Akun Kasir</label>
                  <input type="text" name="no_rek" id="no_rek2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="alamat2" class="form-label">Nama Akun Kasir</label>
                  <input type="text" name="bank" id="bank2" class="form-control">
                </div>


                <div class="col-12">
                    <label for="account_id" class="form-label">Rekening</label>
                    <select name="account_id" id="account_id2" class="form-control">
                    <option value="">Select Rekening</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->account }} - {{ $account->keterangan }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="member_id" class="form-label">Member</label>
                    <select name="member_id" id="member_id2" class="form-control" required>
                    <option value="{{ auth()->user()->member_id }}" selected>{{ auth()->user()->member_id }} - {{ auth()->user()->member->name }}</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="level2" class="form-label">Status</label>
                         <select name="level" id="level2" class="form-control" required>
                            <option value="">---- Pilih Level ----</option>
                            <option value="4">KAS KANTOR</option>
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
                  <label for="nama2" class="form-label">Kode Akun Kasir</label>
                  <input type="text" name="no_rek" id="no_rek" class="form-control">
                </div>

                <div class="col-12">
                  <label for="alamat2" class="form-label">Nama Akun Kasir</label>
                  <input type="text" name="bank" id="bank" class="form-control">
                </div>


                <div class="col-12">
                    <label for="account_id" class="form-label">Rekening</label>
                    <select name="account_id" id="account_id" class="form-control">
                    <option value="">Select Rekening</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->account }} - {{ $account->keterangan }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="member_id" class="form-label">Member</label>
                    <select name="member_id" id="member_id" class="form-control" required>
                    <option value="{{ auth()->user()->member_id }}" selected>{{ auth()->user()->member_id }} - {{ auth()->user()->member->name }}</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="level2" class="form-label">Status</label>
                         <select name="level" id="level" class="form-control" required>
                            <option value="4" id="status3">KAS KANTOR</option>
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