<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = $this->capabilities->map(function ($capability) {
            
            $capability->capabilityId = $capability->_id;
            unset($capability->_id);
            $capability->skills->map(function ($skill) {
                $skill->skillId = $skill->_id;
                $skill->courseId = $this->_id;
                unset($skill->_id);
                return $skill;
            });
            return $capability;
        });
        
        return [
            'courseName' => $this->courseName,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'capability' => $data,
        ];

    }
}
