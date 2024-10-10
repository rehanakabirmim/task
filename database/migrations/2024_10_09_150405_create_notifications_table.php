<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('type'); // Type of notification
            $table->morphs('notifiable'); // Polymorphic relation fields (notifiable_id, notifiable_type)
            $table->json('data'); // JSON data field for storing additional information
            $table->timestamp('read_at')->nullable(); // Timestamp for when the notification is read
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
