@extends('laralum::layouts.master')
@section('icon', 'ion-eye')
@section('title', 'Advertisement Preview')
@section('subtitle', __('laralum_advertisements::general.show_subtitle', ['id' => $ad->id, 'created' => $ad->created_at->diffForHumans(), 'edited' => $ad->updated_at->diffForHumans()]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_advertisements::general.home')</a></li>
        <li><a href="{{ route('laralum::advertisements.index') }}">@lang('laralum_advertisements::general.advertisement_list')</a></li>
        <li><span href="">@lang('laralum_advertisements::general.show')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid class="uk-child-width-1-1">
            <div>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.advertisement_preview', ['id' => $ad->id])
                    </div>
                    <div class="uk-card-body">
                        <center>
                            {!! Laralum\Advertisements\Show::ad($ad->slug) !!}
                        </center>
                    </div>
            </div>
        </div>
    </div>
@endsection
