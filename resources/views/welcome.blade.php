@extends('layouts.app')

@section('title', 'Mesin Pencari')


@section('content')
    <div class="box has-text-centered">
        <h1 class="title">Apa Itu {{ config('app.name') }}?</h1>
        <p>{{ config('app.name') }} adalah sebuah mesin pencari yang tidak melakukan tracking kepada anda, kami tidak seperti mesin pencari lain yang melakukan itu.
            Untuk saat ini baru bisa mencari website saja & baru bisa menampilkan 10 hasil teratas.</p>
    </div>
@endsection
