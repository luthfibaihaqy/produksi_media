<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Form Register</h3>
                </div>
                <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="card-body">
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
                    <div class="form-group">
                        <label for=""><strong>Username</strong></label>
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Password</strong></label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Konfirmasi Password</strong></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Nama Lengkap</strong></label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>NIP</strong></label>
                        <input type="text" name="NIP" class="form-control" placeholder="NIP">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Bagian</strong></label>
                        <select class="form-control" name="bagian" id="bagian">
                        <option value="">== Pilih Bagian ==</option>
                            
                            @foreach($bagian as $bagian => $bag)
                            <option value="{{$bag->id}}">{{$bag->nama_bagian}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    <label for=""><strong>Jabatan</strong></label>
                        <select class="form-control" name="jabatan" id="jabatan">
                        <option value="">== Pilih Jabatan ==</option>
                            <option value="admin media">Admin Media</option>
                            <option value="kepala media">Kepala Media</option>
                            <option value="kepala produksi">Kepala Produksi</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                    <p class="text-center">Sudah punya akun? <a href="{{ route('login') }}">Login</a> sekarang!</p>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>