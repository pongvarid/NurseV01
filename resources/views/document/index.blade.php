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
    <v-app id="inspire">
        <div>
            <v-layout row justify-center>
                <v-btn color="primary" dark @click.stop="dialog = true">เพิ่มเอกสารประกอบการสอน</v-btn>
                <v-dialog v-model="dialog" width="500" transition="dialog-bottom-transition" scrollable>
                    <v-card tile>
                        <v-toolbar card dark color="primary">
                            <v-btn icon dark @click.native="dialog = false">
                                <v-icon>close</v-icon>
                            </v-btn>
                            <v-toolbar-title>เพิ่มเอกสารประกอบการสอน</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn dark flat v-if="!update" @click="saveData()">บันทึก</v-btn>
                                <v-btn dark flat v-if="update" @click="updateData()">บันทึก</v-btn>
                            </v-toolbar-items>
                        </v-toolbar>
                        <v-card-text>
                            <v-form v-model="valid">
                                <v-text-field v-model="dataDB.name" :rules="nameRules" label="ชื่อเอกสาร" required></v-text-field>
                                <v-text-field v-model="dataDB.remark" :rules="remarkRules" label="รายละเอียดเอกสาร" required></v-text-field>
                                <v-text-field v-model="dataDB.link" :rules="linkRules" label="ที่อยู่ไฟล์เอกสาร" hint="ตัวอย่าง https://drive.google.com"
                                    persistent-hint required></v-text-field>
                            </v-form>
                            <v-divider></v-divider>
                        </v-card-text>
                        <div style="flex: 1 1 auto;"></div>
                    </v-card>
                </v-dialog>
            </v-layout>
        </div>
    </v-app>
    <div v-for="data in tmp">
        <div>
            <pre>@{{data}}</pre>
            <v-btn color="red" @click="deleteData(data.id)">delete</v-btn>
            <v-btn color="blue" @click="updateOpen(data)">update</v-btn>
        </div>
    </div>
</div>
@endsection
 
@section('vue_script')
<script>
    new Vue({
        el: '#app',
        data:{
            valid: false,
            name: '',
            nameRules: [
            v => !!v || 'กรุณากรอกชื่อเอกสาร'
            ],
            remark: '',
            remarkRules: [
            v => !!v || 'กรุณากรอกรายละเอียด'
            ],
            link: '',
            linkRules: [
            v => !!v || 'กรุณากรอกที่อยู่เอกสาร'
            ],
            tmp: [],
            dataDB:{},
            update:false,
            dialog: false,
            },
            methods: { 
                dialogClose(){
                    this.dataDB = {};
                    this.update = false;
                    this.dialog = false;
                    this.load();
                },
                updateOpen(tmp){
                    this.update = true;
                    this.dialog = true;
                    this.dataDB = tmp;
                },
                deleteData(id){
                    var confirms = confirm("คุณแน่ใจใช่ไหม ที่จะลบข้อมูล");
                    if(confirms){
                        axios
                .delete("/api/document/"+id)
                .then(function(response) {
                    alert('ลบข้อมูลสำเร็จ'); 
                })
                .catch(function(error) {
                    alert('error');
                });
                this.dialogClose(); 
                    }
                },
                updateData(){
                    axios
                .put("/api/document/"+this.dataDB.id,this.dataDB)
                .then(function(response) {
                    alert('แก้ไขข้อมูลสำเร็จ'); 
                })
                .catch(function(error) {
                    alert('error');
                });
                this.dialogClose(); 
                },
                saveData(){
                    this.dataDB.course = "{{request()->route('id')}}";
                    axios
                .post("/api/document",this.dataDB)
                .then(function(response) {
                    alert('บันทึกข้อมูลสำเร็จ');
                })
                .catch(function(error) {
                    alert('error');
                });
                this.dialogClose(); 
                },
                load(){
                    let result = axios.get("/api/document/{{request()->route('id')}}") 
                .then((r) => {
                    this.tmp = r.data;  
                }).catch((e) => { 
                    alert('error');
                });
                },
            },
            mounted(){
                this.load();
            }
            })

</script>
@endsection