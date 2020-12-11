<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importations', function (Blueprint $table) {
            $table->id();            
            $table->string('file');
            $table->string('path');
            $table->enum('type', ['people', 'shiporders']);
            $table->enum('status', ['pending', 'importing', 'imported_with_success', 'imported_with_error'])->default('pending');
            $table->integer('success')->default(0);
            $table->integer('errors')->default(0);
            $table->integer('total')->default(0);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('importations');
    }
}
