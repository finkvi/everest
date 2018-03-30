<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="/css/mdb.min.css" rel="stylesheet">

    <!-- Your custom styles (optional) -->
    <link href="/css/style.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

<div class="container login-form">

    <!--Naked Form-->
    <div class="card-block">
  
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}

            <!--Header-->
            <div class="text-xs-center">
                <!--h3><i class="fa fa-coffee"></i>&nbsp; {{ config('app.name') }} @lang('auth.Login'):</h3-->
                <h3><span class="tag blue" style='letter-spacing:1px; font-size:25px;'>EVE<span style='color:#FFB380;'>R</span>EST</span> @lang('auth.Login'):</h3>
                <hr class="mt-2 mb-2">
            </div>

            <!--Body-->
            <div class="md-form input-group">
                <i class="fa fa-user prefix" style='position:absolute; left:0; right:auto;'></i>
                <input type="text" name='login' class="form-control" aria-describedby="basic-addon2" value='{{ old('login') }}' required>
                <label for="form2">@lang('auth.YourLogin')</label>
                <span class="input-group-addon" id="basic-addon2">{{ config('app.domain') }}</span>
            </div>
            @if ($errors->has('login'))
                <p class="text-danger form-error-msg err-input-group">{{ $errors->first('login') }}</p>
            @endif

            <div class="md-form">
                <i class="fa fa-lock prefix"></i>
                <input type="password" name='password' id="form4" class="form-control" required>
                <label for="form4">@lang('auth.YourPassword')</label>
            </div>
            @if ($errors->has('password'))
                <p class="text-danger form-error-msg err-input-group">{{ $errors->first('password') }}</p>
            @endif

            <!--fieldset class="form-group checkbox-input-group">
                <input type="checkbox" name="remember" value='1' id="checkbox1">
                <label for="checkbox1">@lang('auth.RememberMe')</label>
            </fieldset-->


            <div class="text-xs-center">
                <button class="btn btn-info btn-rounded">@lang('auth.Login')</button>
            </div>

        </form>

    </div>

</div>


    <!-- SCRIPTS -->

    <!-- JQuery -->
    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="/js/tether.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/js/mdb.min.js"></script>

</body>
</html>
