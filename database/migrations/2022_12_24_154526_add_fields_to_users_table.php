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
        Schema::table('users', function (Blueprint $table) {
            $table->after('password', function ($table){

                $table->string('name')->nullable();
                $table->string('first_name')->nullable();
                $table->string('patronymic')->nullable();
                $table->string('tel_number')->unique();
                $table->foreignId('company_id')
                    ->nullable()
                    ->references('id')
                    ->on('companies')
                    ->onUpdate('cascade')
                    ->cascadeOnDelete();
            });

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->dropForeign(['company_id']);
           $table->dropColumn('company_id');
        });
    }
};
