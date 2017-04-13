@extends('laralum::layouts.master')
@section('icon', 'ion-plus-round')
@section('title', __('laralum_advertisements::general.create_advertisement'))
@section('subtitle', __('laralum_advertisements::general.create_subtitle'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_advertisements::general.home')</a></li>
        <li><a href="{{ route('laralum::advertisements.index') }}">@lang('laralum_advertisements::general.advertisement_list')</a></li>
        <li><span href="">@lang('laralum_advertisements::general.create_advertisement')</span></li>
    </ul>
@endsection
@section('content')
    @include('laralum_advertisements::form', [
        'action' => route('laralum::advertisements.store'),
        'button' => __('laralum_advertisements::general.create_advertisement'),
        'title' => __('laralum_advertisements::general.create_advertisement'),
        'cancel' => route('laralum::advertisements.index')
    ])
@endsection
