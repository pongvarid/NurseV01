<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />'; die();}
else{
    $id = $_SESSION['user'];
    $code = $_SESSION['student']; 
    if($_SESSION["user_type"] != 'student'){
        echo '<meta http-equiv="refresh" content="0; url=/teacher/profile" />'; die();
    } 
}
?> 
     
@extends('core.vuetify') 
 
    
@section('vue')
 @{{exercise.ask}}
 
@endsection
 
@section('vue_script')
<script>
  new Vue({
  el: "#app",
  data: {
      exercise:null,
  },
  methods: { 
       
     load(){
        axios.get("/api/exercise/do/askanswer/{{request()->route('id')}}")
      .then((r) => {
          this.exercise = r.data;
      }).catch((e) => { 
          alert('error');
      });
     }
  },
  mounted(){
    this.load();
  }
});


</script>
@endsection
 