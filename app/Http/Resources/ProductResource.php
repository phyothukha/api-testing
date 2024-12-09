<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public  function stockStatus($count)
    {
        $status = "";
        if ($count > 20) {
            $status = 'available';
        } elseif ($count < 20) {
            $status = 'few';
        } else {
            $status = 'out of stock';
        }
        return $status;
    }

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "price" => $this->price,
            "show_price" => $this->price . ' mmk',
            "stock" => $this->stock,
            "stock_status" => $this->stockStatus($this->stock),
            "date" => $this->created_at->format('d-m-Y'),
            "time" => $this->created_at->format('H:i A'),
            "owner" => new UserResource($this->user),
            "photos" => PhotoResource::collection($this->photos)
        ];
    }
}
