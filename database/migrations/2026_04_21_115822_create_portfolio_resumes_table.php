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

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('portfolio_id');

            $table->string('title')->nullable();
            $table->string('original_file_name');
            $table->string('stored_file_name')->nullable();
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->longText('extracted_text')->nullable();
            $table->json('parsed_data')->nullable();

            $table->enum('parse_status', ['pending', 'processing', 'completed', 'failed', 'reviewed'])
                ->default('pending');

            $table->string('parser_name')->nullable();
            $table->text('error_message')->nullable();

            $table->boolean('is_primary')->default(false);
            $table->timestamp('parsed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'portfolio_id'], 'presume_user_portfolio_idx');
            $table->index('parse_status', 'presume_parse_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_resumes');
    }
};
