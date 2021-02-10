@extends('main')
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
            <h1 class="m-0">{{$title}}</h1>
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
              @if(session('errors'))
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
                        <!-- <a href="" style="background-color: #FF7F00; width:180px; text-align:center; font-weight:bold;" data-toggle="modal" data-target="#createModal" type="Submit" class="btn form-control"> Insert Data </a> -->
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table" id="mytable">
                            <thead class="text-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal order</th>
                                    <th>Nama Media</th>
                                    <th>Jumlah</th>
                                    <th>Kemasan</th>
                                    <th>Satuan</th>
                                    <th>Peng-order</th>
                                    <th>Bagian</th>
                                    <th>Status Order</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                foreach ($data as $data){ ?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$data->tanggal}}</td>
                                        <td>{{$data->nama_media}}</td>
                                        <td>{{$data->jumlah}}</td>
                                        <td>{{$data->kemasan}}</td>
                                        <td>{{$data->satuan}}</td>
                                        <td>{{$data->nama}}</td>
                                        <td>{{$data->bagian}}</td>
                                        @if($data->status == 0)
                                            <td class="content_center"><a class="form-control" style="background-color:yellow ;width:100px; margin-top:50% text-align:center">PENDING</a></td>
                                        @elseif($data->status == 1)
                                            <td><a class="form-control" style="background-color:green ;width:100px; margin-top:50% text-align:center;color:white">ACC</a></td>
                                        @elseif($data->status == 2)
                                            <td><a class="form-control" style="background-color:red ;width:100px; margin-top:50% text-align:center;color:white">DITOLAK</a></td>
                                        @endif
                                        <td style="text-align:center" width="100px">
                                            <a href=""class="form-control" data-toggle="modal" data-target="#accModal{{$data->id}}" style="background-color:green ;width:100px; margin-top:10% text-align:center;color:white">ACC</a>
                                            <a href=""class="form-control" data-toggle="modal" data-target="#tolakModal{{$data->id}}" style="background-color:RED ;width:100px; margin-top:10% text-align:center;color:white">TOLAK</a>
                                        </td>
                                    </tr>

                                    <!-- Modal ACC -->
                                    <div id="accModal{{$data->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="card-header">
                                                    <h5 class="title">ACC Order Media</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form action="adminmedia/acc/{{$data->id}}" method="get">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12 pr-8">
                                                                <div class="form-group">
                                                                    <label>Apakah anda yakin akan Melakukan ACC pada data Order {{$data->nama_media}} yang dilakukan oleh bagian {{$data->bagian}}</label>
                                                                </div>
                                                            </div>
                                                        </div>                  
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-6 pr-8">
                                                                <div class="form-group">
                                                                    <button style="font-weight:bold;" type="submit" class="btn btn-primary btn-block" name="input" id="input">Ya, ACC Orderan</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 pr-8">
                                                                <div class="form-group">
                                                                    <a style="font-weight:bold; text-align:center" type="Submit" data-dismiss="modal" class="btn btn-primary btn-block">Batal</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal ACC-->   


                                    <!-- Modal Tolak -->
                                    <div id="tolakModal{{$data->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="card-header">
                                                    <h5 class="title">Penolakan Order Media</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form action="/adminmedia/tolak/{{$data->id}}" method="get">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12 pr-8">
                                                                <div class="form-group">
                                                                    <label>Apakah anda yakin akan Melakukan Penolakan pada data Order {{$data->nama_media}} yang dilakukan oleh bagian {{$data->bagian}}</label>
                                                                </div>
                                                            </div>
                                                        </div>                  
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-6 pr-8">
                                                                <div class="form-group">
                                                                    <button style="font-weight:bold;" type="submit" class="btn btn-primary btn-block" name="input" id="input">Ya, Tolak Orderan</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 pr-8">
                                                                <div class="form-group">
                                                                    <a style="font-weight:bold; text-align:center" type="Submit" data-dismiss="modal" class="btn btn-primary btn-block">Batal</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal Tolak-->   

                                <?php 
                                $i++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    @endsection