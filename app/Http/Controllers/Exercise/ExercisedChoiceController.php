<?php

namespace App\Http\Controllers\Exercise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ExerciseChoice;
use App\Services\Choice;
use App\Models\Exercise;
use App\Models\Exercised;
use App\Models\Logs;
use App\Services\LogsService;

class ExercisedChoiceController extends Controller
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
       

       $exercise = Exercise::find($request->course);
       $choice = new Choice();
       $choice->setData($exercise);
       $choiceTrue =  $choice->convertAnswer($exercise);
        $choiceStudent = $choice->trimp($request->answer);

        $exerciseds = new ExerciseChoice();  
        $score = ($request->score/count($choiceTrue))*$exerciseds->checkAuto($choiceTrue,$choiceStudent);
        
        $exercised = new Exercised();
        $exercised->fill($request->all()); 
 
        $exercised->type =  '5'; 
        $exercised->score =  $score;
        $exercised->save(); 
    
        LogsService::save($request->student,2,'ส่งแบบฝึกหัดเลือกข้อถูก');
     
        return   $score;
       
    }
 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exercise = Exercise::find($id);
        $exercised = new ExerciseChoice(); 
        $exercised->getData($exercise);
        $exercise->answer = $exercised->getChoice();
       return $exercise;
 
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
