@extends('templete.vue') 
@section('vue_templete')
<v-layout row justify-center>
    <v-dialog v-model="login_dialog" width="500" transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar dark color="primary">
                <v-toolbar-title><img src="http://www.up.ac.th/img/logo/building_logo.png" style="width:60px;" alt="">เข้าสู่ระบบ</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn dark flat @click.native="dialog = false">Save</v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-layout class="container">
                <v-flex xs12>
                        <form action="" method="post">
                                <v-text-field label="ชื่อผู้ใช้ (Username)"></v-text-field>
                                <v-text-field label="รหัสผ่าน (Password)"></v-text-field>
                                <v-btn><v-icon>fas fa-sign-in-alt</v-icon>&nbsp;เข้าสู่ระบบ</v-btn>
                            </form>
                </v-flex>
              
            </v-layout>

        </v-card>
    </v-dialog>
</v-layout>
@endsection
 
@section('vue_script')
<script src="js/component/home.js"></script>
@endsection