<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('server_id');
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
            $table->string('console_address')->comment('The server console address')->default('127.0.0.1');
            $table->integer('console_port')->comment('The server console port')->default(3443);
            $table->text('admin_name')->comment('Encrypted console admin user name');
            $table->text('admin_password')->comment('Encrypted console admin password');
            $table->string('expansion')->default('Wrath of The Lich King');
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
        Schema::dropIfExists('realms');
    }
}
