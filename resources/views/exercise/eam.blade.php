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
  <div id="app">
    <v-app>
      <v-content>
        <v-container>
            <v-layout row>
            <v-flex xs12 sm4>
              <v-card>
                <v-toolbar dark color="primary">
                  <v-toolbar-title>แบบฝึกหัดตอบถูกผิด</v-toolbar-title>
                  <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                <form>
                    @csrf
                    <v-text-field v-model="exercise.name"  label="ชื่อแบบฝึกหัด" type="text" ></v-text-field>
                    <v-text-field v-model.number="count"  label="จำนวนข้อ" type="number" ></v-text-field>
                    <v-text-field v-model.number="pera"  label="คะแนนเต็ม" type="number" ></v-text-field>
                    <v-text-field v-model.number="per"  label="คิดเป็นเปอร์เซ็น" type="number"></v-text-field>
                    <v-text-field v-model="date"  label="กำหนดส่ง" type="date"></v-text-field>
                  </v-card-text> 
                  <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" :disabled="!valid" @click="submit()">ยื่นยัน</v-btn>
                      </form>
                </v-card-actions>
            </v-card>
        </v-flex>
            <v-flex xs12 sm1></v-flex>
            <v-flex xs12 sm8 >
                <v-card>
                    <v-toolbar dark color="primary">
                      <v-toolbar-title>คำถาม</v-toolbar-title>
                      <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                    <form >
                        @csrf
                        <v-text-field v-for="x in count" v-model="ask[x]" :label="'ข้อ'+x" type="text" ></v-text-field>
                      </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                    </form>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        </v-container>
      </v-content>
  </v-app>
  </div>

@endsection 
@section('vue_script')
  <script>
    new Vue({ el: '#app',
    data:{
        valid: true,
        per:null,
        date:null,
        pera:null,
        count:this.count,
        ask:[],
        exercise:{

        },
    },
    methods: {
        submit () {
        axios.post("<?=env('link');?>/api/exercise",this.exercise)
      .then(function(response) { 
        if(response.data == '1'){
            window.location = "<?=env('link');?>/course/profile/{{request()->route('id')}}";
        }else{
      
        } 
      })
      .catch(function(error) {
     
      });
      },

    }
    
    })
  </script>

@endsection