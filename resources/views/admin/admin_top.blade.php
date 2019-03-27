<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">

        {{--========================================================--}}
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        {{--========================================================--}}

        <title>Photo Sharing Admin</title>
    {{--この下の2行がvue用の追加文章--}}
        {{--<meta name="csrf-token" content="{{ csrf_token() }}">Authを入れたためか、これではAuthなしのページもエラーになった。--}}
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        {{--送信時に認証用のトークン付与のために追加--}}
        <script>
            Window.Laravel = {csrfToken: "{{ csrf_token() }}"};
        </script>
    </head>
    <body>
    <div id="admin">
        {{--<nav class="navbar navbar-expand-md navbar-light navbar-laravel">--}}
            {{--<div class="container">--}}
                {{--<div class="collapse navbar-collapse" id="navbarSupportedContent">--}}

                    {{--<!-- Left Side Of Navbar -->--}}
                    {{--<ul class="navbar-nav mr-auto">--}}
                        {{--<li>--}}
                            {{--<a class="navbar-brand" href="{{ url('/admin') }}">--}}
                                {{--{{ config('app.name.a_top','Laravel') }}--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}

                    {{--<!-- Right Side Of Navbar -->--}}
                    {{--<ul class="navbar-nav ml-auto">--}}
                        {{--<!-- Authentication Links -->--}}
                        {{--@guest--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>--}}
                            {{--</li>--}}
                        {{--@else--}}
                            {{--<li class="nav-item dropdown">--}}
                                {{--<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
                                    {{--{{ Auth::user()->name }} <span class="caret"></span>--}}
                                {{--</a>--}}

                                {{--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
                                    {{--<a class="dropdown-item text-center" href="{{ route('admin.logout') }}"--}}
                                       {{--onclick="event.preventDefault();--}}
                                                     {{--document.getElementById('logout-form').submit();">--}}
                                        {{--{{ __('ログアウト') }}--}}
                                    {{--</a>--}}

                                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--@endguest--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</nav>--}}
        <div id="admin-top">
            {{--<router-view></router-view>--}}
            {{--<admin-root></admin-root>--}}
            <admin-root token-data="{{ Auth::user()->api_token }}"></admin-root>
        </div>
    </div>
{{--この下の1行がvue用の追加文章。合計3行追加--}}
        <script src=" {{ mix('js/app.js') }} "></script>
    </body>
</html>

<script>
    //blade全体をdropキャンセルしたかったができなかった。とりあえず要素がある場所だけ。
    var fileArea = document.body;
    function dropHandler(e) {
        e.stopPropagation();
        e.preventDefault();
    }
    function dragOverHandler(e) {
        e.preventDefault();
    }
    fileArea.addEventListener('dragover', dragOverHandler);
    fileArea.addEventListener('drop', dropHandler);

    // fileArea.addEventListener('dragover drop', function (e) {//省略できなかった。
    //     e.stopPropagation();
    //     e.preventDefault();
    // });
</script>