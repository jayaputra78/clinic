@extends('layout.index')
@section('content')
@parent
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">


              @if ( auth()->user()->image1 ) 
                <img src="{{ asset('storage/images/' . Auth::user()->image1 . '') }}" alt="{{ Auth::user()->image1 }}" class="rounded-circle">
              @else
                <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="{{ Auth::user()->image1 }}" class="rounded-circle">
              @endif
              <h2>{{ Auth::user()->name }}</h2>
              <h3>
              @if ( auth()->user()->level==1 ) 
                  {{ Auth::user()->level }} - Administrator 
              @elseif  (auth()->user()->level == 2 )  
                  {{ Auth::user()->level }} - Owner  
              @elseif  (auth()->user()->level == 3 )  
                  {{ Auth::user()->level }} - Mgr Operasional        
              @elseif  (auth()->user()->level == 4 )  
                  {{ Auth::user()->level }} - Mgr. Keuangan
              @elseif  (auth()->user()->level == 5 )  
                  {{ Auth::user()->level }} - Material 
              @elseif  (auth()->user()->level == 6 )  
                  {{ Auth::user()->level }} - Upah 
              @elseif  (auth()->user()->level == 7 )  
                  {{ Auth::user()->level }} - Peralatan
              @elseif  (auth()->user()->level == 8 )  
                  {{ Auth::user()->level }} - Admin Proyek
              @endif
              </h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic">{{ Auth::user()->name }}</p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">{{ Auth::user()->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Project</div>
                    <div class="col-lg-9 col-md-8">{{ Auth::user()->member->kta }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Perusahaan</div>
                    <div class="col-lg-9 col-md-8">{{ Auth::user()->member->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Jabatan</div>
                    <div class="col-lg-9 col-md-8">

                        @if ( auth()->user()->level==1 ) 
                            {{ Auth::user()->level }} - Administrator 
                            <?php $jabatan = "Administrator"; ?> 
                        @elseif  (auth()->user()->level == 2 )  
                            {{ Auth::user()->level }} - Owner  
                            <?php $jabatan = "Owner"; ?>
                        @elseif  (auth()->user()->level == 3 )  
                            {{ Auth::user()->level }} - Mgr Operasional  
                            <?php $jabatan = "Mgr. Operasional"; ?>      
                        @elseif  (auth()->user()->level == 4 )  
                            {{ Auth::user()->level }} - Mgr. Keuangan
                            <?php $jabatan = "Mgr. Keuangan"; ?>
                        @elseif  (auth()->user()->level == 5 )  
                            {{ Auth::user()->level }} - Material 
                            <?php $jabatan = "Material"; ?>
                        @elseif  (auth()->user()->level == 6 )  
                            {{ Auth::user()->level }} - Upah 
                            <?php $jabatan = "Upah"; ?>
                        @elseif  (auth()->user()->level == 7 )  
                            {{ Auth::user()->level }} - Peralatan
                            <?php $jabatan = "Peralatan"; ?>
                        @elseif  (auth()->user()->level == 8 )  
                            {{ Auth::user()->level }} - Admin Proyek
                            <?php $jabatan = "Admin Proyek"; ?>
                        @endif

                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8">{{ Auth::user()->alamat }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8">{{ Auth::user()->nohp }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form class="row g-1" action="#" method="POST" id="save_profil_form" enctype="multipart/form-data">

                    <input type="hidden" name="emp_id2" id="emp_id2" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="image1" id="image1" value="{{ auth()->user()->image1 }}">
                    @csrf

                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        @if ( auth()->user()->image1 ) 
                          <img src="{{ asset('storage/images/' . Auth::user()->image1 . '') }}" alt="{{ Auth::user()->image1 }}" id="gambar_upload2">
                        @else
                          <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="{{ Auth::user()->image1 }}" id="gambar_upload2">
                        @endif

                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" data-bs-toggle="modal" data-bs-target="#uploadprodModal" data-bs-placement="top"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="name" value="{{ Auth::user()->name }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="catatan" class="col-md-4 col-lg-3 col-form-label">About</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="catatan" class="form-control" id="catatan" style="height: 100px" value="{{ Auth::user()->catatan }}">{{ Auth::user()->catatan }}</textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Project</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="company" type="text" class="form-control" id="company" value="{{ Auth::user()->member->kta }}" disabled>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Perusahaan</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="job" type="text" class="form-control" id="Job" value="{{ Auth::user()->member->name }}" disabled>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="country" type="text" class="form-control" id="Country" value="{{ $jabatan }}" disabled>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control" id="Address" value="{{ Auth::user()->alamat }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" value="{{ Auth::user()->nohp }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="twitter" type="text" class="form-control" id="Twitter" value="https://twitter.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="facebook" type="text" class="form-control" id="Facebook" value="https://facebook.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="instagram" type="text" class="form-control" id="Instagram" value="https://instagram.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" id="save_profil_btn" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

    @include('profil.edit')
  </main>


<script type="text/javascript">      
$(function() {

    $(document).on('change', '.agbrIcon1', function(e) {
           let reader = new FileReader();
           reader.onload = (e) => { 
             $('#gambar_upload1').attr('src', e.target.result); 
           }
           reader.readAsDataURL(this.files[0]); 
    });
    
    $("#upload_prod_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#upload_prod_btn").text('Upload ...');
            $.ajax({
                url: '{{ route('profil_update2') }}',
                method: 'post',
                data: fd, 
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                if (response.status == 200) {
                    Swal.fire(
                    'Updated!',
                    'Images Uploaded Successfully!',
                    'success'
                    );
                    location.reload();
                }
                $("#upload_prod_btn").text('Upload');
                $("#upload_prod_form")[0].reset();
                $("#uploadprodModal").modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
                
            });
    });

    $("#save_profil_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            var text = $('textarea#catatan').val();
            $("#save_profil_btn").text('Upload ...');
            $.ajax({
                url: '{{ route('profil_update') }}',
                method: 'post',
                data: fd, text,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                if (response.status == 200) {
                    Swal.fire(
                    'Updated!',
                    'Update Profil Successfully!',
                    'success'
                    );
                   location.reload();
                }
                $("#save_profil_btn").text('Save Changes');
                $("#save_profil_form")[0].reset();
               // $("#uploadprodModal").modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
                
            });
    });


});
</script>

@endsection