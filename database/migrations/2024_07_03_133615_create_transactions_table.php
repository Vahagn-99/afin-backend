<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
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
                ->default(0)
                ->comment('The balance of this transaction at the start of the month');
            $table->decimal('balance_end', 20)
                ->default(0)
                ->comment('The balance of this transaction at the end of the month');
            $table->decimal('commission', 20)
                ->default(0)
                ->comment('P/L');
            $table->timestamp('created_at')->useCurrent();

            //indexes
            $table->unique('login');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }

};
