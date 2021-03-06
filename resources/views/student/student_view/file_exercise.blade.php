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

        <v-flex d-flex xs12 sm12>
            <v-card color="">
                <v-toolbar color="indigo" dark>
                    <v-icon @click="backPage()">fas fa-arrow-left</v-icon>
                    <v-toolbar-title> @{{exercise.name}}</v-toolbar-title>
                    <v-spacer></v-spacer>

                </v-toolbar>
                <v-container>
                    <v-alert value="info" type="info">
                        หมายเหตุ: @{{exercise.remark}}
                    </v-alert>

                  
                        <div v-if="index !=0">
                                <h4>ข้อ : @{{index}}</h4>
                                <v-textarea  label="คำถาม" :value="ask" hint="index" readonly></v-textarea>
                                <v-text-field v-model="answer" label="คำตอบ" placeholder="คำตอบข้อ" box></v-text-field>
                   
                    </div>
                    <v-btn style="background-color:#683ECF;" dark block @click="save()"><v-icon>far fa-paper-plane</v-icon>&nbsp ส่งคำตอบ</v-btn>
                </v-container>
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
      exercise:{ 
          ask:[],
      },
      ask:{},
      answer:[],
      answerData:{},
  },
  methods: { 
    backPage(){
            window.location=document.referrer;
    },
    preData(){
        this.answerData.course = "{{request()->route('id')}}";
        this.answerData.type = '3'; 
        this.answerData.student = "{{$code}}";
        this.answerData.event = "ส่งแบบฝึกหัด แนบไฟล์";
        this.answerData.score = '0'; 
        this.answerData.answer = this.answer.toString(); 
    },
    save(){
        this.preData();
        axios.post("/api/exercise/do/askanswer",this.answerData)
      .then((r) => {
 alert('ส่งงานสำเร็จ');
 window.location=document.referrer;
      }).catch((e) => { 
          alert('error');
      });
    },
     load(){
        axios.get("/api/exercise/do/askanswer/{{request()->route('id')}}")
      .then((r) => {
          this.exercise = r.data;
          this.ask =  r.data.ask;
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