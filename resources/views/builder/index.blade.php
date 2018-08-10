@extends('layouts.app')

@section('head-injection')
    @parent
    <script>
        var API_URL = {!! json_encode(url('/api')) !!}
    </script>
@endsection

@section('content')
    <div id="app">
        <builder>
        </builder>
    </div>
@endsection
