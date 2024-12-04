<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('non_conformity_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->string('client_description', 500);
            $table->string('description', 500)->nullable()->default(null);
            $table->foreignId('non_conformity_done_by_user_id')->nullable()->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_conformity_records');
    }
};
