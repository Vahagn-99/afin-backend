<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('manager_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')
                ->constrained('contacts')
                ->references('id')
                ->cascadeOnDelete();
            $table->foreignId('manager_id')
                ->constrained('managers')
                ->references('id')
                ->cascadeOnDelete();
            $table->decimal('deposit');
            $table->decimal('volume_lots');
            $table->decimal('bonus');
            $table->decimal('potential_bonus');
            $table->decimal('payoff');
            $table->decimal('paid')->default(0);
            $table->date('date');

            //indexes
            $table->index(['manager_id', 'contact_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manager_bonuses');
    }
};
