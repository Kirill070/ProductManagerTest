<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('article', 255)->unique();
            $table->string('name', 255);
            $table->string('status', 255)->index();
            $table->jsonb('data')->nullable();
            $table->softDeletes();
            $table->timestampsTz();
        });

        DB::statement("ALTER TABLE products
            ADD CONSTRAINT products_status_check
            CHECK (status IN ('available','unavailable'));");

        DB::statement("CREATE INDEX products_data_gin_idx ON products USING GIN (data);");
    }

    public function down(): void
    {
        DB::statement("DROP INDEX IF EXISTS products_data_gin_idx;");
        Schema::dropIfExists('products');
    }
};
