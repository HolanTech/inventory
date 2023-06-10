<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id_member');
            $table->string('kode_member')->unique();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('email')->unique();
            $table->tinyInteger('diskon');
            $table->enum('tipe_diskon', ['persentase', 'fix diskon'])->default('persentase');
            $table->string('image')->nullable();
            $table->string('telepon');
            $table->softDeletes();
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
        Schema::dropIfExists('member');
    }
}
