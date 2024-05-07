<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('rt');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('periode_awal');
            $table->string('periode_akhir');
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
        Schema::dropIfExists('rt');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_kks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kepala_keluarga');
            $table->string('image');
            $table->string('no_kk', 16);
            $table->unsignedBigInteger('rt_id');
            $table->foreign('rt_id')->references('id')->on('rt')->onDelete('cascade'); // Merujuk ke tabel rt
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status_ekonomi',['Mampu','Tidak Mampu']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kks');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('nik')->unique();
            $table->unsignedBigInteger('rt_id');
            $table->foreign('rt_id')->references('id')->on('rt')->onDelete('cascade');
            $table->unsignedBigInteger('data_kks_id');
            $table->foreign('data_kks_id')->references('id')->on('data_kks')->onDelete('cascade');
            $table->enum('gender',['Perempuan','Laki-laki']);
            $table->string('usia');
            $table->string('tmp_lahir');
            $table->date('tgl_lahir');
            $table->enum('agama',['Islam','Katolik','Protestan','Konghucu','Buddha','Hindu']);
            $table->longtext('alamat');
            $table->enum('status_pernikahan',['Kawin','Belum Kawin','Cerai']);
            $table->enum('status_keluarga',['Kepala Rumah Tangga','Isteri','Anak','Lainnya']);
            $table->string('pekerjaan');
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
        Schema::dropIfExists('penduduks');
    }
};
