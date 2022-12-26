<!DOCTYPE html>
<html class="h-100" lang="jp">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <title>@yield('title')</title>
    </head>

    <body class="d-flex flex-column h-100">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="container-fluid">
                    <span class="navbar-brand">laraveテストサイト</span>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li class="nav-item">
                                @if(url()->current() ===  route('sendmail'))
                                    <a class="nav-link active" aria-current="page"
                                            href="{{ route('sendmail') }}">
                                        メール送信
                                    </a>
                                @else
                                    <a class="nav-link" href="{{ route('sendmail') }}">
                                        メール送信
                                    </a>
                                @endif
                            </li>
                            <li class="nav-item">
                                @if(url()->current() ===  route('outputdb'))
                                    <a class="nav-link active" aria-current="page"
                                            href="{{ route('outputdb') }}">
                                        DB出力
                                    </a>
                                @else
                                    <a class="nav-link" href="{{ route('outputdb') }}">
                                        DB出力
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main style="padding-top: 60px; height: calc(100% - 60px);">
            @section('main')
                <p>既定のコンテンツ</p>
            @show
        </main>

        <footer class="footer mt-auto py-3 bg-light">
            <div class="container">
                <span class="text-muted">フッター</span>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
