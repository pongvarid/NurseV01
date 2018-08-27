<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseIn;
use App\Models\Exercise;
use App\Models\Student;
use App\Models\Exercised;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          
        $course = Course::find($id);
        $course->in = $this->mapping_coursein($id);
        $course->exercise = $this->mapping_exercised($this->mapping_exercise($id));

        return   $course;

    }
    public function mapping_coursein($id){
        $coursein = CourseIn::where('course',$id)->get();
      
        return   $this->mapping_student($coursein);
    }

    public function mapping_exercise($id){
        $exercise = Exercise::where('course',$id)->get();
        return  $exercise ;
    }

    public function mapping_exercised($exercise){
        $i=0;
         foreach($exercise as $key){
            //$exercise[$i]->exercised =  $this->mapping_student(Exercised::where('course',$key->id)->get());
            $exercise[$i]->exercised = Exercised::where('course',$key->id)->get();
            $i++;
         }

         return $exercise;
       
    }

    public function mapping_student($coursein){
        $i=0;
        foreach($coursein as $key){
            $coursein[$i]->student = Student::where('username',$key->student)->first();
            $i++;
        }

        return $coursein;
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
        //
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
    public function showScore($id)
    {
        $scores = DB::table('course')
            ->join('exercise', 'course.id', '=', 'exercise.course')
            ->join('exercised', 'exercise.id', '=', 'exercised.course')
            ->select( 'course.id', 'exercise.name', 'exercise.score', 'exercised.*')
            ->where('exercise.course', '=', $id)
            ->get();
            return $scores;

    }
}
