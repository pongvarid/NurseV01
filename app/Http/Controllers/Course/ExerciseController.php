<?php

namespace App\Http\Controllers\Course;
use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Services\LogsService;
use App\Http\Controllers\Controller;
use App\Models\Exercised;
use App\Services\StudentService;
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
        LogsService::save($request->teacher,1,$request->event);
        if($save) return 1;
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
        $exercise = Exercise::where('course',$id)->get();
        return $exercise->toJson();
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
        
        $exercise =  Exercise::find($id);
        $exercise->fill($request->all());
        $save = $exercise->save();
        LogsService::save($request->teacher,1,$request->event);
        if($save) return 1;
        else return 0;
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
