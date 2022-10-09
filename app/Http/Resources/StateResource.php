<?php

namespace App\Http\Resources;

use App\Models\State;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin State
 */
class StateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
