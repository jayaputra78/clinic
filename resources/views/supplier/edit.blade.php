            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Supplier</h5>

             
              <form class="row g-1" action="#" method="POST" id="add_prod_form" enctype="multipart/form-data">
                @csrf


                <div class="col-12">
                  <label for="nama2" class="form-label">Nama Supplier</label>
                  <input type="text" name="nama" id="nama2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="alamat2" class="form-label">Alamat</label>
                  <input type="text" name="alamat" id="alamat2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="telp2" class="form-label">Telp</label>
                  <input type="text" name="telp" id="telp2" class="form-control">
                </div>
                
                <div class="col-12">
                  <label for="kota2" class="form-label">Kota</label>
                  <input type="text" name="kota" id="kota2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="pic2" class="form-label">Kontak Person</label>
                  <input type="text" name="pic" id="pic2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="status2" class="form-label">Status</label>
                         <select name="status" id="status2" class="form-control" required>
                            <option value="">---- Pilih Status ----</option>
                            <option value="OK">Aktif</option>
                            <option value="OFF">Tidak Aktif</option>
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
                  <label for="nama" class="form-label">Nama Supplier</label>
                  <input type="text" name="nama" id="nama" class="form-control">
                </div>

                <div class="col-12">
                  <label for="alamat" class="form-label">Alamat Supplier</label>
                  <input type="text" name="alamat" id="alamat" class="form-control">
                </div>


                <div class="col-12">
                  <label for="telp" class="form-label">Telp</label>
                  <input type="text" name="telp" id="telp" class="form-control">
                </div>
                
                <div class="col-12">
                  <label for="kota2" class="form-label">Kota</label>
                  <input type="text" name="kota" id="kota" class="form-control">
                </div>

                <div class="col-12">
                  <label for="pic" class="form-label">Kontak Person</label>
                  <input type="text" name="pic" id="pic" class="form-control">
                </div>

                <div class="col-12">
                  <label for="status" class="form-label">Status</label>
                        <select name="status"  id="status" class="form-control" required>
                            <option value="OK" id="status3">Aktif</option>
                            <option value="OFF" id="status4">Tidak Aktif</option>
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
<div class="modal fade" id="importprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Import File Excel Supplier</h5>

              
              <form class="row g-1" action="#" method="POST" id="import_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                @csrf

                <div class="col-12">
                  <label for="filexlsimport" class="form-label">File Xls Supplier</label>
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