@extends('main')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<style>
.content_center {
  display: flex;
  justify-content: center;
  align-items: center; 
  width: 100px;
  height: 70px;
}
</style>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{$title}} Terhapus</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
    <!-- /.content-header -->

    <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card-header">
              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Something it's wrong:
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ Session::get('success') }}
                </div>
              @endif
              @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ Session::get('error') }}
                </div>
              @endif                  
            </div>
            <div class="card-body">
              <div class="container col-md-10">
                <div align="right">                
                    <a href="/satuan" style="width:150px; text-align:center;" type="Submit" class="btn form-control alert-info"> {{$title}} </a>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table" id="mytable">
                        <thead class="text-primary">
                          <tr>
                            <th>No</th>
                            <th>Satuan</th>
                            <th style="text-align:center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $i = 1;
                          foreach ($data as $data){ ?>
                            <tr>
                            <td>{{$i}}</td>
                              <td>{{$data->satuan}}</td>
                              <td style="text-align:center" width="100px">
                                <a id="index" class="navbar-brand" href="" data-toggle="modal" data-target="#deleteModal{{$data->id}}"><i class="ion-refresh"></i></a>
                              </td>
                            </tr>

                            <!-- Modal Hapus -->
                            <div id="deleteModal{{$data->id}}" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="card-header">
                                    <h5 class="title">Hapus Data {{$title}}</h5>
                                  </div>
                                  <div class="card-body">
                                    <form action="/satuan/undestroy/{{$data->id}}" method="get">
                                      @csrf
                                      <div class="row">
                                        <div class="col-md-12 pr-8">
                                          <div class="form-group">
                                            <label>Apakah anda yakin akan mengembalikan data Satuan {{$data->satuan}}</label>
                                          </div>
                                        </div>
                                      </div>                  
                                      <br>
                                      <div class="row">
                                        <div class="col-md-6 pr-8">
                                          <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block" name="input" id="input">Kembalikan Data</button>
                                          </div>
                                        </div>
                                        <div class="col-md-6 pr-8">
                                          <div class="form-group">
                                            <a type="Submit" data-dismiss="modal" class="btn btn-primary btn-block">Batal</a>
                                          </div>
                                        </div>
                                      </div>
                                      <hr>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Modal Hapus--> 
                               
                            <?php 
                            $i++;
                          } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </div>
        </section>
      </div>
    </div>
  </section>
</div>
@endsection