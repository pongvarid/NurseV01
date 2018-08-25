<?php

namespace App\Http\Controllers\Course;
use App\Models\Course;
use App\Models\CourseIn;
use App\Models\Teacher;
use App\Models\Logs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $course = new Course(); 
        return $course->get()->toJson();
    }
    
    public function searchCourse($course)
    {  
         $course = Course::where('code',$course)->orderBy('updated_at', 'desc')->get();
        return $course;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("course.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = new Course();
        $course->fill($request->all());
        $save_course = $course->save();

        $logs = new Logs();
        $logs->user = $request->teacher;
        $logs->type = 'teacher';
        $logs->event = 'เพิ่มรายวิชา';
        $logs_course = $logs->save();

        if($save_course && $logs_course) return 1;
        else return 0;

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::where('teacher',$id)->orderBy('created_at', 'desc')->get();
        // ->orderBy('name', 'desc')
        return $course->toJson();
    }

    public function getCourse($id)
    {
        $course = Course::where('id',$id)->first();
        return $course->toJson();
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        $course->fill($request->all());
        $course->save();

        $logs = new Logs();
        $logs->user = $request->teacher;
        $logs->type = 'teacher';
        $logs->event = 'แก้ไขรายวิชา';
        $logs_course = $logs->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function closeCourse(Request $request, $id)
    {
        $course =  Course::find($id);  
        $course->fill($request->all());  
        $course->save();

        $logs = new Logs();
        $logs->user = $request->teacher;
        $logs->type = 'teacher';
        $logs->event = 'ปิดรายวิชา';
        $logs_course = $logs->save();
    }

    public function register(Request $request)
    {
        $register = new CourseIn();
        $register->fill($request->all());
        $save = $register->save();
        if($save) return 1;
        else return 0;
    }
    public function viewCourseIN($id){
        $courseIn = CourseIn::find($id);
        return $courseIn;
    }
    public function getCourseIn($id)
    {
        $coursein = CourseIn::where('student',$id)->get();
        $i=0;
       foreach($coursein as $key){
        $coursein[$i]->courseData =   $this->getCourseData($key->course);
            $i++;
        }
        return  $coursein->toJson(); 
    }

    public function getCourseData($id){
        $course = Course::where('id',$id)->get();
        return $course->toJson(); 
    }

    public function check(Request $request)
    {
        $course = $_GET['course'];
        $student = $_GET['student']; 
        $check = CourseIn::where('course',$course)->where('student', $student)->first();
       if(isset($check)){return 0;}
       else{return 1;} 
        
    }
}
