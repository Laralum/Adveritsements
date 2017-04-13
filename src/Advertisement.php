<?php

namespace Laralum\Advertisements;

use Laralum\Advertisements\Models\Advertisement as Ad;
use Laralum\Advertisements\Models\Settings;

class Advertisement
{
    /**
     * Show the advertisement and adds a view.
     *
     * @param string $slug
     */
    public static function ad($slug)
    {
        $ad = Ad::where('slug', $slug)->first();

        if ($ad) {
            $ad->addView();

            return "<div id='$ad->id' class='laralum-advertisement'>".$ad->code.'</div>';
        } else {
            return '<center><p>No advertisement found</p></center>';
        }
    }

    /**
     * Show the javascript logic.
     *
     * @param string $method
     */
    public static function scripts($method = null)
    {
        if (!$method) {
            $method = Settings::first()->anti_ad_block_method;
        }

        return $method ? view('laralum_advertisements::scripts.blockers.'.$method) : '';
    }
}
