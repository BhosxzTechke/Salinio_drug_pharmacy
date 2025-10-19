<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('vats', function (Blueprint $table) {
                $table->id();
                $table->string('name');       // e.g. "Standard Rate"
                $table->decimal('rate', 5, 2); // e.g. 12.00 (%)
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
            
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vats');
    }
};
