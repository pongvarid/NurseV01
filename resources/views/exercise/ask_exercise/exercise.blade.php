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
                <v-toolbar-title>แบบฝึกหัด</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
                    <v-text-field v-model="exercise.name"  label="ชื่อแบบฝึกหัด" type="text" ></v-text-field>
                    <v-text-field v-model="exercise.score"  label="คะแนนเต็ม" type="number"></v-text-field>
                    <v-text-field v-model.number="exercise.count"  label="จำนวนข้อ" type="number"></v-text-field>
                    <v-text-field v-model="exercise.remark"  label="หมายเหตุ" type="text"></v-text-field>
                    <v-text-field v-model="exercise.time"  label="กำหนดส่ง" type="date"></v-text-field>
            </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" @click="save()">ยื่นยัน</v-btn>

                </v-card-actions>
        </v-card>
    </v-flex>
    <v-flex xs12 sm1></v-flex>
    <v-flex xs12 sm8 >
        <v-card>
            <v-toolbar color="light-blue" dark>
                <v-toolbar-side-icon></v-toolbar-side-icon>
                <v-toolbar-title>คำถาม</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>  
            <v-card-text>
                <v-text-field v-for="x in exercise.count" v-model="exercise.ask[x]"  :label="'ข้อ'+x" type="text" ></v-text-field>
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
        ask:[],
        exercise:{  
            ask:[],
        },
    },
    methods: {
        preData(){
            this.exercise.ask = this.exercise.ask.toString();
            this.exercise.type = 1;
            this.exercise.answer = 'ไม่มีเฉลย';
            this.exercise.course = "{{request()->route('id')}}";
        },
        save(){
            this.preData();
            axios.post("/api/exercise",this.exercise)
            .then(function(response) { 
                if(response.data == '1'){
                    alert('บันทึกรายวิชาเรียบร้อย');
                    window.location = "/course/profile/{{request()->route('id')}}";
                }else{
                    alert('error');
                } 
            })
            .catch(function(error) {
                alert('error: '+error);
            });
        },
     },
    });

</script>
@endsection

{{-- {{request()->route('id')}} --}}