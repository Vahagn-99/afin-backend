<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('manager_ratings', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('the date is Y-m format');
            $table->foreignId('manager_id')
                ->constrained('managers')
                ->on('managers')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type')->comment('the activity name leads count, price sum or etc.');
            $table->decimal('total');

            //indexes
            $table->index(['manager_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manager_ratings');
    }
};
