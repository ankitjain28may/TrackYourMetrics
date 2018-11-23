<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFolderInFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_in_folder', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_folder_id');
            $table->unsignedInteger('child_folder_id');
            $table->foreign('parent_folder_id')->references('id')->on('folders')->onDelete('cascade');
            $table->foreign('child_folder_id')->references('id')->on('folders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folder_in_folder');
    }
}
