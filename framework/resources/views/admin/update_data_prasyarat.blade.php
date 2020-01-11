@extends('admin/base')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Ubah Data Prasyarat</h4>
                  <p class="card-description">
                  </p>
                  <div class="form-group">
                    <label for="exampleFormControlSelect2">Status</label>
                    <select class="form-control" id="exampleFormControlSelect2">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                  </div>
                  <div class="form-group">
                  <div class="form-group">
                      <label for="exampleTextarea1">Catatan</label>
                      <textarea class="form-control" id="exampleTextarea1" rows="2"></textarea>
                    </div>
                    
                  <div class="form-group">
                  </div>
                <button type="submit" class="btn btn-success mr-2">Ubah</button>
              </div>
            </div>
@endsection