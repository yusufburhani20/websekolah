<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("ppdb_payments", function (Blueprint $table) {
            $table->id();
            $table->foreignId("ppdb_registration_id")->constrained("ppdb_registrations")->cascadeOnDelete();
            $table->string("bukti_transfer");
            $table->decimal("jumlah", 10, 2)->nullable();
            $table->date("tanggal_transfer")->nullable();
            $table->enum("status", ["menunggu","verified","ditolak"])->default("menunggu");
            $table->foreignId("verified_by")->nullable()->constrained("users")->nullOnDelete();
            $table->timestamp("verified_at")->nullable();
            $table->text("catatan")->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("ppdb_payments"); }
};