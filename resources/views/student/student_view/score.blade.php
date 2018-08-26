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
        <v-flex>
            @{{score}}
        </v-flex>
    </v-layout>
</v-container>
@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {
    register:{
        student:"{{$_SESSION['student']}}",
        course:"{{request()->route('course')}}",
        permission:1,
    },
    student:{},
    logs:[],
    score:{},
    headers: [
          { text: 'แบบฝึกหัด', value: 'event', sortable: false, },
          { text: 'คะแนน', value: 'date', sortable: false,},
        ],
        exercised: {  },
  },
  methods: { 
    getScore(){
        axios.get("/api/score/{{request()->route('course')}}")
        .then((r)=>{
            this.score = r.data;
        }).catch((e)=>{
            alert('error:'+e);
        })
    },
    load(){
        let result =  axios.get('/api/student/data/<?php echo $id; ?>')
      .then((r) => {
          this.student = r.data;
      }).catch((e) => { 
          alert('error');
      });
        this.getScore();
    }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection