            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Username</h5>

             
              <form class="row g-1" action="#" method="POST" id="add_prod_form" enctype="multipart/form-data">
                @csrf
                
                <div class="col-12">
                  <label for="name2" class="form-label">Nama User</label>
                  <input type="text" name="name" id="name2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="email2" class="form-label">Username</label>
                  <input type="text" name="email" id="email2" class="form-control">
                </div>


                <div class="col-12">
                  <label for="password2" class="form-label">Password</label>
                  <input type="password" name="password" id="password2" class="form-control">
                </div>

                <div class="col-12">
                    <label for="member_id2" class="form-label">Member</label>
                    <select name="member_id" id="member_id2" class="form-control">
                   
                    <?php  $level = auth()->user()->level;	 ?>
                    @if ( $level > 1 )
                        <option value="{{ auth()->user()->member_id }}" selected>{{ auth()->user()->member_id }} - {{ auth()->user()->member->name }}</option>
                    @else
                        <option value="">---- Select Member ---- </option>
                        @foreach ($members as $row)
                            <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->name }}</option>
                        @endforeach
                    @endif
                    </select>
                </div>

                <div class="col-12">
                  <label for="level2" class="form-label">Level</label>
                         <select name="level" id="level2" class="form-control" required>
                            <option value="">---- Pilih Level ----</option>
                            @php $level = auth()->user()->level; @endphp
                            @if ( $level > 1 )
                                <option value="3">3 - Manager</option>
                                <option value="4">4 - Keuangan</option>
                                <option value="5">5 - Operator</option>
                            @else
                                <option value="1">1 - Admin</option>
                                <option value="2">2 - Owner</option>
                                <option value="3">3 - Manager</option>
                                <option value="4">4 - Keuangan</option>
                                <option value="5">5 - Operator</option>
                            @endif
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
              <h5 class="card-title">Edit Username</h5>

              
              <form class="row g-1" action="#" method="POST" id="edit_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                @csrf

                <div class="col-12">
                  <label for="name2" class="form-label">Nama User</label>
                  <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="col-12">
                  <label for="email2" class="form-label">Username</label>
                  <input type="text" name="email" id="email" class="form-control">
                </div>


                <div class="col-12">
                  <label for="password2" class="form-label">Password</label>
                  <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="col-12">
                    <label for="member_id2" class="form-label">Member</label>
                   
                    @php $level = auth()->user()->level; @endphp
                    @if ( $level > 1 )
                        <input type="text" value="{{ auth()->user()->member_id }}" class="form-control" disabled>
                        <input type="hidden" name="member_id" id="member_id" value="{{ auth()->user()->member_id }}">
                    @else
                      <select name="member_id" id="member_id" class="form-control">
                        <option value="">---- Select Member ---- </option>
                        @foreach ($members as $row)
                            <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->name }}</option>
                        @endforeach
                      </select>
                    @endif  
                  
                </div>

                <div class="col-12">
                  <label for="level2" class="form-label">Level</label>
                         <select name="level" id="level" class="form-control" required>
                            <option value="">---- Pilih Level ----</option>
                            @php $level = auth()->user()->level; @endphp
                            @if ( $level > 1 )
                                <option value="3" id="status3">3 - Manager</option>
                                <option value="4" id="status4">4 - Keuangan</option>
                                <option value="5" id="status5">5 - Operator</option>
                            @else
                                <option value="1" id="status1">1 - Admin</option>
                                <option value="2" id="status2">2 - Owner</option>
                                <option value="3" id="status3">3 - Manager</option>
                                <option value="4" id="status4">4 - Keuangan</option>
                                <option value="5" id="status5">5 - Operator</option>
                            @endif
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