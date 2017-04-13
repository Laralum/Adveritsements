@extends('laralum::layouts.master')
@section('icon', 'ion-edit')
@section('title', __('laralum_advertisements::general.edit_advertisement'))
@section('subtitle', __('laralum_advertisements::general.edit_subtitle', ['id' => $ad->id, 'created' => $ad->created_at->diffForHumans(), 'edited' => $ad->updated_at->diffForHumans()]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_advertisements::general.home')</a></li>
        <li><a href="{{ route('laralum::advertisements.index') }}">@lang('laralum_advertisements::general.advertisement_list')</a></li>
        <li><span href="">@lang('laralum_advertisements::general.edit_advertisement')</span></li>
    </ul>
@endsection
@section('content')
    @include('laralum_advertisements::form', [
        'action' => route('laralum::advertisements.update', ['ad' => $ad]),
        'button' => __('laralum_advertisements::general.edit_advertisement'),
        'method' => 'PATCH',
        'ad' => $ad,
        'title' => __('laralum_advertisements::general.edit_advertisement_id', ['id' => $ad->id]),
        'cancel' => route('laralum::advertisements.index')
    ])
@endsection
