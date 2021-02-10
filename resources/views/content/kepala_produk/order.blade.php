@extends('main')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
              <!-- <div class="card-header">

              </div>/.card-header -->
              <div class="card-body">
                            <form action="order/create" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 pr-8">
                                        <div class="form-group">
                                            <label>Media Yang Diorder</label>
                                            <select class="form-control" style="font-weight:bold;" id="media" name="media" required autofocus></select>
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah Order /Liter</label>
                                            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah Order /Liter" required autofocus>
                                        </div>
                                        <small style="color:red">*Satuan yang di gunakan adalah Liter</small>
                                    </div>
                                </div>                  
                                <br>
                                <div class="row">
                                    <div class="col-md-12 pr-8">
                                        <div class="form-group">
                                            <button type="submit" name="input" id="input" class="btn btn-primary btn-block text-uppercase">Order</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </form>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
$('#media').select2({
    width: '100%',
  placeholder: 'Ketikan media yang akan di Order',
  ajax: {
    url: 'order/autocompletemedia',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
      return {
        results:  $.map(data, function (item) {
              return {
                  text: item.nama_media,
                  id: item.id
              }
          })
      };
    },
    cache: true
  }
});
</script>
    @endsection