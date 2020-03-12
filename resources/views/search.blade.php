@extends('layouts.app')

@section('title', 'Mencari ' . $keyword)


@section('content')
    @foreach($results as $result)
        <a href="{{ $result['url'] }}" class="box has-text-centered">
            <strong>{{ $result['title'] }}</strong> <br>
            @if (isset($result['breadcumb']))
                {{ $result['breadcumb'] }}
            @endif
            <p>{{ $result['text'] }}</p>
        </a>
    @endforeach
    <div class="box has-text-centered">
        <h1 class="title">Apa Itu {{ config('app.name') }}?</h1>
        <p>{{ config('app.name') }} adalah sebuah mesin pencari yang tidak melakukan tracking kepada anda, kami bukan seperti mesin pencari lain yang melakukan itu.
            Untuk saat ini baru bisa mencari website saja & baru bisa menampilkan 10 hasil teratas.</p>
    </div>
@endsection
