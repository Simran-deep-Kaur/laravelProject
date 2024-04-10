<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'age' => $this->age,
            'profile_image' => $this->profile_image,
            'profile_url' => $this->profile_image ? asset('show-image/' . $this->profile_image) : asset('storage/uploads/image2.png'),
            'edit_url' => route('admin.edit',$this->id),
            'delete_url'=>route('admin.destroy',$this->id),
            'show_url'=>route('admin.show',$this->id),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            // 'role' => RoleResource::collection($this->whenLoaded('roles')),
            // 'role' => $this->whenLoaded('roles'),
            'role' => $this->role,
        ];
    }
}
