<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\Exercised;
use App\Models\Student;
use Symfony\Component\HttpKernel\Tests\Fixtures\Controller\NullableController;
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

        $exercise = new Exercise(); 

        $exercise->data = $exercise->where('course',$course->id)->get(); 
        $exercise->exercised = $this->mirror($exercise->where('course',$course->id)->get());

        $course->exercise =   $exercise;

        return    $course->exercise;
        
    }


    public function mirror($object){
        $exerciseds = null;
        $i=0;
         foreach($object as $key){
            $exercised = new Exercised();
            $exerciseds[$i] = $exercised->where('course',$key->id)->get();
            $i++;
         }
         return  $exerciseds;
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
}
