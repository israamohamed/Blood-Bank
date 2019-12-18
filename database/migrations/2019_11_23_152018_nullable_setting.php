<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function(Blueprint $table) 
		{
            $table->string('play_store_url')                ->nullable()->change();
            $table->string('app_store_url')                 ->nullable()->change();
            $table->mediumText('notification_setting_text') ->nullable()->change();
            $table->text('about_app')                       ->nullable()->change();
            $table->string('phone')                         ->nullable()->change();
            $table->string('email')                         ->nullable()->change();
            $table->string('fb_link')                       ->nullable()->change();
            $table->string('tw_link')                       ->nullable()->change();
            $table->string('youtube_link')                  ->nullable()->change();
            $table->string('insta_link')                    ->nullable()->change();
            $table->string('whats_link')                    ->nullable()->change();
            $table->string('google_link')                   ->nullable()->change();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
