<?php

namespace Laralum\Advertisements\Controllers;

use Laralum\Advertisements\Models\Advertisement;
use Laralum\Advertisements\Models\View;
use Laralum\Advertisements\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laralum_advertisements::index', [
            'settings' => Settings::first(),
            'ads' => Advertisement::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Advertisement::class);

        return view('laralum_advertisements::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Advertisement::class);

        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:laralum_advertisements',
            'code' => 'required'
        ]);

        $ad = Advertisement::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('laralum::advertisements.index')->with('success', __('laralum_advertisements::general.ad_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Laralum\Advertisements\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        $this->authorize('view', Advertisement::class);

        return view('laralum_advertisements::show', ['ad' => $advertisement]);
    }

    /**
     * Display the advertisements statistics.
     *
     * @param  \Laralum\Advertisements\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        $this->authorize('statistics', Advertisement::class);

        $statistics = [
            'allViews' => View::all(),
            'allUniqueViews' => View::where('click', 0)->get()->unique('ip')->merge(View::where('click', 1)->get()->unique('ip')),
            'views' => View::where('click', 0)->get(),
            'uniqueViews' => View::where('click', 0)->get()->unique('ip'),
            'totalViews' => View::where('click', 0)->get()->count(),
            'totalUniqueViews' => View::where('click', 0)->get()->unique('ip')->count(),
            'clicks' => View::where('click', 1)->get(),
            'uniqueClicks' => View::where('click', 1)->get()->unique('ip'),
            'totalClicks' => View::where('click', 1)->get()->count(),
            'totalUniqueClicks' => View::where('click', 1)->get()->unique('ip')->count(),
            'mostUsedBrowser' => $this->mostUsedBrowser(),
            'mostUsedOs' => $this->mostUsedOs(),
            'mostUsedLanguage' => $this->mostUsedLanguage(true),
        ];

        return view('laralum_advertisements::statistics', [
            'statistics' => $statistics,
            'title' => __('laralum_advertisements::general.ads_statistics'),
            'subtitle' => __('laralum_advertisements::general.ads_statistics_desc'),
        ]);
    }

    /**
     * Display the specified advertisement statistics.
     *
     * @param  \Laralum\Advertisements\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function specificStatistics(Advertisement $advertisement)
    {
        $this->authorize('specific_statistics', Advertisement::class);

        $statistics = [
            'allViews' => $advertisement->views,
            'allUniqueViews' => $advertisement->views->unique('ip'),
            'views' => $advertisement->views->where('click', 0),
            'uniqueViews' => $advertisement->uniqueViews(),
            'totalViews' => $advertisement->totalViews(),
            'totalUniqueViews' => $advertisement->totalUniqueViews(),
            'clicks' => $advertisement->clicks(),
            'uniqueClicks' => $advertisement->uniqueClicks(),
            'totalClicks' => $advertisement->totalClicks(),
            'totalUniqueClicks' => $advertisement->totalUniqueClicks(),
            'mostUsedBrowser' => $advertisement->mostUsedBrowser(),
            'mostUsedOs' => $advertisement->mostUsedOs(),
            'mostUsedLanguage' => $advertisement->mostUsedLanguage(true),
        ];

        return view('laralum_advertisements::statistics', [
            'statistics' => $statistics,
            'title' => __('laralum_advertisements::general.ad_statistics'),
            'subtitle' => __('laralum_advertisements::general.ad_statistics_desc', [
                'id' => $advertisement->id,
                'created' => $advertisement->created_at->diffForHumans(),
                'edited' => $advertisement->updated_at->diffForHumans(),
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Laralum\Advertisements\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        $this->authorize('update', Advertisement::class);

        return view('laralum_advertisements::edit', ['ad' => $advertisement]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Advertisements\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $this->authorize('update', Advertisement::class);

        $this->validate($request, [
            'name' => 'required',
            'slug' => "required|unique:laralum_advertisements,id,$advertisement->id,id",
            'code' => 'required',
        ]);

        $advertisement->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('laralum::advertisements.index')->with('success', __('laralum_advertisements::general.ad_updated'));
    }

    public function updateSettings(Request $request)
    {
        $this->authorize('update', Settings::class);

        $this->validate($request, [
            'anti_ad_block_method' => 'required_with:anti_ad_block',
            'content' => 'required_with:anti_ad_block',
        ]);

        Settings::first()->update([
            'anti_ad_block' => $request->input('anti_ad_block') ? true : false,
            'anti_ad_block_method' => $request->input('anti_ad_block_method'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('laralum::settings.index', ['p' => 'Advertisements'])->with('success', __('laralum_advertisements::general.ad_settings_updated'));
    }

    /**
     * Adds a click to the specified advertisement.
     *
     * @param  \Laralum\Advertisements\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function click(Advertisement $advertisement)
    {
        $advertisement->addClick();

        return ['accepted' => false];
    }

    /**
     * Displays a view to confirm delete.
     *
     * @param  \Laralum\Advertisements\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Advertisement $advertisement)
    {
        $this->authorize('delete', Advertisement::class);

        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'action' => route('laralum::advertisements.destroy', ['ad' => $advertisement]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Laralum\Advertisements\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $advertisement)
    {
        $this->authorize('delete', Advertisement::class);

        $advertisement->delete();

        return redirect()->route('laralum::advertisements.index')->with('success', __('laralum_advertisements::general.ad_deleted'));
    }

    /**
     * Returns the link browsers.
     */
    public function usedBrowsers()
    {
        $results = [];
        foreach (View::where('click', 0)->get() as $view) {
            array_key_exists($view->browser, $results) ? $results[$view->browser]++ : $results[$view->browser] = 1;
        }
        return $results;
    }
    /**
     * Returns the link most used browser.
     */
    public function mostUsedBrowser()
    {
        $max = 0;
        $max_browser = null;
        foreach ($this->usedBrowsers() as $browser => $count) {
            if ($count >= $max) {
                $max = $count;
                $max_browser = $browser;
            }
        }
        return $max_browser;
    }

    /**
     * Returns the link OSs (Operating Systems).
     */
    public function usedOSs()
    {
        $results = [];
        foreach (View::where('click', 0)->get() as $view) {
            array_key_exists($view->os, $results) ? $results[$view->os]++ : $results[$view->os] = 1;
        }
        return $results;
    }
    /**
     * Returns the link most used OS (Operating System).
     */
    public function mostUsedOS()
    {
        $max = 0;
        $max_os = null;
        foreach ($this->usedOSs() as $os => $count) {
            if ($count >= $max) {
                $max = $count;
                $max_os = $os;
            }
        }
        return $max_os;
    }
    /**
     * Returns the the used languages.
     *
     * @param bool $fancy
     */
    public function usedLanguages($fancy = false)
    {
        $collection = collect(View::where('click', 0)->get()->toArray())->groupBy('language')->map(function ($item, $key) {
            return count($item);
        });
        if ($fancy) {
            $collection = $collection->groupBy(function ($item, $key) {
                $countries = json_decode(file_get_contents(__DIR__.'/../countries.json'), true);
                foreach ($countries as $country) {
                    if ($country['code'] == $key) {
                        return explode(' ', str_replace(';', '', $country['name']))[0];
                    }
                }
                return $key;
            })->map(function ($item, $key) {
                return count($item);
            });
        }
        return $collection->toArray();
    }
    /**
     * Returns the link most used OS (Operating System).
     *
     * @param bool $fancy
     */
    public function mostUsedLanguage($fancy = false)
    {
        $max = collect($languages = $this->usedLanguages())->max();
        foreach ($languages as $lang => $views) {
            if ($views == $max) {
                if ($fancy) {
                    $countries = json_decode(file_get_contents(__DIR__.'/../countries.json'), true);
                    foreach ($countries as $country) {
                        if ($country['code'] == $lang) {
                            return explode(' ', str_replace(';', '', $country['name']))[0];
                        }
                    }
                }
                return $lang;
            }
        }
    }
}
