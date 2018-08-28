<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';}else{
    $id = $_SESSION['user'];
    $linkToCheck ="";
    if(isset($_GET['type'])){
        if($_GET['type'] == "1"){ $linkToCheck="/exercise/check/askanswer/";}
        else if($_GET['type'] == "2"){ $linkToCheck="/exercise/check/choice/";}
        else if($_GET['type'] == "3"){ $linkToCheck="/exercise/check/askfile/";}
        else{ $linkToCheck="#";}
    }
}
 
?> 
@extends('core.vuetify') 
@section('vue')

<v-container grid-list-md>
    <v-layout row wrap>
  
        <v-flex d-flex xs12 sm12>
            <v-card color="">
                <v-toolbar color="indigo" dark>
                    <v-icon @click="backPage()">fas fa-arrow-left</v-icon>
                    <v-toolbar-title>ตรวจแบบฝึกหัด</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-container>
                    <h4 style="color:brown;">
                        <v-icon style="color:brown;">fas fa-exclamation-circle </v-icon>&nbsp;ยังไม่ได้ตรวจ</h4>
                    <div v-for="exercised in exercises">
                        <div v-if="exercised.type != 5">
                            <a :href="'{{$linkToCheck}}'+exercised.id+'?exercise={{request()->route('id')}}'" class="v-btn box-blue wh">
                           @{{JSON.parse(exercised.studentIn.data).StudentCode}}
                          <b>@{{JSON.parse(exercised.studentIn.data).FirstName_TH}}
                            @{{JSON.parse(exercised.studentIn.data).LastName_TH}}</b>
                           <div class="hidden-mobile"> @{{JSON.parse(exercised.studentIn.data).FacultyName_TH}}
                            @{{JSON.parse(exercised.studentIn.data).CourseName_TH}}</div>
                        </a>
                        </div>
                    </div>
                    <v-divider></v-divider>
                    <h4 style="color:green;">
                        <v-icon style="color:green;">fas fa-check-circle</v-icon>&nbsp;ตรวจแล้ว</h4>
                    <div v-for="exercised in exercises">
                        <div v-if="exercised.type == 5">
                            <a href="#" class="v-btn v-btn-success">
                               @{{JSON.parse(exercised.studentIn.data).StudentCode}}
                              <b>@{{JSON.parse(exercised.studentIn.data).FirstName_TH}}
                             @{{JSON.parse(exercised.studentIn.data).LastName_TH}}</b>
                             <div class="hidden-mobile">  @{{JSON.parse(exercised.studentIn.data).FacultyName_TH}}
                                @{{JSON.parse(exercised.studentIn.data).CourseName_TH}}</div>
                            </a>
                            <a href="#" class="v-btn success">@{{exercised.score}} คะแนน</a>
                        </div>
                    </div>
                </v-container>
            </v-card>

        </v-flex>
    </v-layout>
</v-container>
@endsection
 
@section('vue_script')
<script>
    new Vue({
    el:"#app",
    data:{
        exercises:{},
        courses:{},
    },
    methods:{
        backPage(){
            window.location = "/course/profile/"+this.courses;
    },
    getCourseId(){
            let result =  axios.get("/api/course_id/{{request()->route('id')}}")
      .then((r) => {
          this.courses = r.data; 
      }).catch((e) => { 
          alert('error: '+e);
      });
        },
        getExercise(){
            let result =  axios.get("/api/exercised/{{request()->route('id')}}")
      .then((r) => {
          this.exercises = r.data; 
      }).catch((e) => { 
          alert('error: '+e);
      });
        },

        load(){
          this.getExercise();
          this.getCourseId();
        }
    },

    mounted() {
        this.load();
    },
});

</script>
@endsection