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
                                    <a href="" style="width:150px; text-align:center;" data-toggle="modal" data-target="#insertmodal" type="Submit" class="btn form-control alert-info"> Ganti Bulan </a>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table" id="mytable">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nama Media</th>
                                                <th>Batch</th>
                                                <th>Bulan Order </th>
                                                <th>Total Order</th>
                                                <th>2X Order</th>
                                                <th>Stok</th>
                                                <th>Kurang</th>
                                                <th>Batch</th>
                                                <th>Jumlah Batch</th>
                                                <th>Prod</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $i = 1;
                                            foreach ($data as $data){ ?>
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$data->kode}}</td>
                                                    <td>{{$data->nama_media}}</td>
                                                    <td>{{$data->batch}}</td>
                                                    <td>{{$data->bulan}}</td>
                                                    <td>{{$data->total}}</td>
                                                    <td>{{$data->total * 2}}</td>
                                                    <td>{{$data->stok}}</td>
                                                    <td>{{$data->stok - ($data->total * 2)}}</td>
                                                    <td>{{$data->batch}}</td>
                                                    <td>{{($data->stok - ($data->total * 2)) / $data->batch}}</td>
                                                    <td>{{ceil(abs(($data->stok - ($data->total * 2)) / $data->batch))}}</td>
                                                </tr>
                                            <?php 
                                            $i++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- /.card -->
                </section>
            </div>
        </div>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
    </section>
    <div id="insertmodal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="title">Menampilkan Orderan Berdasarkan Bulan</h5>
                    </div>
                <div class="card-body">
                    <form action="/kepalamedia/orderperbulan" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 pr-8">
                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select class="form-control" style="font-weight:bold;" id="bulan" name="bulan">
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                        </div>                  
                        <br>
                        <div class="row">
                            <div class="col-md-6 pr-8">
                                <div class="form-group">
                                    <button type="submit" name="input" id="input" class="btn btn-primary btn-block">Tampilkan Data</button>
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
    @endsection