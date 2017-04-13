<?php

Route::group([
        'middleware' => ['web', 'laralum.base'],
        'prefix'     => 'advertisements',
        'namespace'  => 'Laralum\Advertisements\Controllers',
        'as'         => 'laralum_public::',
    ], function () {
        Route::post('click/{advertisement}', 'AdvertisementController@click')->name('advertisements.click');
    });

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Advertisements\Models\Advertisement',
        ],
        'prefix'    => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Advertisements\Controllers',
        'as'        => 'laralum::',
    ], function () {
        Route::post('advertisements/settings', 'AdvertisementController@updateSettings')->name('advertisements.settings.update');
        Route::get('advertisements/statistics', 'AdvertisementController@statistics')->name('advertisements.statistics');
        Route::get('advertisements/{advertisement}/statistics', 'AdvertisementController@specificStatistics')->name('advertisements.statistics.specific');
        Route::get('advertisements/{advertisement}/delete', 'AdvertisementController@confirmDelete')->name('advertisements.destroy.confirm');
        Route::resource('advertisements', 'AdvertisementController');
    });
