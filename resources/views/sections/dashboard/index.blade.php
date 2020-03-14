@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title',  __('wide-store::dashboard.startup_baselinker') . ' // ' .config('app.name') )
@section('meta_description', _p('pages.dashboard.meta_description', 'Check your dashboard with all important metrics and values.'))

@push('head')
    @include('wide-store::integration.favicons')
    @include('wide-store::integration.ga')
@endpush

@section('content')


@endsection
