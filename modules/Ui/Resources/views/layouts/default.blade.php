@extends('ui::layouts.master')

@section('body')
    <livewire:toasts />

    @include('ui::partials.side-right')
    @include('ui::partials.header')

    @yield('content')

    @include('ui::partials.footer')
@endsection