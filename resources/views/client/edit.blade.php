            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Customer</h5>

             
              <form class="row g-1" action="#" method="POST" id="add_prod_form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="member_id" value="{{ auth()->user()->member_id }}">

                <div class="col-12">
                  <label for="kta2" class="form-label">Kode Customer</label>
                  <input type="text" name="kta" id="kta2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="name2" class="form-label">Nama Customer</label>
                  <input type="text" name="name" id="name2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="address2" class="form-label">Alamat</label>
                  <input type="text" name="address" id="address2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="phone2" class="form-label">Telp</label>
                  <input type="text" name="phone" id="phone2" class="form-control">
                </div>
                
                <div class="col-12">
                  <label for="email2" class="form-label">Email</label>
                  <input type="text" name="email" id="email2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="pimpinan2" class="form-label">Kontak Person</label>
                  <input type="text" name="pimpinan" id="pimpinan2" class="form-control">
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
              <h5 class="card-title">Edit Customer</h5>

              
              <form class="row g-1" action="#" method="POST" id="edit_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                <input type="hidden" name="member_id" value="{{ auth()->user()->member_id }}">
                @csrf


                <div class="col-12">
                  <label for="kta" class="form-label">Kode Customer</label>
                  <input type="text" name="kta" id="kta" class="form-control">
                </div>

                <div class="col-12">
                  <label for="name" class="form-label">Nama Customer</label>
                  <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="col-12">
                  <label for="address" class="form-label">Alamat Customer</label>
                  <input type="text" name="address" id="address" class="form-control">
                </div>


                <div class="col-12">
                  <label for="phone" class="form-label">Telp</label>
                  <input type="text" name="phone" id="phone" class="form-control">
                </div>
                
                <div class="col-12">
                  <label for="email2" class="form-label">Email</label>
                  <input type="text" name="email" id="email" class="form-control">
                </div>

                <div class="col-12">
                  <label for="pimpinan" class="form-label">Kontak Person</label>
                  <input type="text" name="pimpinan" id="pimpinan" class="form-control">
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