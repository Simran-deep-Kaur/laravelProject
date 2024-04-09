<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'age' => $this->age,
            'profile_image' => $this->profile_image,
            'profile_url' => $this->profile_image ? asset('show-image/' . $this->profile_image) : asset('storage/uploads/image2.png'),
            'user_id' => $this->user_id,
            'edit_url' => route('employee.edit', $this->id),
            'delete_url'=> route('employee.destroy', $this->id),
            'show_url'=> route('employee.show', $this->id),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'creator' => $this->creator,
            'unique_id' => $this->unique_id,
        ];
    }
    
}