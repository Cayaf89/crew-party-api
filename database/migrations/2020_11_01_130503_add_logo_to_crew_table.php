<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoToCrewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crew', function (Blueprint $table) {
            $table->string('logo')->default('/storage/images/png-clipart-computer-file-friends-gathering-love-child.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crew', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
}
