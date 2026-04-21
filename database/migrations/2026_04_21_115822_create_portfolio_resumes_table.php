<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_resumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');

            $table->string('title', 180)->nullable();
            $table->string('original_file_name', 255);
            $table->string('stored_file_name', 255)->nullable();
            $table->string('storage_disk', 50)->default('public');
            $table->string('file_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->longText('extracted_text')->nullable();
            $table->json('parsed_data')->nullable();

            $table->enum('parse_status', ['pending', 'processing', 'completed', 'failed', 'reviewed'])
                ->default('pending');

            $table->enum('import_status', ['not_imported', 'partial', 'completed'])
                ->default('not_imported');

            $table->string('parser_name', 120)->nullable();
            $table->text('error_message')->nullable();

            $table->boolean('is_primary')->default(false);
            $table->timestamp('parsed_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('imported_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['portfolio_id', 'is_primary'], 'presume_portfolio_primary_idx');
            $table->index('parse_status', 'presume_parse_status_idx');
            $table->index('import_status', 'presume_import_status_idx');
            $table->index('parsed_at', 'presume_parsed_at_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_resumes');
    }
};
