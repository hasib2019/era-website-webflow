<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stats', function (Blueprint $table) {
            // the "+" after a counter is styled markup, and the shape differs
            // per page, so the export's own version is kept verbatim
            $table->text('suffix_html')->nullable()->after('suffix');
        });
    }

    public function down(): void
    {
        Schema::table('stats', function (Blueprint $table) {
            $table->dropColumn('suffix_html');
        });
    }
};
