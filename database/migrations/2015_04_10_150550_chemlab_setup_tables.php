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
        // Create table for storing roles
        Schema::create('teams', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for storing users
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('ip')->default('127.0.0.1');
            $table->text('settings');

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
        });

        // Create table for associating teams to users (Many To Many Polymorphic)
        Schema::create('team_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('user_id');

            $table->primary(['team_id', 'user_id']);
        });

        // Create table for storing password reset tokens
        Schema::create('password_resets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');

            $table->timestamps();
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');

            $table->timestamps();
        });

        // Create table for associating roles to users and teams (Many To Many Polymorphic)
        Schema::create('role_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');
            $table->string('user_type');
            $table->unsignedInteger('team_id')->nullable();

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['user_id', 'role_id', 'user_type', 'team_id']);
        });

        // Create table for associating permissions to users (Many To Many Polymorphic)
        Schema::create('permission_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('user_id');
            $table->string('user_type');
            $table->unsignedInteger('team_id')->nullable();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['user_id', 'permission_id', 'user_type', 'team_id']);
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

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
            $table->string('url_product')->nullable();
            $table->string('url_sds')->nullable();
            $table->string('parse_callback')->nullable();
            $table->text('description');

            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('stores')
                ->onUpdate('cascade')->onDelete('no action');
            $table->string('name')->index();
            $table->unsignedInteger('team_id')->nullable();
            $table->string('tree_name')->nullable()->index();
            $table->string('abbr_name')->nullable()->index();
            $table->smallInteger('temp_min')->default(20);
            $table->smallInteger('temp_max')->default(20);
            $table->text('description')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });

        Schema::create('chemicals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->index();
            $table->string('iupac_name')->index()->nullable();
            $table->unsignedInteger('brand_id')->nullable();
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

            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });

        Schema::create('chemical_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('chemical_id');
            $table->foreign('chemical_id')->references('id')->on('chemicals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->double('amount')->unsigned();
            $table->unsignedTinyInteger('unit')->default(0);
            $table->unsignedInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');

            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });

        Schema::create('chemical_structures', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('chemical_id');
            $table->primary('chemical_id');
            $table->foreign('chemical_id')->references('id')->on('chemicals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('inchikey')->index()->nullable();
            $table->string('inchi')->nullable();
            $table->longText('smiles')->nullable();
            $table->longText('sdf')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });

        Schema::create('nmrs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('filename')->index();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');

            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('password_resets');

        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('team_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('users');

        Schema::dropIfExists('brands');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('chemical_items');
        Schema::dropIfExists('chemical_structures');
        Schema::dropIfExists('chemicals');
        Schema::dropIfExists('nmrs');
    }
}
