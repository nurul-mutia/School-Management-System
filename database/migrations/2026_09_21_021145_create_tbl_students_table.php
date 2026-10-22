<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('tbl_users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('tbl_classes')->onDelete('cascade'); // Relasi Database
            $table->string('nisn')->unique();
            $table->string('name');
            $table->string('slug')->nullable(); // Standard: Slug
            $table->string('email')->unique();
            $table->integer('tuition_fee')->default(0); // Standard: Format Angka
            $table->date('enrollment_date'); // Standard: Format Tanggal
            $table->string('photo')->nullable(); // Validasi upload gambar
            $table->boolean('archived')->default(false); // Custom Soft Delete
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_students');
    }
};