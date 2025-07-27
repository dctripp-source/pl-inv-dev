<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table) {
            // Dodaj kolone za oba pisma
            $table->string('business_name_latin')->nullable()->after('business_name');
            $table->string('business_name_cyrillic')->nullable()->after('business_name_latin');
            $table->text('description_latin')->nullable()->after('description');
            $table->text('description_cyrillic')->nullable()->after('description_latin');
            $table->text('services_latin')->nullable()->after('services');
            $table->text('services_cyrillic')->nullable()->after('services_latin');
            $table->string('address_latin')->nullable()->after('address');
            $table->string('address_cyrillic')->nullable()->after('address_latin');
            $table->string('city_latin')->nullable()->after('city');
            $table->string('city_cyrillic')->nullable()->after('city_latin');
        });
    }

    public function down()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn([
                'business_name_latin',
                'business_name_cyrillic',
                'description_latin',
                'description_cyrillic',
                'services_latin',
                'services_cyrillic',
                'address_latin',
                'address_cyrillic',
                'city_latin',
                'city_cyrillic'
            ]);
        });
    }
};