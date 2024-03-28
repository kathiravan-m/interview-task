<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\Skill;
use App\Models\Course;
use App\Models\Capability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CourseResource;
use App\Http\Requests\CreateCourseValidation;
use App\Http\Requests\UpdateCourseValidation;


class CourseController extends Controller
{
    protected $courses;
    protected $capabilities;
    protected $skills;

    public function __construct(Course $courses,Capability $capabilities, Skill $skills)
    {
        $this->courses = $courses;
        $this->capabilities = $capabilities;
        $this->skills = $skills;
    }

    /**
     * Store Course Details
     * @param CreateCourseValidation, $request
     * @return JsonResponse
     * 
     */
    public function store(CreateCourseValidation $request)
    {    
        try
        {
            $validated = $request->validated();
            $course = $this->courses->create($validated);
            foreach($validated['capability'] as $capability)
            {
                $data =  $course->capabilities()->create($capability);
                $data->skills()->createMany($capability['skill']);
            }
            return $this->successResponse(__('task.created'));
        }catch(Exception $e)
        {
            Log::error('Issue on CourseController@store');
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Get course List
     * @return JsonResponse
     * 
     */
    public function getCourse()
    {
        try
        {
            $courses = $this->courses->with('capabilities','capabilities.skills')->paginate(10);
            $response = [
                'statuscode' => 200,
                'data' => CourseResource::collection($courses),
                'pagable' => [
                    'total' => $courses->total(),
                    'limit' => $courses->perPage(),
                    'page' => $courses->currentPage(),
                ],
            ];
            return response()->json($response);
        }catch(Exception $e)
        {
            Log::error('Issue on CourseController@getCourse');
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Update course
     * @param CreateCourseValidation, $request
     * @return JsonResponse
     * 
     */
    public function updateCourse(UpdateCourseValidation $request)
    {
        try {
            $validated = $request->validated();
            $this->courses->where('_id',$validated['courseId'])->update($validated);
            foreach($validated['capability'] as $capability) {            
                $this->capabilities->where(['_id'=>$capability['capabilityId']])->update($capability);
                $skills = $capability['skill'];
                foreach($skills as $skill)
                {
                    $this->skills->where(['_id'=>$skill['skillId']])->update($skill);
                }
            }
            return $this->successResponse(__('task.updated'));
        }catch(Exception $e) {
            Log::error('Issue on CourseController@updateCourse');
            return $this->errorResponse($e->getMessage());
        }
    }


    /**
     * delete course
     * @param Course, $course
     * @return JsonResponse
     * 
     */
    public function destory(Request $request)
    {
        try{
            $validated = $request->validate([
                'courseId' => 'required',
            ]);
            $course = $this->courses->where('_id',$validated['courseId'])->with('capabilities')->first();
            if ($course) 
            {
                $courseCapabilities  = $course->capabilities;  
                foreach($courseCapabilities as $courseCapability)
                {
                    $this->skills->where('capabilityId',$courseCapability->_id)->delete(); 
                }
                $this->capabilities->where('courseId',$course->id)->delete();
                $course->delete();
                $response = __('task.deleted');
            }else {
                $response = __('task.error');
            }
            return $this->successResponse($response);
        }catch(Exception $e){
            
            Log::error('Issue on CourseController@destory');
            return $this->errorResponse($e->getMessage());
        }
    }


}
