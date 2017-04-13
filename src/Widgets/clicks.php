<?php

return ConsoleTVs\Charts\Facades\Charts::multiDatabase('line', 'highcharts')
        ->title('Advertisements clicks on the last 7 days')->dimensions(0, 300)->responsive(false)
        ->dataset('Total Clicks', Laralum\Advertisements\Models\View::where('click', 1)->get())
        ->dataset('Unique Clicks', Laralum\Advertisements\Models\View::where('click', 1)->get()->unique('ip'))
        ->lastByDay(7, true)->elementLabel('Views')->render();
