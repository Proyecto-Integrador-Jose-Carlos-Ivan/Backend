<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ZoneResource",
 *     title="Zone Resource",
 *     description="Zone resource",
 *     @OA\Property(property="id", type="integer", format="int64", description="Zone ID"),
 *     @OA\Property(property="name", type="string", description="Zone name"),
 * )
 */
class ZoneResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}