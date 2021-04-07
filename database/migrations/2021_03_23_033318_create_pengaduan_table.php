<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->increments('id_pengaduan');
            $table->integer('id_masyarakat')->unsigned();
            $table->date('tgl_pengaduan');
            $table->text('isi_laporan');
            $table->string('foto')->nullable();
            $table->enum('status', ['0', 'proses', 'selesai']);
            $table->timestamps();

            // relationship with masyarakat table
            $table->foreign('id_masyarakat')
                  ->references('id_masyarakat')
                  ->on('masyarakat')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
}
