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
            <v-card>
                <v-toolbar color="box-green" dark>
                    <v-icon @click="backPage()">fas fa-arrow-left</v-icon>
                    <v-toolbar-title>กลับ</v-toolbar-title>
                    <v-divider class="mx-2" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-icon>far fa-list-alt</v-icon>
                    <v-toolbar-title>คะแนนแบบฝึกหัด @{{student.FirstName_TH}}&nbsp;@{{student.LastName_TH}}</v-toolbar-title>

                </v-toolbar>
                <v-card-text>
                    <v-data-table :headers="headers" :items="score">
                        <template slot="items" slot-scope="props">   
                        <td>@{{ props.item.name }}</td>
                        <td>@{{ props.item.score }}</td> 
                        <td>@{{ timeconvert(props.item.created_at.split(' ')[0]) }}</td>
                        </template>
                    </v-data-table>
                </v-card-text>
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
    register:{
        student:"{{$_SESSION['student']}}",
        course:"{{request()->route('course')}}",
        permission:1,
    },
    student:{},
    logs:[],
    score:[],
    exercise_score:[],
    headers: [
          { text: 'แบบฝึกหัด', value: 'name', sortable: false, },
          { text: 'คะแนน', value: 'score', sortable: false,},
          { text: 'วันที่ส่ง', value: 'created_at', sortable: false,},
        ],
        data: [],
  },
  methods: { 
    getScore(){
        axios.get("/api/show_score/{{request()->route('course')}}&<?php echo $code?>")
        .then((r)=>{
            this.score = r.data;
        }).catch((e)=>{
            alert('error:'+e);
        })
    },
    timeconvert(time){
          let convertTime = null;
          //ti = moment("20180830", "YYYYMMDD").fromNow();
          //ti = moment().endOf(time).fromNow(); 
          convertTime = moment(time).format('L');
          return convertTime;
      },
    backPage(){
        window.history.back();
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