<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stat;
use Illuminate\Database\Eloquent\Builder;

/**
 * The animated counters in the "about us" band of four pages.
 *
 * `scope` is which page a row belongs to, so the same screen serves all four;
 * arriving from the page editor narrows it with ?scope=home.
 */
class StatController extends ResourceController
{
    /** scope => label, in page order. */
    public const SCOPES = [
        'home' => 'Home page',
        'about' => 'About page',
        'service' => 'Services page',
        'career' => 'Career page',
    ];

    protected function model(): string
    {
        return Stat::class;
    }

    protected function key(): string
    {
        return 'stats';
    }

    protected function labels(): array
    {
        return ['singular' => 'Counter', 'plural' => 'Counters'];
    }

    protected function columns(): array
    {
        return ['label', 'value', 'suffix', 'scope', 'sort_order'];
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['label'];
    }

    protected function baseQuery(): Builder
    {
        $scope = request('scope');

        return Stat::query()->when(
            is_string($scope) && array_key_exists($scope, self::SCOPES),
            fn (Builder $query) => $query->where('scope', $scope),
        );
    }

    /** Group the four pages together rather than interleaving them by sort_order. */
    protected function defaultOrder(Builder $query): Builder
    {
        return $query->orderBy('scope')->orderBy('sort_order')->orderBy('id');
    }

    protected function fields(): array
    {
        return [
            'label' => [
                'label' => 'Label',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'help' => 'The line under the number, e.g. "Clients Worldwide".',
            ],
            'value' => [
                'label' => 'Number',
                'type' => 'text',
                'rules' => 'required|regex:/^[0-9]{1,10}$/',
                'help' => 'Digits only. Each digit becomes one scrolling column, so 325 counts up in three.',
            ],
            'suffix' => [
                'label' => 'Suffix',
                'type' => 'text',
                'rules' => 'nullable|string|max:10',
                'help' => 'Sits after the number and does not animate — "+", "M+", "%". Leave empty for none.',
            ],
            'scope' => [
                'label' => 'Shown on',
                'type' => 'select',
                'rules' => 'required|in:' . implode(',', array_keys(self::SCOPES)),
                'options' => self::SCOPES,
            ],
            'sort_order' => [
                'label' => 'Order',
                'type' => 'number',
                'rules' => 'nullable|integer|min:0',
                'help' => 'Low to high, left to right within the page.',
            ],
        ];
    }
}
