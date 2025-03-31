<?php

return new class extends Migration {
    public function up(): void {
        Schema::create('order_type_wastes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_waste_id')->constrained('type_wastes')->onDelete('cascade');
            $table->integer('order_id'); // Se debe validar contra el MS de órdenes
            $table->decimal('weight', 10, 2);
            $table->integer('points');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_type_wastes');
    }
};

