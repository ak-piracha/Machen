<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ToDoResource extends JsonResource
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
            'id' => (string)$this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'update_at' => $this->updated_at,
            ],
            // 'status' => [
            //     'id' => (string)$this->status->id,
            //     'status_name' => $this->status->name,
            // ],
            'relationships' => [
                'id' => (string)$this->user->id,
                'user_name' => $this->user->name,
                'user_email' => $this->user->email,
            ],
        ];
    }
}
