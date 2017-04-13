<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laralum\Advertisements\Models\Settings;

class CreateAdvertisementsSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralum_advertisements_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('anti_ad_block');
            $table->string('anti_ad_block_method')->nullable();
            $table->string('content')->nullable();
            $table->timestamps();
        });

        Settings::create([
            'anti_ad_block' => true,
            'anti_ad_block_method' => 'alert',
            'content' => "Please disable your ad blocker",
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laralum_advertisements_settings');
    }
}
