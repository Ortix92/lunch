<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('tasks', 'names'); // I did not name it users due to potential expansion of the system
        Schema::table('names', function (Blueprint $table) {
            $table->boolean('persist')->default(0); // People who always eat lunch
        });
        Schema::create('lists', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->boolean('closed')->nullable();
            $table->timestamp('opened_on');
            $table->timestamp('closed_on')->nullable();
        });
        Schema::create('list_name', function (Blueprint $table) {
            $table->integer('list_id');
            $table->integer('name_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lunch_name');
        Schema::dropIfExists('lunches');

        if (Schema::hasColumn('names', 'persist')) {
            Schema::table('names', function (Blueprint $table) {
                $table->dropColumn('persist');
            });

        }
        Schema::rename('names', 'tasks');
    }
}
