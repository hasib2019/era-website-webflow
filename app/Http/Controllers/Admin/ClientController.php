<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;

class ClientController extends ResourceController
{
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
        return ['singular' => 'Client', 'plural' => 'Clients'];
    }

    protected function columns(): array
    {
        return ['name', 'row_group', 'is_published', 'sort_order'];
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
            'name' => ['label' => 'Client name', 'type' => 'text', 'rules' => 'required|string|max:255', 'help' => 'The marquee renders the name as styled text, not an image.'],
            'logo_id' => ['label' => 'Logo (optional)', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'logo_alt' => ['label' => 'Logo alt text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'website_url' => ['label' => 'Website', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'row_group' => [
                'label' => 'Marquee row',
                'type' => 'select',
                'rules' => 'required|integer|min:1|max:3',
                'options' => [1 => 'Row 1', 2 => 'Row 2', 3 => 'Row 3'],
            ],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
