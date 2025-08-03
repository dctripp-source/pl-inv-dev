<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->string('image_path'); // Putanja do slike u storage/public/businesses/
            $table->string('alt_text')->nullable(); // Alt tekst za accessibility
            $table->boolean('is_primary')->default(false); // Glavna slika biznisa
            $table->integer('sort_order')->default(0); // Redosled prikazivanja slika
            $table->timestamps();
            
            // Indeksi za performanse
            $table->index(['business_id', 'is_primary']);
            $table->index(['business_id', 'sort_order']);
            $table->index('is_primary');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_images');
    }
};