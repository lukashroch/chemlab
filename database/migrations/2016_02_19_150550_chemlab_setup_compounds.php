<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChemlabSetupCompounds extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing compounds
        Schema::create('compounds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('internal_id')->unique();
            $table->integer('owner_id')->unsigned()->nullable();
            $table->foreign('owner_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->string('name');
            $table->double('mw')->unsigned();
            $table->double('amount')->unsigned();
            $table->text('description');
            $table->string('inchikey')->index();
            $table->string('inchi');
            $table->string('smiles');
            $table->longText('sdf');

            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->integer('updated_by')->unsigned();
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
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
        Schema::dropIfExists('compounds');
    }

}
