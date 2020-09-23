<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChemlabTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create tables for chemicals handling
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('url_product')->nullable();
            $table->string('url_sds')->nullable();
            $table->string('parse_callback')->nullable();
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('stores')
                ->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams')
                ->onUpdate('cascade')->onDelete('set null');
            $table->string('name')->index();
            $table->string('tree_name')->nullable()->index();
            $table->string('abbr_name')->nullable()->index();
            $table->smallInteger('temp_min')->default(20);
            $table->smallInteger('temp_max')->default(20);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('chemicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('iupac')->index()->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')
                ->onUpdate('cascade')->onDelete('no action');
            $table->string('catalog_id')->index()->nullable();
            $table->string('cas')->index()->nullable();
            $table->string('chemspider')->nullable();
            $table->string('pubchem')->nullable();
            $table->double('mw')->unsigned()->nullable();
            $table->string('formula')->nullable();
            $table->string('synonym')->nullable();
            $table->text('description')->nullable();
            $table->text('symbol')->nullable();
            $table->string('signal_word')->nullable();
            $table->text('h')->nullable();
            $table->text('p')->nullable();
            $table->text('r')->nullable();
            $table->text('s')->nullable();
            $table->timestamps();
        });

        Schema::create('chemical_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chemical_id');
            $table->foreign('chemical_id')->references('id')->on('chemicals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->double('amount')->unsigned();
            $table->unsignedTinyInteger('unit')->default(0);
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });

        Schema::create('chemical_structures', function (Blueprint $table) {
            $table->unsignedBigInteger('chemical_id')->primary();
            $table->foreign('chemical_id')->references('id')->on('chemicals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('inchikey')->index()->nullable();
            $table->text('inchi')->nullable();
            $table->longText('smiles')->nullable();
            $table->longText('sdf')->nullable();
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
        Schema::dropIfExists('chemical_structures');
        Schema::dropIfExists('chemical_items');
        Schema::dropIfExists('chemicals');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('brands');
    }
}
