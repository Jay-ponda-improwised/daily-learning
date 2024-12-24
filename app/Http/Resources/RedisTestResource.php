<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class RedisTestResource extends JsonResource
{
    public $data;

    public function __construct($request)
    {
        $this->data = [
            'id' => Arr::get($request, 'id'),
            'redis' => Arr::get($request, 'redis'),
        ];
        parent::__construct($this->data);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toJson($options = 0)
    {
        return $this->data;
    }
}
