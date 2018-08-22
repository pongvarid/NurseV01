
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
                    <v-icon>fas fa-user-circle </v-icon>
                    <v-toolbar-title> @{{exercise.name}}</v-toolbar-title>
                    <v-spacer></v-spacer>

                </v-toolbar>
                <v-container>
                    <v-alert value="info" type="info">
                        @{{exercise.remark}}
                    </v-alert>

                    <div v-for="asks,index in ask">
                        <div v-if="index !=0">
                                <h4>ข้อ : @{{index}}</h4>
                                <v-textarea  label="คำถาม" :value="asks" hint="index" readonly></v-textarea>
                                <v-text-field  :label="'(A) '+answer[index].split(',')"  box></v-text-field>
                                <v-text-field  label="B"  box></v-text-field>
                                <v-text-field  label="C"  box></v-text-field>
                                <v-text-field  label="D"  box></v-text-field>

                                <v-text-field v-model="answer[index]" label="คำตอบ" :placeholder="'คำตอบข้อ '+index" box></v-text-field>
                        </div> 
                    </div>
                    <v-btn @click="save()">ส่งคำตอบ</v-btn>
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
    preData(){
        this.answerData.course = "{{request()->route('id')}}";
        this.answerData.type = '2'; 
        this.answerData.student = '{{$_SESSION["student"]}}'; 
        this.answerData.score = '0'; 
        this.answerData.answer = this.answer.toString(); 
    },
    save(){
        this.preData();
        axios.post("/api/exercise/do/askanswer",this.answerData)
      .then((r) => {
 alert('ส่งานสำเร็จ');
      }).catch((e) => { 
          alert('error');
      });
    },
     load(){
        axios.get("/api/exercise/do/choice/{{request()->route('id')}}")
      .then((r) => {
          this.exercise = r.data;
          this.ask =  r.data.ask.split(",");
          this.answer = r.data.answer;
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