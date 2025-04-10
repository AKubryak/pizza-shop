@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <div id="app">
        <cart></cart>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
