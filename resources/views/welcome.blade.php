@extends('templete.vue') 
@section('vue_templete')
<v-layout row justify-center>
    <v-dialog v-model="login_dialog" width="800" transition="dialog-bottom-transition">
           <v-card>
        <v-toolbar dark color="primary"> 
          <v-toolbar-title>เข้าสู่ระบบ</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark flat @click.native="dialog = false">Save</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-layout class="container">
            cs
        </v-layout>
       
      </v-card>
    </v-dialog>
  </v-layout>
@endsection
 
@section('vue_script')
<script src="js/component/home.js"></script>
@endsection