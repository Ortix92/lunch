<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVeggyColumnToNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('names', function (Blueprint $table) {
            $table->integer('veggy')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('names', function (Blueprint $table) {
            if (Schema::hasColumn('names', 'veggy')) {
                $table->dropColumn('veggy');
            }
        });
    }
}
