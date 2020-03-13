<!DOCTYPE html>
<html lang="ID">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div id="app">
    <div class="columns">
        <div class="column is-6 is-offset-3">
            <div class="box has-text-centered">
                <div class="field">
                    <h1 class="title"><a href="/" title="{{ config('app.name') }}">{{ config('app.name') }}</a></h1>
                    <h2 class="subtitle">{{ config('app.description') }}</h2>
                </div>
            </div>
            <div class="box">
                <form action="{{ route('search') }}" method="get">
                <div class="columns">
                        <div class="column is-9">
                            <div class="field">
                                <div class="control">
                                    <input name="q" class="input is-primary" type="text" placeholder="Masukan Kata Kunci Pencarian" value="{{ request()->query('q') }}">
                                </div>
                            </div>
                        </div>
                        <div class="column is-3">
                            <button type="submit" class="button is-primary is-fullwidth">Search</button>
                        </div>
                </div>
                </form>
            </div>
            @yield('content')
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container has-text-centered">
        <p>
            &copy; 2020 - {{ config('app.name') }}
        </p>
        <p>
            Dibuat dengan <span class="has-text-danger has-text-weight-bold"><i class="fas fa-heart"></i></span>
            di Indonesia (Lamongan & Surabaya)<br> Kerja sama hubungi rudi@dibumi.com
        </p>
        <hr>
        <p>
            Informasi Sumber Data: Data yang tampil pada hasil penelusuran berasal dari robot crawling kami + mesin pencari.
        </p>
    </div>
</footer>
{{--<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>--}}

</body>
</html>
