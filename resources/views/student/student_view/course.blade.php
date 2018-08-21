<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />'; die();}
else{
    $id = $_SESSION['user']; 
    if($_SESSION["user_type"] != 'student'){
        echo '<meta http-equiv="refresh" content="0; url=/teacher/profile" />'; die();
    } 
}
?> 
@extends('core.vuetify') 

@section('vue')
<v-container grid-list-md>
        <v-layout row wrap>
    
            <v-flex d-flex xs12 sm4>
    
                <v-card color="">
                    <v-toolbar color="indigo" dark>
                        <v-icon>fas fa-user-circle </v-icon>
                        <v-toolbar-title>เอกสารประกอบการเรียน</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <v-btn flat large color="primary" block>เอกสาร1</v-btn>
                        <v-btn flat large color="primary" block>เอกสาร2</v-btn>
                        <v-btn flat large color="primary" block>เอกสาร3</v-btn>
                    </v-card-text>
                </v-card>
            </v-flex>
    
            <v-flex d-flex xs12 sm8>
                <v-layout row wrap>
                    <v-flex d-flex>
                        <v-card>
                            <v-toolbar color="indigo" dark>
                                <v-icon>fas fa-align-justify </v-icon>
                                <v-toolbar-title>แบบฝึกหัด</v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-toolbar>
                            <v-card-text>
                                <div v-for="exercise in exercises">
                                    <v-list-tile avatar @click="goto_exercisePage(exercise.id,exercise.type)">
                                        <v-list-tile-content>
                                            <h3 class="headline mb-0">@{{exercise.name}}</h3>
                                            <div>@{{exercise.time}}</div> 
                                        </v-list-tile-content>
                                    </v-list-tile>
                                    <v-divider></v-divider>
                                </div> 
                        </v-card>
                    </v-flex>
                </v-layout>
    </v-container>
@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {  
    exercises:{},
  },
  methods: {
    goto_exercisePage(id,type){ //แก้ไขแบบฝึกหัดตอบถูกผิด
        if(type == '1'){
            window.location = "/student/course/exercise/ask_exercise/"+id;
        }else if(type == '2'){

        }else if(type == '3'){

        }else{

        }
      
    },
      getExercise(){
          axios.get("/api/exercise/{{request()->route('id')}}")
          .then((r)=>{
              this.exercises = r.data;
          }).catch((e)=>{
            alert('error: '+e);
          });
      },
      load(){
          this.getExercise();
      },
  },
  mounted(){
      this.load();
  },
});

</script>
@endsection