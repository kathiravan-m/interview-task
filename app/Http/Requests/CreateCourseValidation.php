<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Interfaces\JsonResponseInterface;

class CreateCourseValidation extends JsonResponseInterface
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           'courseName'=> 'required',
           'startDate' => 'required',
           'endDate'=>'required',
           'courseImage'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|',
           'capability.*.capabilityName'=>'required',
           'capability.*.skill.*.skillName'=>'required'
        ];
    }

    /**
     * 
     * @param $key, $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        $path = $this->file('courseImage')->getRealPath();    
        $image = file_get_contents($path);
        $validated['courseImage'] = base64_encode($image);
        return $validated;
    }
}
