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
                    <v-toolbar-title>สร้างแบบฝึกหัด แนบไฟล์</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-text-field prepend-icon=" far fa-clipboard " v-model="exercise.name" label="ชื่อแบบฝึกหัด" type="text"></v-text-field>
                    <v-text-field prepend-icon=" fas fa-clipboard-list " v-model="exercise.score" label="คะแนนเต็ม" type="number"></v-text-field>
                    <v-text-field prepend-icon=" far fa-comment " v-model="exercise.remark" label="หมายเหตุ" type="text"></v-text-field>
                    <v-text-field prepend-icon=" far fa-calendar-alt " v-model="exercise.time" label="กำหนดส่ง" type="date"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="save()"><v-icon>fas fa-check</v-icon>&nbsp ยืนยัน</v-btn>

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
                    <v-text-field hint="ห้ามกรอกเครื่องหมาย , เด็ดขาด" persistent-hint  v-model="exercise.ask" :label="'คำถาม'" type="text"></v-text-field>
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
        exercise:{
            ask:[],
            answer:[],
        },
    },
    methods: {
        backPage(){
            window.location=document.referrer;
    },
        preData(){
            this.exercise.ask = this.exercise.ask.toString();
            //this.choiceMake();
            this.exercise.type = 3;
            this.exercise.course = "{{request()->route('id')}}";
            this.exercise.answer = "No answer";
        },
        save(){
            this.preData();
            //console.log(this.choices.answer);
            this.exercise.teacher = "<?php echo $id; ?>";
            this.exercise.event = "สร้างแบบฝึกหัด แนบไฟล์";
            axios.post("/api/exercise",this.exercise)
            .then(function(response) { 
                if(response.data == '1'){
                    alert('บันทึกแบบฝึกหัดเรียบร้อย');
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