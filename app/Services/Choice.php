<?php
namespace App\Services;

class Choice{

    private $ask;
    private $choice;
    private $answer;
    private $tmp;

    public function setData($data){
        $this->tmp = explode('<answer>',$data->answer);
        $this->ask = $data->ask;
    }
    
    public function convertAsk(){ 
        $this->ask= explode(',',$this->ask);
        $this->ask = array_slice($this->ask,1);
        return  $this->ask;
    }


    public function convertChoice(){
        $this->choice = explode('<choice>',$this->tmp[0]);
        $this->choice = array_slice($this->choice,1);
        return  $this->choice;
    }

    public function convertAnswer(){
        $this->answer =  explode(',',$this->tmp[1]);
        $this->answer = array_slice($this->answer,1);
        return  $this->answer;
    }

    public function trimp($data){
        $data = explode(',',$data);
        $data = array_slice($data,1);
        return  $data;
    }

}