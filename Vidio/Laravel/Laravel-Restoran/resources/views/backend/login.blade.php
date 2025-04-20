<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> admin login resto SMK</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-4">
           <h1 class="text-center">Login admin</h1>
                <form action="{{ url('admin/postlogin') }}" method="post">
                    @csrf
                    
            @if (Session::has('pesan'))
                    <div class="alert">
                        {{ Session::get('pesan') }}
                    </div>
           @endif
               <div>
                        <label class="form-label" for="">Email</label>
            <input class="form-control" value="{{ old('email') }}" type="text" name="email">
                        <span class="text-danger">@error('email')
             {{ $message }}
                        @enderror</span>
                    </div>
                    <div>
                  <label class="form-label" for="">password</label>
                        <input class="form-control" type="password" name="password">
                       <span class="text-danger">@error('password')
                            {{ $message }}
                        @enderror</span>
                    </div>
                    <div>
                        <button class="btn btn-primary mt-2" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>