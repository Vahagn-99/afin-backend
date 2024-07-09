<?php

namespace App\Http\Requests\Api\V1\History;

use App\DTO\PaginationDTO;
use Illuminate\Foundation\Http\FormRequest;

class GetHistoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return new PaginationDTO(
            $this->input('page', 1),
            $this->input('per_page', 50),
        );
    }
}
