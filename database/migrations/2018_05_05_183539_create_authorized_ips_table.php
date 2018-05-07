<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizedIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorized_ips', function (Blueprint $table) {
            $table->increments('id');
            $table->ipAddress('ip');
            $table->integer('wallet_id');
            $table->bigInteger('expires');
            $table->string('info', 255);
            $table->boolean('authorized')->default(false);
            $table->string('rand_id', 64)->unique();
            $table->unique(['wallet_id', 'ip']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorized_ips');
    }
}
