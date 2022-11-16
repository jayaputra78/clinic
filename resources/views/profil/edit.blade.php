    

<!-- ===================== Start Upload Image ====================== -->

<div class="modal fade" id="uploadprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Foto Profil</h5>

              
              <form class="row g-1" action="#" method="POST" id="upload_prod_form" enctype="multipart/form-data">
                <input type="hidden" name="emp_id" id="emp_id" value="{{ Auth::user()->id }}">
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