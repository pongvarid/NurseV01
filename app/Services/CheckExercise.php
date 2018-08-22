<?php
namespace App\Services;

interface CheckExercise{

    public function getAsk();
    public function getChoice();
    public function check();
}