{!!
    ConsoleTVs\Charts\Facades\Charts::multiDatabase('line', 'highcharts')
            ->title(__('laralum_advertisements::general.ads_clicks_7_days'))->dimensions(0, 400)->responsive(false)
            ->dataset(__('laralum_advertisements::general.total_clicks'), \Laralum\Advertisements\Models\View::where('click', 1)->get())
            ->dataset(__('laralum_advertisements::general.total_u_clicks'), \Laralum\Advertisements\Models\View::where('click', 1)->get()->unique('ip'))
            ->lastByDay(7, true)->elementLabel('Views')->render();
!!}
