<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('owner_first_name');
            $table->string('owner_last_name');
            $table->string('business_name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('services')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('website')->nullable();
            $table->json('social_media')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['status', 'city']);
            $table->index('slug');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};