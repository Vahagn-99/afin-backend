<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archived_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('login');
            $table->unsignedBigInteger('position');
            $table->string('utm');
            $table->timestamp('opened_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->string('action');
            $table->string('symbol');
            $table->decimal('lead_volume', 20, 8);
            $table->decimal('price', 20, 8);
            $table->decimal('profit', 20, 8)->nullable();
            $table->string('reason');
            $table->decimal('float_result', 20, 8)->nullable();
            $table->string('currency');
            $table->foreignId('archive_id')
                ->constrained('archives')
                ->references('id')
                ->on('archives')
                ->cascadeOnDelete();

            // indexes
            $table->index('login');
            $table->unique(['login', 'position']);
            $table->index('opened_at');
            $table->index('closed_at');
            $table->index(['opened_at', 'closed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_positions');
    }
};
