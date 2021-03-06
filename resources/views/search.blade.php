@extends('layouts.app')

@section('title', 'Mencari ' . $keyword)


@section('content')
    @if (!blank($answer['AbstractURL']))
        <div class="box">
            @if (!blank($answer['Image']))
                <p class="has-text-centered">
                    <img src="{{ $answer['Image'] }}" style="width: {{ $answer['ImageWidth']}}; height: {{ $answer['ImageHeight'] }}">
                </p>
            @endif
            <strong>{{ $answer['Heading'] }}</strong>
            <p>{{ $answer['AbstractText'] }}</p>
            <p>Source: {{ $answer['AbstractURL'] }}</p>
{{--            <p>{{ $answer['Abstract'] }}</p>--}}
        </div>
    @endif
    @foreach($results as $result)
        <a href="{{ $result['url'] }}" class="box">
            <strong>{{ $result['title'] }}</strong> <br>
            @if (isset($result['breadcumb']))
                {{ $result['breadcumb'] }}
            @endif
            @if (isset($result['text']))
                <p>{{ $result['text'] }}</p>
            @endif
        </a>
    @endforeach

    @if (!blank($answer['RelatedTopics']))
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th colspan="2">Related Search</th>
            </tr>
            </thead>
            <tbody>

            @foreach($answer['RelatedTopics'] as $item)
                @if (!blank(optional($item)->Text))
                <tr>
                    @if (blank(optional(optional($item)->Icon)->URL))
                        <td colspan="2">
                    @else
                        <td>
                            @endif
                            <a href="{{ route('search', ['q' => $item->Text]) }}">
                                <p>{{ $item->Text }}</p>
                            </a>
                        </td>
                    @if (!blank($item->Icon->URL))
                        <td class="has-text-centered">
                            <img src="{{ $item->Icon->URL }}" style="width: 86px" alt=""/>
                        </td>
                    @endif
                </tr>
                @endif
            @endforeach

            </tbody>
        </table>
    @endif
@endsection
