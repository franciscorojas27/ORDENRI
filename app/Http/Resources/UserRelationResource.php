<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRelationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'client_description' => $this->client_description,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'evaluation_at' => $this->evaluation_at,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'closed_at' => $this->closed_at,
            'client' => optional($this->client)->only('id', 'name'),
            'applicantTo' => optional($this->applicantTo)->only('id'),
            'responsible' => optional($this->responsible)->only('id'),
            'resolutionArea' => optional($this->resolutionArea)->only('id', 'area'),
            'type' => optional($this->type)->only('id', 'type'),
            'status' => optional($this->status)->only('id', 'status'),
        ];
    }
}
