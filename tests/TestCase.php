<?php

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    protected function setUpWasteMsSchema(): void
    {
        Schema::dropAllTables();

        Schema::create('type_wastes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->integer('points')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('order_type_wastes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreignId('type_waste_id')->constrained('type_wastes')->cascadeOnDelete();
            $table->decimal('weight', 8, 2)->default(0);
            $table->timestamps();
        });
    }
}
