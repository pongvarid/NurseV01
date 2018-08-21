<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';}else{
    $id = $_SESSION['user'];
}
 
?> 
@extends('core.vuetify') 
@section('vue')
<v-container>
    <v-layout row>
        <v-flex xs12 sm4>
            <v-btn @click="document()">จัดการเอกสาร</v-btn>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-toolbar-side-icon>
                        <v-icon>fas fa-user-circle</v-icon>
                    </v-toolbar-side-icon>
                    <v-toolbar-title>สร้างแบบฝึกหัด</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-list two-line subheader>
                    <v-divider></v-divider>
                    <v-subheader>
                        <v-btn color="primary" @click="submit_ask()">ตอบถูกผิด</v-btn>
                        <v-btn color="primary" @click="submit_choice()">เลือกตอบ</v-btn>
                        <v-btn color="primary" @click="submit_edm()">แนบไฟล์</v-btn>
                    </v-subheader>
                    <v-divider></v-divider>
                    <div v-for="exercise in exercises">
                        <v-list-tile >
                            <v-list-tile-content>
                                <v-layout style="width:100%;" row>
                                    <v-flex xs12 @click="goto_editExercisePage(exercise.id,exercise.type)">
                                            <v-list-tile-title class="mrt-10 pointer">@{{exercise.name}} @{{getExerciseType(exercise.type)}} </v-list-tile-title>

                                    </v-flex>
                                    <v-flex xs1>
                                            <v-btn style="float:right;" @click="deleteExercise(exercise.id)" icon color="red" dark>
                                                    <v-icon>fas fa-times</v-icon>
                                                </v-btn>
                                    </v-flex>
                                </v-layout>
                             
                            </v-list-tile-content>
                        
                        </v-list-tile>
                 
                    </div>
                </v-list>
            </v-card>
        </v-flex>
        <v-flex xs12 sm1></v-flex>
        <v-flex xs12 sm8>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-toolbar-side-icon></v-toolbar-side-icon>
                    <v-toolbar-title>รายวิชา @{{courses.name}} [@{{courses.code}}]</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-divider></v-divider>
                <v-btn color="warning" @click="edit_course()">แก้ไข</v-btn>
                <v-btn color="red" @click="close_course()" dark>ปิด
                    <v-icon dark right>block</v-icon>
                </v-btn>
                <v-divider></v-divider>
                <v-list two-line subheader>
                    <pre>
                    @{{courses}}
                </pre>
                </v-list>
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
    courses:{},
    close:{
        state:0,
    },
  },
  methods: { 

    deleteExercise(id){ 
        let deletes = confirm("คุณแน่ใจใช่ไหมที่จะลบข้อมูล");
        if(deletes){
        axios.delete("/api/exercise/"+id)
      .then((r) => { 
        alert("ลบข้อมูลแบบฝึกหัดสำเร็จ");
      }).catch((e) => { 
          alert('error: '+e);
      });
      this.load();}
    },
    submit_ask(){ //สร้างแบบฝึกหัดตอบถูกผิด
        window.location = "/course/exercise/ask_exercise/{{request()->route('id')}}";
    },
    submit_choice(){
        window.location = "/course/exercise/choice/{{request()->route('id')}}";
    },
    goto_editExercisePage(id,type){ //แก้ไขแบบฝึกหัดตอบถูกผิด
        if(type == '1'){
            window.location = "/course/exercise/edit_ask/"+id;
        }else if(type == '2'){
            window.location = "/course/exercise/choice_edit/"+id;
        }else if(type == '3'){

        }else{

        }
      
    },
    getExerciseType(type){
        if(type == '1'){
            return "(แบบ ถาม-ตอบ)";
        }else if(type == '2'){
            return "(แบบ เลือกข้อถูก)";
        }else if(type == '3'){
            return "(แบบ สั่งงาน)";
        }else{
            return "(อื่นๆ)";
        }
    },
    document(){
        window.location = "/course/document/{{request()->route('id')}}";
    },
    edit_course(){ //แก้ไขรายวิชา
        window.location = "/course/edit_course/{{request()->route('id')}}";
    },
    close_course(){ //ปิดรายวิชา
        axios.put("/api/close_course/{{request()->route('id')}}",this.close)
        .then((r) => {
            alert('ปิดรายวิชาเรีบยร้อยแล้ว');
            window.location = "/teacher/profile/";
        }).catch((e) => {
            alert('error: '+e);
        });
        this.load();
    },
    getCourse(){ //ดึงข้อมูลรายวิชา
        let result =  axios.get("/api/course_data/{{request()->route('id')}}")
      .then((r) => {
          this.courses = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
      },
    getExercise(){ //ดึงข้อมูลแบบฝึกหัด
        let result =  axios.get("/api/exercise/{{request()->route('id')}}")
      .then((r) => {
          this.exercises = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
      },
      load(){
       this.getExercise();
       this.getCourse();
      }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection
 {{-- {{request()->route('id')}} --}}