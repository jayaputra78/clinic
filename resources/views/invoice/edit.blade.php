            
<!-- == start form tambah === -->
<div class="modal fade" id="addprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title">Input Transaksi DO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

                  <form class="row g-1" action="{{ route('invinvoice_simpan') }}" method="POST" id="add_prod_form" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="userid" id="userid" value="{{ Auth::user()->id  }}">
                  <input type="hidden" name="member_id" id="member_id" value="{{ Auth::user()->member_id  }}">
                  <input type="hidden" name="status" id="status" value="0">

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Jenis Transaksi </label>
                      <div class="col-sm-10">
                          <select name="jenis" id="jenis" class="form-select" aria-label="Default select example">
                              <option selected>-- Pilih Transaksi --</option>
                              <option value="MUAT">MUAT - CONTAINER</option>
                              <option value="BONGKAR">BONGKAR - CONTAINER</option>
                              <option value="MUATCARGO">MUAT - GENERAL CARGO</option>
                              <option value="BONGKARCARGO">BONGKAR - GENERAL CARGO</option>
                              <option value="MUATCURAH">MUAT - CURAH</option>
                              <option value="BONGKARCURAH">BONGKAR - CURAH</option>
                          </select>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                      <div class="col-sm-10">
                          <input type="date" class="form-control" id="tanggal2" name="tanggal" onchange='cetakTanggal()' required>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Expedisi </label>
                      <div class="col-sm-10">
                          <select name="customer_id" id="customer_id" class="form-select" aria-label="Default select example">
                              <option selected>-- Pilih Expedisi --</option>
                              @foreach ($customers as $row) 
                                  <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Gudang </label>
                      <div class="col-sm-10">
                          <select name="warehouse_id" id="warehouse_id" class="form-select" aria-label="Default select example">
                              <option selected>-- Pilih Gudang --</option>
                              @foreach ($warehouses as $row) 
                                  <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->nama }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="row mb-3" id="read2">
                  </div>

                  <div class="row mb-3" id="read3">
                  </div>

                  <div class="row mb-3" id="read4">
                  </div>

            </div>
            <div class="modal-footer">
                    <button type="submit" id="add_prod_btn" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                    </form>
            </div>

            </form>
      
      </div>
  </div>
</div>
<!-- ============== END ========================= -->

<!-- == start form Ubah === -->
<div class="modal fade" id="editprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">
      
            <div class="modal-header">
                <h5 class="modal-title">Penugasan Operator Tally</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            
              
              <form class="row g-1" action="#" method="POST" id="edit_prod_form" enctype="multipart/form-data">

                <input type="text" name="emp_id5" id="emp_id5">
                @csrf
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Operator</label>
                    <div class="col-sm-10">
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Select Operator --</option>
                            @foreach ($users as $row) 
                                  <option value="{{ $row->id }}">{{ $row->id }} - {{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jadwal Tally</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control " id="jadwal" name="jadwal" placeholder="Jadwal Tally" required>
                    </div>
                </div>

            </div>
                
            <div class="modal-footer">
                <button type="submit" id="edit_prod_btn" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
            </div>
            </form>

      </div>
  </div>
</div>
<!-- ============== END ============= -->

<!-- ===================== Start Upload Image ====================== -->

<div class="modal fade" id="uploadprodModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 99%">
      <div class="modal-content">

      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title">Proses Tagihan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                         
              <form class="row g-1" action="#" method="POST" id="upload_prod_form" enctype="multipart/form-data">
                <input type="hidden" name="emp_id4" id="emp_id4">
                @csrf
                

                <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">No DO</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" id="nodo2" name="nodo">
                      </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" valign="center">Jenis Container</label>
                    <div class="col-sm-10">     
                        <select name="total" id="total" class="form-select" aria-label="Default select example">
                        <option selected>-- Pilih Container --</option>
                        <option value="100000">Container 20" - 100.000</option>
                        <option value="200000">Container 40" - 200.000</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                    <button type="submit" id="upload_prod_btn" class="btn btn-primary">Proses Tagihan</button>
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                    </form>
            </div>

            </form>

            </div>
        
          </div>
          </div>
      </div>
  </div>
</div>

<!-- ===================== End Upload Image ====================== -->
