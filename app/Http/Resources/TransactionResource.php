<?php

namespace App\Http\Resources;

use Brick\Math\BigInteger;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => (string) $this->title,
            'value' => (integer) $this->value / 100,
            'type' => (string) $this->type,
            'date' => (string) $this->date,
        ];
    }
}
