<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;

/**
 * The three logo bands on the about page.
 *
 * They are the same shape — a name, an optional logo, an order — so one screen
 * serves all three and `scope` says which band a row belongs to, the way
 * StatController already serves four pages of counters.
 */
class ClientController extends ResourceController
{
    /** scope => label, in page order. */
    public const SCOPES = [
        'partner' => 'Our partners',
        'client' => 'Our clients',
        'certification' => 'Certifications & membership',
    ];

    protected function model(): string
    {
        return Client::class;
    }

    protected function key(): string
    {
        return 'clients';
    }

    protected function labels(): array
    {
        return ['singular' => 'Logo', 'plural' => 'Clients & partners'];
    }

    /** `scope` is not here: the grouped table already heads each band with it. */
    protected function columns(): array
    {
        return ['name', 'logo_id', 'variant', 'row_group', 'is_published', 'sort_order'];
    }

    protected function baseQuery(): Builder
    {
        $scope = request('scope');

        return Client::query()->when(
            is_string($scope) && array_key_exists($scope, self::SCOPES),
            fn (Builder $query) => $query->where('scope', $scope),
        );
    }

    /**
     * Keep each band together rather than interleaving them by sort_order.
     *
     * FIELD() orders by the SCOPES list — partners, clients, certifications —
     * so the table reads in the order the bands appear on the page. Ordering by
     * the column alphabetically would put certifications first.
     */
    protected function defaultOrder(Builder $query): Builder
    {
        $order = implode(',', array_map(
            fn (string $scope) => "'" . $scope . "'",
            array_keys(self::SCOPES),
        ));

        return $query
            ->orderByRaw('FIELD(scope, ' . $order . ')')
            ->orderBy('row_group')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    protected function filters(): array
    {
        return self::SCOPES;
    }

    protected function groupBy(): ?string
    {
        return 'scope';
    }

    /** All three bands on one page, so a group is never split across pages. */
    protected function perPage(): int
    {
        return 100;
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['name'];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Name', 'type' => 'text', 'rules' => 'required|string|max:255', 'help' => 'Shown as styled text when no logo is uploaded, and used as the logo’s alt text when one is.'],
            'scope' => [
                'label' => 'Shown in',
                'type' => 'select',
                'rules' => 'required|in:' . implode(',', array_keys(self::SCOPES)),
                'options' => self::SCOPES,
                'help' => 'Which band of the about page this row appears in.',
            ],
            'logo_id' => ['label' => 'Logo (optional)', 'type' => 'media', 'rules' => 'nullable|exists:media,id', 'help' => 'Upload a logo to replace the text. Transparent PNG or SVG works best; every logo is scaled to the same height automatically.'],
            'logo_alt' => ['label' => 'Logo alt text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'variant' => [
                'label' => 'Colour',
                'type' => 'select',
                'rules' => 'nullable|in:white-logo',
                'options' => [
                    '' => 'As supplied',
                    'white-logo' => 'Redraw in white',
                ],
                'help' => 'The band is near-black. Use "Redraw in white" for a logo that is dark and has a transparent background — on a logo with its own background it fills the whole box with white. Best results come from uploading a transparent PNG or SVG.',
            ],
            'website_url' => ['label' => 'Website', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'row_group' => [
                'label' => 'Marquee row',
                'type' => 'select',
                'rules' => 'required|integer|min:1|max:3',
                'options' => [1 => 'Row 1', 2 => 'Row 2', 3 => 'Row 3'],
                'help' => 'Only the clients marquee uses this; partners and certifications ignore it.',
            ],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
