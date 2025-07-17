<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatatanToDetailPesanansTable extends Migration
{
    /**
     * -
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pesanans', function (Blueprint $table) {
            $table->string('catatan')->nullable()->after('harga');
        });
    }

    /**
     * -
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pesanans', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
}
