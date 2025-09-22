<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->json('name');
            $table->string('commercial_number');
            $table->string('tax_number');
            $table->string('currency')->nullable();
            $table->string('country')->nullable();
            $table->boolean('is_vat_registered')->default(false);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('tax_registeration_date')->nullable();
            $table->date('tax_first_due_date')->nullable();
            $table->string('tax_period')->nullable();
            $table->string('fiscal_year_end')->nullable();
            $table->string('building_number')->nullable();
            $table->string('street')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->json('data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}
