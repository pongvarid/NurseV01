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
<v-container grid-list-md>
        <v-layout row wrap>
            <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-icon @click="backPage()">fas fa-arrow-left</v-icon>
                    <v-toolbar-title>แก้ไขแบบฝึกหัด แนบไฟล์</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-text-field prepend-icon=" far fa-clipboard " v-model="exercises.name" label="ชื่อแบบฝึกหัด" type="text"></v-text-field>
                    <v-text-field prepend-icon=" fas fa-clipboard-list " v-model="exercises.score" label="คะแนนเต็ม" type="number"></v-text-field>
                    {{-- <v-text-field prepend-icon=" fas fa-calculator " v-model.number="exercises.count" label="จำนวนข้อ" type="number"></v-text-field> --}}
                    <v-text-field prepend-icon=" far fa-comment " v-model="exercises.remark" label="หมายเหตุ" type="text"></v-text-field>
                    <v-text-field prepend-icon=" far fa-calendar-alt " v-model="exercises.time" label="กำหนดส่ง" type="date"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn  color="primary" @click="update()"><v-icon>fas fa-check</v-icon>&nbsp  ยืนยัน</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
 
        <v-flex xs12 sm8>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-toolbar-side-icon></v-toolbar-side-icon>
                    <v-toolbar-title>คำถาม</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text> 
                    <v-text-field v-model="exercises.ask" :label="'คำถาม'" type="text"></v-text-field> 
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>
@endsection
 
@section('vue_script')
<script>
    new Vue({ el: "#app",
    data: {
       perData:{},
       exercises:{
           ask:[],
       },
    },
    methods: {
        backPage(){
            window.location=document.referrer;
    },
        update(){
            let check = this.checkStringAsk();
            this.exercises.ask;
            this.exercises.teacher = "<?php echo $id; ?>";
            this.exercises.event = "แก้ไขแบบฝึกหัด แนบไฟล์";
            let result =  axios.put("/api/exercise/askanswer/{{request()->route('id')}}",this.exercises)
            .then((r) => {
                alert('แก้ไขข้อมูลสำเร็จ');
                this.load();
            }).catch((e) => { 
                alert('error: '+e);
            });
        },
        checkStringAsk(){
        let ask = this.exercises.ask;
        },
        getExercise(){
            let result =  axios.get("/api/exercise/askanswer/{{request()->route('id')}}")
            .then((r) => {
                this.exercises = r.data;
            }).catch((e) => { 
                alert('error: '+e);
            });
        },
        load(){
            this.getExercise(); 
        },
     },
     mounted(){
      this.load();
    },
    });

</script>
@endsection
 {{-- {{request()->route('id')}} --}}