<?php

namespace Laralum\Advertisements\Models;

use Illuminate\Database\Eloquent\Model;
use Unicodeveloper\Identify\Facades\IdentityFacade as Identify;

class Advertisement extends Model
{
    public $table = 'laralum_advertisements';
    public $fillable = ['name', 'slug', 'code'];

     /**
      * Returns the advertisment views.
      */
     public function views()
     {
         return $this->hasMany('Laralum\Advertisements\Models\View');
     }

    /**
     * Returns the link unique views.
     */
    public function uniqueViews()
    {
        return $this->views->where('click', 0)->unique('ip');
    }

     /**
      * Returns the advertisment clicks.
      */
     public function clicks()
     {
         return $this->views->where('click', 1);
     }

      /**
       * Returns the advertisment unique clicks.
       */
      public function uniqueClicks()
      {
          return $this->views->where('click', 1)->unique('ip');
      }

    /**
     * Returns the link total unique views number.
     */
    public function totalUniqueViews()
    {
        return count($this->uniqueViews());
    }

    /**
     * Returns the link total views number.
     */
    public function totalViews()
    {
        return count($this->views->where('click', 0));
    }

     /**
      * Returns the advertisment clicks.
      */
     public function totalClicks()
     {
         return $this->views->where('click', 1)->count();
     }

      /**
       * Returns the advertisment clicks.
       */
      public function totalUniqueClicks()
      {
          return $this->views->where('click', 1)->unique('ip')->count();
      }

    /**
     * Returns the link browsers.
     */
    public function usedBrowsers()
    {
        $results = [];
        foreach ($this->views as $view) {
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
        foreach ($this->views as $view) {
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
        $collection = collect($this->views->toArray())->groupBy('language')->map(function ($item, $key) {
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

     /**
      * Adds a view to the advertisment.
      */
     public function addView()
     {
         return View::create([
             'advertisement_id' => $this->id,
             'browser'          => Identify::browser()->getName(),
             'browser_version'  => Identify::browser()->getVersion(),
             'os'               => Identify::os()->getName(),
             'os_version'       => Identify::os()->getVersion(),
             'language'         => Identify::lang()->getLanguage(),
             'ip'               => $this->getIP(),
             'click'            => false,
         ]);
     }

      /**
       * Adds a click to the advertisment.
       */
      public function addClick()
      {
          return View::create([
              'advertisement_id' => $this->id,
              'browser'          => Identify::browser()->getName(),
              'browser_version'  => Identify::browser()->getVersion(),
              'os'               => Identify::os()->getName(),
              'os_version'       => Identify::os()->getVersion(),
              'language'         => Identify::lang()->getLanguage(),
              'ip'               => $this->getIP(),
              'click'            => true,
          ]);
      }

    /**
     * Gets the real client IP.
     */
    public function getIP()
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {   //check ip from cloudflare
          $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}
