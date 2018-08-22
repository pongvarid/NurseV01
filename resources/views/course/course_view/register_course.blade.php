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
    <v-btn v-if="dataCheck==1" color="success" @click="submit_register()" large block>ลงทะเบียนเรียน</v-btn><br>
    <v-layout row wrap>
        <v-flex d-flex>
            <v-card color="">
                <v-toolbar color="indigo" dark>
                    <v-icon>fas fa-user-circle </v-icon>
                    <v-toolbar-title>ข้อมูลรายวิชา @{{courses.name.split(',')[1]}} (@{{courses.name.split(',')[2]}}) [@{{courses.code}}]</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.name.split(',')[1]" label="ชื่อรายวิชา" outline append-icon="place" readonly></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.code" label="รหัสรายวิชา" outline append-icon="place" readonly></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.year" label="ปีการศึกษา" outline append-icon="place" readonly></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="teacher.name" label="อาจารย์" outline append-icon="place" readonly></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.created_at" label="วันที่เปิดรายวิชา" outline append-icon="place" readonly></v-text-field>
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
                        <v-btn large color="primary" block>@{{document.name}}</v-btn>
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
                            <v-list-tile>
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
   teacher:{},
   exercises:{},
   dataCheck:1,
   documents:{},
   register:{
     student:"{{$_SESSION['student']}}",
     course:"{{request()->route('id')}}",
     permission:1,
   },
  },
  methods: {
      check(){
        axios.get("/api/check?student={{$_SESSION['student']}}&course={{request()->route('id')}}")
        .then((r)=>{
            this.dataCheck = r.data;
          
        }).catch((e)=>{

        });
      },
      getDocument(){
        let result = axios.get("/api/document_data/{{request()->route('id')}}")
        .then((r)=>{
          this.documents = r.data;
        }).catch((e)=>{
          alert('error: '+e);
        });
    },
      submit_register(){
        axios.post("/api/course_in",this.register)
      .then(function(response) { 
        if(response.data == '1'){
            alert("ลงทะเบียนเรียนเรียบร้อยแล้ว");
        }   
      })
      .catch(function(error) {
        alert('error: '+e);
      });this.load();
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
      getTeacher(){
        let result = axios.get("/api/teacher/{{request()->route('id')}}")
        .then((r)=>{
          this.teacher = r.data;
        }).catch((e)=>{
          alert('error: '+e);
        });
      },
      load(){
        this.getTeacher();
        this.getCourse();
        this.getExercise();
        this.check();
        this.getDocument();
      },
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection