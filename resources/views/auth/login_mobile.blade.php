<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    @laravelPWA
</head>

<body>
    <div id="loginContainer">
        <div class="login-form">

            <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="text-center padding-top-100px">
                    @if ($pengaturan && $pengaturan->logo)
                        <img class="mx-auto d-block margin-bottom-25px" width="200px" src="{{ asset('storage/' . $pengaturan->logo) }}">
                    @else
                        <img class="mx-auto d-block margin-bottom-25px" width="200px" src="{{ asset('assets/css/sipren.png') }}">
                    @endif
                </div>

                <!-- <h1 class="text-center light-green-color margin-bottom-25px">NEAT</h1> -->
                <div class="form-group">
                    <x-alert-error :messages="$errors->get('id_user')" class="mt-2" />
                </div>

                <div class="form-group ">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="id_user" name="id_user" placeholder="Enter your email or username" autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="*********"">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">
                        <a href="#" class="light-green-color">Sign In</a>
                    </button>
                </div>

                <div class="clearfix">
                    <label class="pull-left checkbox-inline white-color"><input type="checkbox"> Remember me</label>
                    <a href="#" class="pull-right text-warning" style="color: rgb(252, 223, 2)">Forgot Password?</a>
                </div>

            </form>

        </div>

    </div>



    <!-- jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var domain = window.location.hostname;
            var manifestLink = document.querySelector('link[rel="manifest"]');

            // alert(domain);
            // Tentukan file manifest berdasarkan domain
            if (domain === 'kabid.siprenpas.my.id') {

                manifestLink.setAttribute("href", "https://kabid.siprenpas.my.id/manifest2.json");
                // alert(manifestLink.getAttribute('href'));
            }
        });
    </script>
</body>

</html>
