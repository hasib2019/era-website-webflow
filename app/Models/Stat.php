<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = ['scope', 'value', 'suffix', 'suffix_html', 'label', 'sort_order'];

    public function scopeForScope($query, string $scope)
    {
        return $query->where('scope', $scope);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * The trailing "+" / "M+" column, as markup.
     *
     * The export styles the plus sign with its own class on three of the four
     * pages, so the column was captured as raw HTML in `suffix_html` rather than
     * as text. That copy is honoured only while it still spells `suffix`:
     * without the check, editing "M+" to "K+" in the dashboard would save fine
     * and change nothing on the page, because the stored markup still said "M+".
     *
     * When the two diverge -- an edited suffix, or a stat created from the
     * dashboard, which has no captured markup at all -- the column is rebuilt
     * around the new text in the shape that page uses.
     */
    public function suffixMarkup(): ?string
    {
        $html = trim((string) $this->suffix_html);
        $suffix = trim((string) $this->suffix);

        if ($suffix === '') {
            return null;
        }

        // the export's own bytes, while they still say what the suffix says
        if ($html !== '' && html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8') === $suffix) {
            return $html;
        }

        $lead = rtrim($suffix, '+');
        $plus = substr($suffix, strlen($lead));

        // home renders a plain column; the other three give the "+" its own class
        $styled = $html === '' ? $this->scope !== 'home' : str_contains($html, 'counting-plus-icon');

        if ($plus === '' || ! $styled) {
            return '<div>' . e($suffix) . '</div>';
        }

        return $lead === ''
            ? '<div class="counting-plus-icon">' . e($plus) . '</div>'
            : '<div>' . e($lead) . '<span class="counting-plus-icon">' . e($plus) . '</span></div>';
    }
}
