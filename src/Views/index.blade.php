@extends('laralum::layouts.master')
@section('icon', 'ion-social-usd')
@section('title', __('laralum_advertisements::general.advertisement_list'))
@section('subtitle', __('laralum_advertisements::general.subtitle'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_advertisements::general.home')</a></li>
        <li><span href="">@lang('laralum_advertisements::general.advertisement_list')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid class="uk-child-width-1-1">
            <div>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.anti_adblock_status')
                    </div>
                    <div class="uk-card-body">
                        @if($settings->anti_ad_block)
                            <div class="uk-alert-primary" uk-alert>
                                <p>
                                    @lang('laralum_advertisements::general.anti_adblock_on', ['method' => $settings->anti_ad_block_method])
                                </p>
                            </div>
                        @else
                            <div class="uk-alert-warning" uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <p>
                                    @lang('laralum_advertisements::general.anti_adblock_off')
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.advertisement_list')
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-overflow-auto">
                            <table class="uk-table uk-table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('laralum_advertisements::general.name')</th>
                                        <th>@lang('laralum_advertisements::general.slug')</th>
                                        <th>@lang('laralum_advertisements::general.views')</th>
                                        <th>@lang('laralum_advertisements::general.unique_views')</th>
                                        <th>@lang('laralum_advertisements::general.clicks')</th>
                                        <th>@lang('laralum_advertisements::general.unique_clicks')</th>
                                        <th>@lang('laralum_advertisements::general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ads as $ad)
                                        <tr>
                                            <td>{{ $ad->id }}</td>
                                            <td>{{ $ad->name }}</td>
                                            <td>{{ $ad->slug }}</td>
                                            <td>{{ $ad->totalViews() }}</td>
                                            <td>{{ $ad->totalUniqueViews() }}</td>
                                            <td>{{ $ad->totalClicks() }}</td>
                                            <td>{{ $ad->totalUniqueClicks() }}</td>
                                            <td class="uk-table-shrink">
                                                <div class="uk-button-group">
                                                    <a href="{{ route('laralum::advertisements.show', ['id' => $ad->id]) }}" class="uk-button uk-button-small uk-button-default">
                                                        @lang('laralum_advertisements::general.show')
                                                    </a>
                                                    <a href="{{ route('laralum::advertisements.statistics.specific', ['id' => $ad->id]) }}" class="uk-button uk-button-small uk-button-default">
                                                        @lang('laralum_advertisements::general.statistics')
                                                    </a>
                                                    <a href="{{ route('laralum::advertisements.edit', ['id' => $ad->id]) }}" class="uk-button uk-button-small uk-button-default">
                                                        @lang('laralum_advertisements::general.edit')
                                                    </a>
                                                    <a href="{{ route('laralum::advertisements.destroy.confirm', ['id' => $ad->id]) }}" class="uk-button uk-button-small uk-button-danger">
                                                        @lang('laralum_advertisements::general.delete')
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
