<?php

namespace Laralum\Advertisements\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public $table = 'laralum_advertisements_views';
    public $fillable = [
        'advertisement_id', 'browser', 'browser_version',
        'os', 'os_version', 'language', 'ip', 'click',
    ];

    /**
     * Display the language in a fancy way.
     */
    public function languageFancy()
    {
        $countries = json_decode(file_get_contents(__DIR__.'/../countries.json'), true);
        foreach ($countries as $country) {
            if ($country['code'] == $this->language) {
                return explode(' ', str_replace(';', '', $country['name']))[0];
            }
        }

        return $this->language;
    }
}
