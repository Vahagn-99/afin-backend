<?php

namespace App\Http\Requests\AmoCRM\Webhooks;

use Illuminate\Foundation\Http\FormRequest;

class ContactWebhookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contacts.add'         => ['sometimes', 'array'],
            'contacts.update'      => ['sometimes', 'array'],
//            'contacts.delete'      => ['sometimes', 'array'],
            'contacts.restore'     => ['sometimes', 'array'],
            'contacts.responsible' => ['sometimes', 'array']
        ];
    }
}
