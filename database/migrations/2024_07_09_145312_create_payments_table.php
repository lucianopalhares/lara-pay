<?php

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string('gateway_payment')->nullable();
            $table->string('customer')->nullable();
            $table->string('payment_id')->nullable(); 
            $table->string('credit_card_brand')->nullable();
            $table->string('credit_card_number')->nullable();                       
            $table->string('invoice_number', 250);
            $table->text('invoice_url')->nullable();
            $table->string('external_reference', 250)->nullable();
            $table->string('status', 150)->nullable();
            $table->string('billing_type', 50)->nullable();
            $table->decimal('value', 8, 2);
            $table->timestamp('due_date')->nullable();
            $table->boolean('can_be_paid_after_due_date')->nullable();
            $table->longText('description')->nullable();
            $table->longText('encodedImage')->nullable();
            $table->longText('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
