<?php

namespace App\Http\Requests;


use App\Interfaces\JsonResponseInterface;


class UpdateCourseValidation extends JsonResponseInterface
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'courseId' =>'required||exists:courses_collection,_id',
            'courseName'=> 'required',
            'startDate' => 'required',
            'endDate'=>'required',
            'courseImage'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|',
            'capability.*.capabilityId'=>'required|exists:capabilities_collection,_id',
            'capability.*.capabilityName'=>'required',
            'capability.*.skill.*.skillId'=>'required|exists:skills_collection,_id',
            'capability.*.skill.*.skillName'=>'required'
        ];
    }

    /**
     * 
     * @param $key, $default
     * @return $array
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        if($this->file('courseImage'))
        {
            $path = $this->file('courseImage')->getRealPath();    
            $image = file_get_contents($path);
            $validated['courseImage'] = base64_encode($image);
        }
        return $validated;
    }


}
