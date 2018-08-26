<?php

namespace App\Http\Controllers\Course;

use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Models\Logs;
use App\Http\Controllers\Controller;
use App\Models\Exercised;
use App\Services\StudentService;

class ExercisedController extends Controller
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
        $exercised = Exercised::where('course', $id)->get();
        $student = new StudentService(); 
        $student->studentGetData($exercised);
        $student->feathData(); 
        return $student->feathData();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exercised = Exercised::find($id);
        return $exercised;
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
        $exercised = Exercised::find($id);
        $exercised->type = $request->type;
        $exercised->score = $request->score;
        $exercised->save();
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
    public function checkExercised($id)
    {
        $exercised = Exercised::where('student', $id)->get();
        return $exercised;
    }
    public function checkDate($id){
        $exercise = Exercise::where('id', $id)->get();
        
        return $exercise ;

    }
}
