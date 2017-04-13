{!!
    ConsoleTVs\Charts\Facades\Charts::multiDatabase('line', 'highcharts')
            ->title('Advertisements views on the last 7 days')->dimensions(0, 400)->responsive(false)
            ->dataset('Total Views', \Laralum\Advertisements\Models\View::where('click', 0)->get())
            ->dataset('Unique Views', \Laralum\Advertisements\Models\View::where('click', 0)->get()->unique('ip'))
            ->lastByDay(7, true)->elementLabel('Views')->render();
!!}
