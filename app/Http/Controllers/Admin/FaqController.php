<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;

class FaqController extends ResourceController
{
    protected function model(): string
    {
        return Faq::class;
    }

    protected function key(): string
    {
        return 'faqs';
    }

    protected function labels(): array
    {
        return ['singular' => 'FAQ', 'plural' => 'FAQs'];
    }

    protected function columns(): array
    {
        return ['question', 'scope', 'is_published', 'sort_order'];
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['question', 'answer'];
    }

    protected function fields(): array
    {
        return [
            'question' => ['label' => 'Question', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'answer' => ['label' => 'Answer', 'type' => 'richtext', 'rules' => 'required|string'],
            'scope' => [
                'label' => 'Shown on',
                'type' => 'select',
                'rules' => 'required|string|max:40',
                'options' => ['general' => 'All FAQ blocks', 'service' => 'Services page', 'contact' => 'Contact page'],
            ],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
