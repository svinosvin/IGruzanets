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
        Schema::create('resource_sub_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->nullable()->index()
                ->constrained('resources')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('sub_resource_id')->nullable()->index()
                ->constrained('sub_resources')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('resource_sub_resources');
    }
};
