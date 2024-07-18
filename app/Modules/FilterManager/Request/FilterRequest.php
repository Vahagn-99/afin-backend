<?php

namespace App\Modules\FilterManager\Request;

use App\DTO\PaginationDTO;
use App\Modules\FilterManager\Filter\HasFilterAggregator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    use HasFilterAggregator;

    public function rules(): array
    {
        return [
            'search'              => ['nullable', 'string'],

            'compares'            => ['nullable', 'array'],
            'compares.*.field'    => [Rule::requiredIf($this->get('compares')), 'string'],
            'compares.*.value'    => [Rule::requiredIf($this->get('compares')), 'filterable'],
            'compares.*.operator' => [Rule::requiredIf($this->get('compares')), Rule::in(['>', '<', '=', '!=', '>=', '<='])],

            'filters'             => ['nullable', 'array'],
            'filters.*'           => [Rule::requiredIf($this->get('filters')), 'filterable'],

            'sorts'               => ['nullable', 'array'],
            'sorts.*'             => [Rule::requiredIf($this->get('sort')), 'string'],
        ];
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return new PaginationDTO(
            $this->input('page', 1),
            $this->input('per_page', 50)
        );
    }
}
