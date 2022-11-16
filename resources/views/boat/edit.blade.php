            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
            
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Kapal</h5>

             
              <form class="row g-1" action="#" method="POST" id="add_prod_form" enctype="multipart/form-data">
                @csrf
                
                <div class="col-12">
                  <label for="nama2" class="form-label">Nama Kapal</label>
                  <input type="text" name="nama" id="nama2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="keterangan2" class="form-label">Keterangan</label>
                  <input type="text" name="keterangan" id="keterangan2" class="form-control">
                </div>

                <div class="col-12">
                  <label for="status2" class="form-label">Status</label>
                        <select name="status" id="status2" class="form-control" required>
                        @php $level = auth()->user()->level; @endphp
                        @if ($level > 1)
                          <option value="">-- Select Status --</option>
                          <option value="AKTIF">AKTIF</option>
                          <option value="PENDING">PENDING</option>
                        @else
                          <option value="">-- Select Status --</option>
                          <option value="AKTIF">AKTIF</option>
                          <option value="PENDING">PENDING</option>
                          <option value="NONAKTIF">TIDAK AKTIF</option>
                        @endif
                        </select>
                </div>

                <div class="col-12">
                    <label for="member_id" class="form-label">Member</label>
                    @php $level = auth()->user()->level; @endphp

                    @if ( $level > 1 )
                          <select name="member_id" id="member_id2" class="form-control" required>
                          <option value="{{ auth()->user()->member_id }}" selected>{{ auth()->user()->member_id }} - {{ auth()->user()->member->name }}</option>
                          </select>
                    @else
                          
                          <select name="member_id" id="member_id2" class="form-control" required>
                          <option value="">-- Select Member --</option>
                              @foreach ($members as $row) 
                                  <option value="{{ $row->id }}">{{ $row->kta }} - {{ $row->name }}</option>
                              @endforeach
                          </select>
                    @endif
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
              <h5 class="card-title">Edit Gudang Tujuan</h5>

              
              <form class="row g-1" action="#" method="POST" id="edit_prod_form" enctype="multipart/form-data">

                <input type="hidden" name="emp_id" id="emp_id">
                @csrf

                <div class="col-12">
                  <label for="nama" class="form-label">Nama Gudang</label>
                  <input type="text" name="nama" id="nama" class="form-control">
                </div>

                <div class="col-12">
                  <label for="keterangan" class="form-label">Keterangan</label>
                  <input type="text" name="keterangan" id="keterangan" class="form-control">
                </div>

                <div class="col-12">
                  <label for="status2" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                        @php $level = auth()->user()->level; @endphp
                        @if ($level > 1)
                          <option value="AKTIF">AKTIF</option>
                          <option value="PENDING">PENDING</option>
                        @else
                          <option value="">-- Select Status --</option>
                          <option value="AKTIF">AKTIF</option>
                          <option value="PENDING">PENDING</option>
                          <option value="NONAKTIF">TIDAK AKTIF</option>
                        @endif
                        </select>
                </div>

                <div class="col-12">
                    <label for="member_id" class="form-label">Member</label>
                    @php $level = auth()->user()->level; @endphp

                    @if ( $level > 1 )
                          <select name="member_id" id="member_id" class="form-control" required>
                          <option value="{{ auth()->user()->member_id }}" selected>{{ auth()->user()->member_id }} - {{ auth()->user()->member->name }}</option>
                          </select>
                    @else
                          
                          <select name="member_id" id="member_id" class="form-control" required>
                          <option value="">-- Select Member --</option>
                              @foreach ($members as $row) 
                                  <option value="{{ $row->id }}">{{ $row->kta }} - {{ $row->name }}</option>
                              @endforeach
                          </select>
                    @endif
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