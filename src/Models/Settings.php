<?php

namespace Laralum\Advertisements\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public $table = 'laralum_advertisements_settings';
    public $fillable = [
        'anti_ad_block', 'anti_ad_block_method', 'content',
    ];
}
