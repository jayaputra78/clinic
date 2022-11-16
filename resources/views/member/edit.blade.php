            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Project</h5>

             
              <form class="row g-1" action="#" method="POST" id="add_prod_form" enctype="multipart/form-data">
                @csrf
                
                <div class="col-12">
                  <label for="kta2" class="form-label">Nama Project</label>
                  <input type="text" name="kta" id="kta2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="name2" class="form-label">Nama Perusahaan</label>
                  <input type="text" name="name" id="name2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="address2" class="form-label">Lokasi</label>
                  <input type="text" name="address" id="address2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="pengurus2" class="form-label">Supervisor</label>
                  <input type="text" name="pengurus" id="pengurus2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="nilai2" class="form-label">Nilai Project</label>
                  <input type="text" name="nilai" id="nilai2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="biaya2" class="form-label">Rencana Biaya</label>
                  <input type="text" name="biaya" id="biaya2" class="form-control">
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
                  <label for="kta2" class="form-label">Nama Project</label>
                  <input type="text" name="kta" id="kta" class="form-control">
                </div>

                <div class="col-12">
                  <label for="name2" class="form-label">Nama Perusahaan</label>
                  <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="col-12">
                  <label for="address2" class="form-label">Lokasi</label>
                  <input type="text" name="address" id="address" class="form-control">
                </div>

                <div class="col-12">
                  <label for="pengurus2" class="form-label">Supervisor</label>
                  <input type="text" name="pengurus" id="pengurus" class="form-control">
                </div>

                <div class="col-12">
                  <label for="nilai2" class="form-label">Nilai Project</label>
                  <input type="text" name="nilai" id="nilai" class="form-control">
                </div>

                <div class="col-12">
                  <label for="biaya2" class="form-label">Rencana Biaya</label>
                  <input type="text" name="biaya" id="biaya" class="form-control">
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
              <h5 class="card-title">Import File Excel Kategori</h5>

              
              <form class="row g-1" action="#" method="POST" id="import_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                @csrf

                <div class="col-12">
                  <label for="filexlsimport" class="form-label">File Xls Kategori</label>
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