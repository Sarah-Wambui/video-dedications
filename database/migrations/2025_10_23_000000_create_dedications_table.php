<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dedications', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('dedication_type');
            $table->string('other_type')->nullable();
            $table->string('honoree_name');
            $table->text('short_note')->nullable();
            $table->boolean('consent_spelling')->default(false);
            $table->string('status')->default('draft');
            $table->string('order_id')->nullable()->index();
            $table->json('metadata')->nullable();
            $table->integer('amount_cents')->default(18000);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dedications');
    }
};
