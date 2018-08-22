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
        <v-flex d-flex xs12 sm12 class="container">
            <v-layout row wrap>
                <v-flex d-flex>
                    <v-card>
                        <v-toolbar color="indigo" dark>
                            <v-icon>fas fa-align-justify </v-icon>
                            <v-toolbar-title>จัดการเอกสาร</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" dark @click.stop="dialog = true">
                                <v-icon>add</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <v-container fluid grid-list-lg>
                                <v-layout row wrap>
                                    <template v-for="data in tmp">
                                            <v-flex d-flex xs12 sm4>
                                              <v-card color="w3-container w3-light-grey darken-2" class="white--text">
                                                <v-card-title primary-title>
                                                  <div>
                                                      <div class="headline">ชื่อเอกสาร: @{{data.name}}</div>
                                                      <div>รายละเอียด: @{{data.remark}}</div>
                                                      <br>
                                                    </div>
                                                    <div class="text-xs-center d-flex align-center">
                                                    <v-btn 
                                                        color="success"
                                                        class="white--text" 
                                                        @click="openLink(data)"
                                                        >เปิด<v-icon right dark>call_to_action</v-icon>
                                                    </v-btn> 
                                                    <v-btn
                                                        color="warning"
                                                        class="white--text"
                                                        @click="updateOpen(data)"
                                                        >แก้ไข<v-icon right dark>edit</v-icon>
                                                    </v-btn>
                                                    <v-btn
                                                        color="error"
                                                        class="white--text"
                                                        @click="deleteData(data.id)"
                                                        >ลบ<v-icon right dark>delete</v-icon>
                                                    </v-btn>
                                            </div>
                                            </v-card-title>
                                              </v-card>
                                            </v-flex>
                                          </template>
                                </v-layout>
                            </v-container>

                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>
        <div>
            <v-layout row justify-center>
                <v-dialog v-model="dialog" width="500" transition="dialog-bottom-transition" scrollable>
                    <v-card tile>
                        <v-toolbar card dark color="primary">
                            <v-btn icon dark @click="dialogClose()">
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
                                <v-text-field prepend-icon="fas fa-paste" v-model="dataDB.name" :rules="nameRules" label="ชื่อเอกสาร" required></v-text-field>
                                <v-text-field prepend-icon="far fa-file" v-model="dataDB.remark" :rules="remarkRules" label="รายละเอียดเอกสาร" required></v-text-field>
                                <v-text-field prepend-icon="far fa-paper-plane" v-model="dataDB.link" :rules="linkRules" label="ที่อยู่ไฟล์เอกสาร" hint="ตัวอย่าง https://drive.google.com"
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
                openLink(tmp) {
                    this.dataDB = tmp;
                    window.open(this.dataDB.link, '_blank');
                }
            },
            mounted(){
                this.load();
            }
            })

</script>
@endsection