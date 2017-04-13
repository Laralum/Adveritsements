@extends('laralum::layouts.master')
@section('icon', 'ion-stats-bars')
@section('title', $title)
@section('subtitle', $subtitle)
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_advertisements::general.home')</a></li>
        <li><a href="{{ route('laralum::advertisements.index') }}">@lang('laralum_advertisements::general.advertisement_list')</a></li>
        <li><span href="">@lang('laralum_advertisements::general.statistics')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>

            {{-- Basic Statistics --}}

            <div class="uk-width-1-1@m uk-width-1-2@l uk-width-1-4@xl">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.total_views')</span><br />
                    <span class="statistics-number">
                        {{ $statistics['totalViews'] }}
                    </span>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-2@l uk-width-1-4@xl">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.total_u_views')</span><br />
                    <span class="statistics-number">
                        {{ $statistics['totalUniqueViews'] }}
                    </span>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-2@l uk-width-1-4@xl">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.total_clicks')</span><br />
                    <span class="statistics-number">
                        {{ $statistics['totalClicks'] }}
                    </span>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-2@l uk-width-1-4@xl">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.total_u_clicks')</span><br />
                    <span class="statistics-number">
                        {{ $statistics['totalUniqueClicks'] }}
                    </span>
                </div>
            </div>

            {{-- Browser, Os, Language --}}

            <div class="uk-width-1-1@m uk-width-1-3@l">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.mu_browser')</span><br />
                    <span class="statistics-number">
                        {{ $statistics['mostUsedBrowser'] }}
                    </span>
                    <hr />
                    {!!
                        ConsoleTVs\Charts\Facades\Charts::database($statistics['views'], 'pie', 'highcharts')
                            ->title(' ')->dimensions(0, 250)->responsive(false)
                            ->groupBy('browser')->render()
                    !!}
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-3@l">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.mu_os')</span><br />
                    <span class="statistics-number">
                        {{ $statistics['mostUsedOs'] }}
                    </span>
                    <hr />
                    {!!
                        ConsoleTVs\Charts\Facades\Charts::database($statistics['views'], 'pie', 'highcharts')
                            ->title(' ')->dimensions(0, 250)->responsive(false)
                            ->groupBy('os')->render()
                    !!}
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-3@l">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.mu_language')</span><br />
                    <span class="statistics-number">
                        {{ $statistics['mostUsedLanguage'] }}
                    </span>
                    <hr />
                    {!!
                        ConsoleTVs\Charts\Facades\Charts::database($statistics['views'], 'pie', 'highcharts')
                            ->title(' ')->dimensions(0, 250)->responsive(false)
                            ->groupBy('language')->render()
                    !!}
                </div>
            </div>

            {{-- Advertisements Views --}}

            <div class="uk-width-1-1">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.ads_views_7_days')
                    </div>
                    <div class="uk-card-body">
                        {!!
                            ConsoleTVs\Charts\Facades\Charts::multiDatabase('line', 'highcharts')
                            ->title(' ')->dimensions(0, 400)->responsive(false)
                            ->dataset('Total Views', $statistics['views'])
                            ->dataset('Unique Views', $statistics['uniqueViews'])
                            ->lastByDay(7, true)->elementLabel('Views')->render();
                        !!}
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-2@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.ads_views_4_months')
                    </div>
                    <div class="uk-card-body">
                        {!!
                            ConsoleTVs\Charts\Facades\Charts::multiDatabase('bar', 'highcharts')
                            ->title(' ')->dimensions(0, 400)->responsive(false)
                            ->dataset('Total Views', $statistics['views'])
                            ->dataset('Unique Views', $statistics['uniqueViews'])
                            ->lastByMonth(4, true)->elementLabel('Views')->render();
                        !!}
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-2@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.ads_views_4_years')
                    </div>
                    <div class="uk-card-body">
                        {!!
                            ConsoleTVs\Charts\Facades\Charts::multiDatabase('bar', 'highcharts')
                            ->title(' ')->dimensions(0, 400)->responsive(false)
                            ->dataset('Total Views', $statistics['views'])
                            ->dataset('Unique Views', $statistics['uniqueViews'])
                            ->lastByYear(4)->elementLabel('Views')->render();
                        !!}
                    </div>
                </div>
            </div>

            {{-- Advertisements Clicks --}}

            <div class="uk-width-1-1">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.ads_clicks_7_days')
                    </div>
                    <div class="uk-card-body">
                        {!!
                            ConsoleTVs\Charts\Facades\Charts::multiDatabase('line', 'highcharts')
                            ->title(' ')->dimensions(0, 400)->responsive(false)
                            ->dataset('Total Clicks', $statistics['clicks'])
                            ->dataset('Unique Clicks', $statistics['uniqueClicks'])
                            ->lastByDay(7, true)->elementLabel('Views')->render();
                        !!}
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-2@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.ads_clicks_4_months')
                    </div>
                    <div class="uk-card-body">
                        {!!
                            ConsoleTVs\Charts\Facades\Charts::multiDatabase('bar', 'highcharts')
                            ->title(' ')->dimensions(0, 400)->responsive(false)
                            ->dataset('Total Clicks', $statistics['clicks'])
                            ->dataset('Unique Clicks', $statistics['uniqueClicks'])
                            ->lastByMonth(4, true)->elementLabel('Views')->render();
                        !!}
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-2@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_advertisements::general.ads_clicks_4_years')
                    </div>
                    <div class="uk-card-body">
                        {!!
                            ConsoleTVs\Charts\Facades\Charts::multiDatabase('bar', 'highcharts')
                            ->title(' ')->dimensions(0, 400)->responsive(false)
                            ->dataset('Total Clicks', $statistics['clicks'])
                            ->dataset('Unique Clicks', $statistics['uniqueClicks'])
                            ->lastByYear(4)->elementLabel('Views')->render();
                        !!}
                    </div>
                </div>
            </div>

            {{-- Click Rates --}}

            <div class="uk-width-1-1@m uk-width-1-2@l">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.ads_click_rate')</span><br />
                    <span class="statistics-number">
                        {{ ($statistics['totalClicks'] == 0) ? 0 : bcdiv($statistics['totalViews'], $statistics['totalClicks'], 2) }}
                    </span>
                    <hr />
                    {!!
                        ConsoleTVs\Charts\Facades\Charts::database($statistics['allViews'], 'pie', 'highcharts')
                        ->title(' ')->dimensions(0, 400)->responsive(false)
                        ->groupBy('click', null, ['0' => 'Views', '1' => 'Clicks'])->elementLabel('Views')->render();
                    !!}
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-1-2@l">
                <div class="uk-card uk-card-default uk-card-body">
                    <span class="statistics-text">@lang('laralum_advertisements::general.ads_u_click_rate')</span><br />
                    <span class="statistics-number">
                        {{ ($statistics['totalUniqueClicks'] == 0) ? 0 : bcdiv($statistics['totalUniqueViews'], $statistics['totalUniqueClicks'], 2) }}
                    </span>
                    <hr />
                    {!!
                        ConsoleTVs\Charts\Facades\Charts::database($statistics['allUniqueViews'], 'pie', 'highcharts')
                        ->title(' ')->dimensions(0, 400)->responsive(false)
                        ->groupBy('click', null, ['0' => 'Views', '1' => 'Clicks'])->elementLabel('Views')->render();
                    !!}
                </div>
            </div>

        </div>
    </div>
@endsection
