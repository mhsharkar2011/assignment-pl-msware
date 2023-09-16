<?php

use App\Enums\Type;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('transaction_type',[Type::Individual,Type::Business]);
            $table->double('amount')->nullable();
            $table->decimal('fee')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        // Define the foreign key constraint
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
