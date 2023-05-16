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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->index()
                ->constrained('services')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('auto_id')->nullable()->index()
                ->constrained('autos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->index()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->index()
                ->constrained('drivers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('tel_number')->nullable();
            $table->text('notice')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->float('weight', 7, 2);
            $table->float('total_price', 7, 2);
            $table->dateTime('order_at')->nullable();
            $table->foreignId('order_types_id')->default(1)->nullable()->index()
                ->constrained('order_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->tinyInteger('is_accepted')->default(0); // 0 - false // 1 - true ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
