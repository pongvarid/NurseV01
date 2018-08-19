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
<v-container >
    <v-layout row>
    <v-flex xs12 sm4  >
        <v-card>
            <v-toolbar color="light-blue" dark>
                <v-toolbar-side-icon><v-icon>fas fa-user-circle</v-icon></v-toolbar-side-icon>
                <v-toolbar-title>สร้างแบบฝึกหัด</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-list two-line subheader>
                <v-divider ></v-divider> 
                <v-subheader>
                    <v-btn color="primary" @click="submit_ask()">ตอบถูกผิด</v-btn>
                    <v-btn color="primary" @click="submit_choice()">เลือกตอบ</v-btn>
                    <v-btn color="primary" @click="submit_edm()">แนบไฟล์</v-btn>
                </v-subheader> 
                <v-divider ></v-divider>
            <div v-for="exercise in exercises">
                <v-subheader >@{{exercise.name}}</v-subheader>
            </div>
            </v-list>
        </v-card>
    </v-flex>
    <v-flex xs12 sm1></v-flex>
    <v-flex xs12 sm8 >
        <v-card>
            <v-toolbar color="light-blue" dark>
                <v-toolbar-side-icon></v-toolbar-side-icon>
                <v-toolbar-title>รายวิชา {{request()->route('id')}}</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
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
    exercises:{}
  },
  methods: { 
    submit_ask(){
        window.location = "/course/exercise/ask_exercise/{{request()->route('id')}}";
    },
    getExercise(){ ////////////////////////
        let result =  axios.get("/api/exercise/{{request()->route('id')}}")
      .then((r) => {
          this.exercises = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
      },
      load(){
       this.getExercise();
      }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection

{{-- {{request()->route('id')}} --}}