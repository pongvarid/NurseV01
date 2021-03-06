<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Exercised;
use App\Services\LogsService;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('exercise.chooseExercise');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $exercise = new Exercise();
        $exercise->fill($request->all());
        $save = $exercise->save();
        LogsService::save($request->teacher, 1, $request->event);
        if ($save) {
            return 1;
        } else {
            return 0;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exercise = Exercise::where('course', $id)
        ->orderBy('created_at', 'desc')
        ->get();
        return $exercise;
        //$exercise = DB::table('exercise')
        //      ->join('exercised', 'exercise.id', '=', 'exercised.course')
        //     ->select('exercise.*', 'exercised.*')
        //      ->where('exercise.course', '=', $id)
        //      ->get();
        //  return $exercise;
    }
    public function showTest($id, $student)
    {
        $exercise = Exercised::where('course', $id)->where('student', $student)->get();

        if ($exercise != "[]") {
            return 1;
        } else {
            return 0;
        }

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

        $exercise = Exercise::find($id);
        $exercise->fill($request->all());
        $save = $exercise->save();
        LogsService::save($request->teacher, 1, $request->event);
        if ($save) {
            return 1;
        } else {
            return 0;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exercise = Exercise::find($id);
        return $exercise->destroy($id);
    }

}
