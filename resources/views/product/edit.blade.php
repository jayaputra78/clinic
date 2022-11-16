            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Input Produk Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                        
              <form class="row g-1" action="#" method="POST" id="add_prod_form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="price_j2" id="price_j22" class="form-control" placeholder="Kode Produk">


                <div class="col-12">
                  <select name="group_id" id="group_id2" class="form-control" required>
                      <option value="">-- Select Kategori --</option>
                      @foreach ($group as $row) 
                            <option value="{{ $row->id }}">{{ $row->title }} - {{ $row->description }}</option> 
                      @endforeach
                  </select>
                </div>

                <div class="col-12">
                  <input type="text" name="title" id="title2" class="form-control" placeholder="Kode Produk">
                </div>

                <div class="col-12">
                  <input type="text" name="description" id="description2" class="form-control" placeholder="Nama Produk">
                </div>

                
                <div class="col-12" >
                  <input type="text" name="satuan" id="satuan2" class="form-control" placeholder="Satuan">
                </div>

             

      </div>
      <div class="modal-footer">
                  <button type="submit" id="add_prod_btn" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                  </form>
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
              <h5 class="card-title">Edit Product</h5>

              
              <form class="row g-1" action="#" method="POST" id="edit_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                <input type="hidden" name="price_j2" id="price_j22" class="form-control" placeholder="Kode Produk">
                @csrf


                <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Kategori</label>
                      <div class="col-sm-10">
                  <select name="group_id" id="group_id" class="form-control" required>
                      <option value="">-- Select Kategori --</option>
                      @foreach ($group as $row) 
                            <option value="{{ $row->id }}">{{ $row->title }} - {{ $row->description }}</option> 
                      @endforeach
                  </select>
                  </div>
                </div>

                <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Kode</label>
                      <div class="col-sm-10">
                          <input type="text" name="title" id="title" class="form-control" placeholder="Kode Produk">
                      </div>
                </div>

                <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nama Produk</label>
                      <div class="col-sm-10">
                  <input type="text" name="description" id="description" class="form-control" placeholder="Nama Produk">
                  </div>
                </div>


                <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Satuan</label>
                      <div class="col-sm-10">
                  <input type="text" name="satuan" id="satuan" class="form-control">
                </div></div>

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