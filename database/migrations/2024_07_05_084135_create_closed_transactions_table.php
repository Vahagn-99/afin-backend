<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('closed_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('login');
            $table->unsignedBigInteger('lk');
            $table->decimal('deposit', 20)
                ->default(0);
            $table->string('currency');
            $table->decimal('withdrawal', 20)
                ->default(0);
            $table->decimal('volume_lots', 20)
                ->default(0);
            $table->decimal('equity', 20)
                ->default(0);
            $table->decimal('balance_start', 20)
                ->default(0);
            $table->decimal('balance_end', 20)
                ->default(0);
            $table->decimal('commission', 20)
                ->default(0)
                ->comment('P/L');
            $table->timestamp('created_at')->useCurrent();

            $table->foreignId('history_id')
                ->constrained('histories')
                ->references('id')
                ->on('histories')
                ->cascadeOnDelete();

            $table->index('history_id');
            $table->unique('login');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('closed_transactions');
    }
};
