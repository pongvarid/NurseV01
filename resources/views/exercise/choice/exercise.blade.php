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
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-toolbar-side-icon>
                        <v-icon>fas fa-user-circle</v-icon>
                    </v-toolbar-side-icon>
                    <v-toolbar-title>แบบฝึกหัด</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-text-field prepend-icon=" far fa-clipboard " v-model="exercise.name" label="ชื่อแบบฝึกหัด" type="text"></v-text-field>
                    <v-text-field prepend-icon=" fas fa-clipboard-list " v-model="exercise.score" label="คะแนนเต็ม" type="number"></v-text-field>
                    <v-text-field prepend-icon=" fas fa-calculator " v-model.number="exercise.count" mask="##" label="จำนวนข้อ" type="tel"></v-text-field>
                    <v-text-field prepend-icon=" far fa-comment " v-model="exercise.remark" label="หมายเหตุ" type="text"></v-text-field>
                    <v-text-field  prepend-icon=" far fa-calendar-alt " v-model="exercise.time" label="กำหนดส่ง" type="date"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="save()">ยื่นยัน</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
        <v-flex xs12 sm1></v-flex>
        <v-flex xs12 sm8>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-toolbar-side-icon></v-toolbar-side-icon>
                    <v-toolbar-title>คำถาม</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text v-for="x in exercise.count">
                    <v-text-field  v-model="exercise.ask[x]" :label="'ข้อ'+x" type="text"></v-text-field>
                    <v-select
                    v-model="choices.answer[x]"
                    :items="answer"
                    label="เฉลย"
                    solo
                  ></v-select>
                    <v-text-field v-model="choices.a[x]" label="a:" type="text"></v-text-field>
                    <v-text-field v-model="choices.b[x]" label="b:" type="text"></v-text-field>
                    <v-text-field v-model="choices.c[x]" label="c:" type="text"></v-text-field>
                    <v-text-field v-model="choices.d[x]" label="d:" type="text"></v-text-field>
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
        answer:['a','b','c','d'],
        choices:{
            a:[],
            b:[],
            c:[],
            d:[],
            answer:[],
        },
        exercise:{  
            ask:[],
            answer:[],
        },
    },
    methods: {
        preData(){
            this.exercise.ask = this.exercise.ask.toString();
            this.choiceMake();
            this.exercise.type = 2;
            this.exercise.course = "{{request()->route('id')}}";
        },
        choiceMake(){
            let choiceTmp = '';
            for(let i=0; i<=this.exercise.count;i++){
                if(i==0){continue;}
                let mert_choice = "<choice>"+this.choices.a[i]+","+this.choices.b[i]+","+this.choices.c[i]+","+this.choices.d[i]+"<choice>";
                choiceTmp+=mert_choice;
            }
            let answer_choice = '<answer>'+this.choices.answer.toString(); 
            choiceTmp+=answer_choice;
            this.exercise.answer = choiceTmp;

        },
        save(){
            this.preData();
            console.log(this.choices.answer);
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