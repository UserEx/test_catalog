<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ trans('front/site.title') }}</title>
        <meta name="description" content="">    
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        @yield('head')

        {!! HTML::style('css/app.css') !!}
        {{--!! HTML::style('css/bootstrap-treeview.css') --}}

    </head>

  <body>

    <header class="container">
        @yield('header')    
        <div class="row" style="margin-bottom: 30px; ">
            <div class="col-lg-12">
                <hr>
                <h2 class="intro-text text-center"><strong>Catalogue</strong></h2>
                <hr>
            </div>
        </div>
    </header>

    <main class="container">
        @yield('main')
    </main>

    <footer style="margin-top: 60px;">
        @yield('footer')
        <!-- Copyright &copy; Momo  -->
        <p class="text-center"><small>Copyright © 2018 Mukhamatinov Ildar</small></p>
    </footer>
        
    {!! HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js') !!}
	{!! HTML::script('js/app.js') !!}
    @yield('scripts')

  </body>
</html>