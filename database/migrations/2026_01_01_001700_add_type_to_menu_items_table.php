<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Lets a header link be a dropdown instead.
 *
 * The table already had `parent_id` and the model already had `children()`;
 * nothing set either, because the header's one dropdown was hard-coded in the
 * markup and fed from a separate `mega` menu. A `type` is all that was missing
 * to let any item in the row open a panel, at any position.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('type', 20)->default('link')->after('parent_id');
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
