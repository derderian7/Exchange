<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('description');
                $table->string('location');
                $table->string('category');
                $table->boolean('post_status')->default(0);
                $table->string('image', 300)->nullable();
                $table->foreignId('user_id')->constrained('users');
                //$table->foreignId('category_id')->nullable()->constrained('categories');
                $table->timestamps();
            });
        }
    
        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('posts');
        }
    };
    

    /**
     * Reverse the migrations.
     */

