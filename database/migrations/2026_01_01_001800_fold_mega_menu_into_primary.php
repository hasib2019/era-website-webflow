<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Folds the separate `mega` menu into the primary row as a dropdown.
 *
 * The header used to end with a hard-coded "Other page" toggle whose three
 * columns were a whole second menu. Now that any item can be a dropdown, those
 * links belong to an ordinary item — so the editor has one screen instead of
 * two, and the panel can be moved or renamed like anything else.
 *
 * Labels, URLs and column headings are carried across untouched, including the
 * two non-breaking spaces in "Career  Details" that tools/verify.php matches on.
 */
return new class extends Migration
{
    public function up(): void
    {
        $primary = DB::table('menus')->where('slug', 'primary')->first();
        $mega = DB::table('menus')->where('slug', 'mega')->first();

        if (! $primary || ! $mega) {
            return;
        }

        $label = DB::table('settings')->where('key', 'navbar.dropdown_label')->value('value') ?: 'Other page';

        $toggleId = DB::table('menu_items')->insertGetId([
            'menu_id' => $primary->id,
            'parent_id' => null,
            'type' => 'dropdown',
            'label' => $label,
            'url' => '#',
            'target' => '_self',
            'column_heading' => null,
            'is_active' => true,
            // after every link already in the row, which is where it sat
            'sort_order' => (int) DB::table('menu_items')
                ->where('menu_id', $primary->id)
                ->whereNull('parent_id')
                ->max('sort_order') + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('menu_items')
            ->where('menu_id', $mega->id)
            ->update([
                'menu_id' => $primary->id,
                'parent_id' => $toggleId,
                'type' => 'link',
                'updated_at' => now(),
            ]);

        DB::table('menus')->where('id', $mega->id)->delete();
    }

    public function down(): void
    {
        $primary = DB::table('menus')->where('slug', 'primary')->first();

        if (! $primary) {
            return;
        }

        $toggle = DB::table('menu_items')
            ->where('menu_id', $primary->id)
            ->where('type', 'dropdown')
            ->whereNull('parent_id')
            ->first();

        if (! $toggle) {
            return;
        }

        $megaId = DB::table('menus')->insertGetId([
            'slug' => 'mega',
            'name' => 'Mega menu',
            'description' => 'The full-screen panel opened from the menu button.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('menu_items')
            ->where('parent_id', $toggle->id)
            ->update(['menu_id' => $megaId, 'parent_id' => null, 'updated_at' => now()]);

        DB::table('menu_items')->where('id', $toggle->id)->delete();
    }
};
