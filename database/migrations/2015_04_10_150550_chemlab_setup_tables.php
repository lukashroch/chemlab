<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChemlabSetupTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing users
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->string('ip', 60)->default('127.0.0.1');
            $table->text('options');
            $table->integer('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });

        // Create table for storing password reset tokens
        Schema::create('password_resets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at');
        });

        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->unique();
            $table->string('description')->nullable();
            $table->integer('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->unique();
            $table->string('description')->nullable();
            $table->integer('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        // Create tables for chemicals handling
        Schema::create('brands', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('url_product')->default('');
            $table->string('url_sds')->default('');
            $table->string('parse_callback')->default('');
            $table->text('description');
            $table->integer('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('chemicals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->index();
            $table->string('iupac_name')->index()->default('');
            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->string('catalog_id')->index()->default('');
            $table->string('cas')->index()->default('');
            $table->string('chemspider')->default('');
            $table->string('pubchem')->default('');
            $table->double('mw')->unsigned()->default(0);
            $table->string('formula')->default('');
            $table->string('synonym')->default('');
            $table->text('symbol');
            $table->string('signal_word')->default('');
            $table->text('h');
            $table->text('p');
            $table->text('r');
            $table->text('s');
            $table->integer('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('chemical_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('chemical_id')->unsigned();
            $table->foreign('chemical_id')->references('id')->on('chemicals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->double('amount')->unsigned();
            $table->tinyInteger('unit')->unsigned()->default(0);
            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users');
            $table->integer('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('chemical_structures', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('chemical_id')->unsigned();
            $table->primary('chemical_id');
            $table->foreign('chemical_id')->references('id')->on('chemicals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('inchikey')->index()->default('');
            $table->string('inchi')->default('');
            $table->longText('smiles');
            $table->longText('sdf');
            $table->integer('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->index();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('stores');
            $table->string('name')->index();
            $table->string('tree_name')->index()->default('');
            $table->string('abbr_name')->index()->default('');
            $table->smallInteger('temp_min')->default(20);
            $table->smallInteger('temp_max')->default(20);
            $table->text('description');
            $table->integer('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->index();
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');

        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');

        Schema::dropIfExists('brands');
        Schema::dropIfExists('chemicals');
        Schema::dropIfExists('chemical_items');
        Schema::dropIfExists('chemical_structures');
        Schema::dropIfExists('stores');
    }

}
