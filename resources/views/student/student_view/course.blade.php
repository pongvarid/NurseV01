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
<v-container grid-list-md>
    <v-layout row wrap>
        <v-flex d-flex>
            <v-card color="">
                <v-toolbar color="indigo" dark>
                    <v-icon>fas fa-user-circle </v-icon>
                    <v-toolbar-title>ข้อมูลรายวิชา @{{courses.name}} [@{{courses.code}}]</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    {{-- <pre>@{{courses}}</pre> --}}
                    <v-layout row wrap>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.name"  label="ชื่อรายวิชา" box disabled></v-text-field>             
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.code"  label="รหัสรายวิชา" box disabled></v-text-field>             
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.year"  label="ปีการศึกษา" box disabled></v-text-field>             
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.teacher"  label="อาจารย์" box disabled></v-text-field>             
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.created_at"  label="วันที่เปิดรายวิชา" box disabled></v-text-field>             
                        </v-flex>
                       
                    </v-layout>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
    <br>
    <v-layout row wrap>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="indigo" dark>
                    <v-toolbar-title>ข้อมูลเอกสาร</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <div v-for="document in documents">
                        <v-btn  large color="primary" block>@{{document.name}}</v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="indigo" dark>
                    <v-toolbar-title>ข้อมูลแบบฝึกหัด</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-card-text>
                            <div v-for="exercise in exercises">
                                    <v-list-tile avatar @click="goto_exercisePage(exercise.id,exercise.type)">
                                        <v-list-tile-content>
                                            <p class="headline mb-0">@{{exercise.name}}</p>
                                            <div>@{{exercise.time}}</div> 
                                        </v-list-tile-content>
                                    </v-list-tile>
                                <v-divider></v-divider>
                            </div>
                    </v-card-text>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="indigo" dark>
                    <v-toolbar-title>นิสิตที่ลงเรียน</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>

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
   courses:{},
   exercises:{},
   dataCheck:1,
   register:{
     student:"{{$_SESSION['student']}}",
     course:"{{request()->route('id')}}",
     permission:1,
   },
   documents:{},
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
    getDocument(){
        let result = axios.get("/api/document_data/{{request()->route('id')}}")
        .then((r)=>{
          this.documents = r.data;
        }).catch((e)=>{
          alert('error: '+e);
        });
    },
      getCourse(){
        let result = axios.get("/api/course_data/{{request()->route('id')}}")
        .then((r)=>{
          this.courses = r.data;
        }).catch((e)=>{
          alert('error: '+e);
        });
      },
      load(){
        this.getCourse();
      },
      getExercise(){
        let result = axios.get("/api/exercise_data/{{request()->route('id')}}")
        .then((r)=>{
          this.exercises = r.data;
        }).catch((e)=>{
          alert('error: '+e);
        });
      },
      load(){
        this.getCourse();
        this.getExercise();
        this.getDocument();
      },
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection

