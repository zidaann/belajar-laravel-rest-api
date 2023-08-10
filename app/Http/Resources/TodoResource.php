<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            // 'created_at' => $this->created_at,
            'updated_at' => $this->updated_at->diffForHumans(),
            // 'user' => $this->user
            'user' => UserResource::make($this->user)
        ];
    }
}

/**  Mengubah format tanggal
 * Cara 1 
 * ~ atur atau tambahkan pada model kode dibawah ini
 
 
 *  public function getCreatedAtAttribute()
 *  {
 *       return Carbon::parse($this->attributes['created_at'])
 *          ->diffForHumans();
 *    }
 *    public function getUpdatedAtAttribute()
 *    {
 *       return Carbon::parse($this->attributes['updated_at'])
 *           ->diffForHumans();
 *  }

 * kemudian tambahkan atau atur biasa kode 'created_at' => $this->updated_at diatas

 
 * Cara 2
 * 'created_at' => $this->created_at->diffForHumans()
 * 
 */
