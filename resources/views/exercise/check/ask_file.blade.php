<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
 
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
                        / คะแนนเต็ม: @{{exercise.score}} คะแนน
                    </v-alert>
                    <div>
                        <h4>ข้อ : 1</h4>
                        <v-textarea label="คำถาม" :value="exercise.ask" hint="index" readonly></v-textarea>
                        <v-text-field v-model="answer" label="คำตอบ" :placeholder="'คำตอบข้อ 1'" readonly></v-text-field>
                        <v-text-field oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" v-model="score"
                            label="คะแนน" :placeholder="'คำตอบข้อ 1'" box></v-text-field>
                    </div>
                    <v-btn @click="save()">บันทึกคะแนน</v-btn>
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
      score:[],
      answer:[],
      answerData:{},
  },
  methods: { 
    backPage(){
            window.location=document.referrer;
    },
    preData(){
        this.answerData.type = '5';  
    },
    countScore(){
        let tmpScore = 0; 
        tmpScore+=Number(this.score);
        console.log(tmpScore);
        return tmpScore;
    },
    save(){
        this.preData();
       if(Number(this.countScore()) > Number(this.exercise.score)){
           alert("คะแนนเกินกว่าที่กำหนดไว้คะ");
       }else{
           let onCheck = confirm('คุณแน่ใจใช่ไหมที่จะให้คะแนน' + this.countScore()+"/"+this.exercise.score);
            if(onCheck){
                this.answerData.score = this.countScore();
                axios.put("/api/exercised/{{request()->route('id')}}",this.answerData)
                    .then((r) => { 
                        alert('ตรวจสำเร็จ');   
                        window.location=document.referrer;
                    }).catch((e) => { 
                        alert('error');
                    });
            }
       }
    },
    getAnswer(){
        axios.get("/api/exercised/{{request()->route('id')}}/edit")
      .then((r) => { 
          this.answer =  r.data.answer.split(",");
      }).catch((e) => { 
          alert('error');
      });
    },

    getAsk(){
        axios.get("/api/exercise/do/askanswer/{{$_GET['exercise']}}")
      .then((r) => {
          this.exercise = r.data;
          this.ask =  r.data.ask.split(",");
      }).catch((e) => { 
          alert('error');
      });
    },

     load(){
        this.getAsk();
        this.getAnswer();
     }
  },
  mounted(){
    this.load(); 
  }
});

</script>
@endsection