 
@extends('core.vuetify') 
@section('vue')
 
    <v-layout row justify-center>
        <v-dialog v-model="login_dialog" width="500" transition="dialog-bottom-transition" persistent>
            <v-card>
                <v-toolbar dark color="primary">
                    <v-toolbar-title>
                        <v-layout row>
                            <v-flex xs4>
                                <img src="http://up.ac.th/img/logo/building_logo.png" alt="" width="48">
                            </v-flex>
                            <v-flex class="mrl-6 mrt-10" xs12>
                                <h3 class="nm" v-if="register == true">สมัครสมาชิกสำหรับอาจารย์</h3>
                                <h3 class="nm" v-if="register == false">เข้าสู่ระบบ</h3>
                            </v-flex>
                        </v-layout>
                    </v-toolbar-title>

                </v-toolbar>
                <v-layout class="container" v-if="register!=true">
                    <v-flex xs12>
                        <form>
                            <v-text-field v-model="login.username" label="ชื่อผู้ใช้ (Username)" required></v-text-field>
                            <v-text-field v-model="login.password" type="password" label="รหัสผ่าน (Password)" required></v-text-field>
                            <v-checkbox label="อาจารย์" v-model="teacher_user"></v-checkbox>
                            <v-btn @click="loginGo()">
                                <v-icon>fas fa-sign-in-alt</v-icon>&nbsp;เข้าสู่ระบบ (Login)</v-btn>
                        </form>
                        <div class="card-border violet pd-10 mrt-10" style="width:100%;">
                            <v-layout row>
                                <v-flex xs2>
                                    <v-icon class="mrt-20 mrl-8" style="font-size:40px;">fas fa-info-circle </v-icon>
                                </v-flex>
                                <v-flex xs10>
                                    <p class="mrt-10">
                                        <b>สำหรับนิสิต</b> ใช้ Username และ Password ที่ได้จากมหาวิทยาลัยพะเยา<br>
                                        <b>สำหรับอาจารย์</b> ต้องสมัครสมาชิกก่อนจึงจะสามารถเข้าใช้งานได้ <a @click="register = true">สมัครสมาชิก</a>
                                    </p>
                                </v-flex>
                            </v-layout>
                        </div>
                    </v-flex>

                </v-layout>

                <v-layout class="container" v-if="register==true">
                    <v-flex xs12>
                        <form>

                            <v-text-field v-model="reg.username" label="ชื่อผู้ใช้ (Username)" required></v-text-field>
                            <p style="color:green;" v-if="state_username == 0">ชื่อผู้ใช้นี้ใช้งานได้</p>
                            <p style="color:red;" v-if="state_username == 1">มีชื่อผู้ใช้นี้แล้ว</p>
                            <v-btn @click="checkUser()">ตรวจสอบชื่อผู้ใช้</v-btn>
                            <v-text-field v-model="reg.password" type="password" label="รหัสผ่าน (Password)" required></v-text-field>
                            <v-text-field v-model="reg.name" type="text" label="ชื่อ-สกุล (Name-Surname)" required></v-text-field>
                            <v-textarea v-model="reg.remark" type="text" label="เกี่ยวกับคุณ (About you) บอกนิสิตเกี่ยวกับตัวคุณ "></v-textarea>
                            <v-btn @click="registerStore()" v-if="state_username != 1 && state_username != 3 ">
                                <v-icon>fas fa-user-plus </v-icon>&nbsp;สมัครสมาชิก (Login)</v-btn>
                        </form>
                        <div class="card-border violet pd-10 mrt-10" style="width:100%;">
                            <v-layout row>
                                <v-flex xs2>
                                    <v-icon class="mrt-10 mrl-8" style="font-size:40px;">fas fa-sign-in-alt </v-icon>
                                </v-flex>
                                <v-flex xs10>
                                    <p class="mrt-10">
                                        <a @click="register = false">กลับไปยังหน้าเข้าสู่ระบบ</a>
                                    </p>
                                </v-flex>
                            </v-layout>
                        </div>
                    </v-flex>

                </v-layout>

            </v-card>
        </v-dialog>
    </v-layout>
@endsection
 
@section('vue_script')
    <script>
        new Vue({
  el: "#app",
  data: {
   
    state_username:3,
    register:false,
    teacher_user: 0,
    login_dialog: true,
    reg:{},
    login:{}
  },
  methods: {
    
    loginGo() {
      if (this.teacher_user == "1") { 
        axios
      .post("<?=env('link');?>/api/check/teacher/login",this.login)
      .then(function(response) { 
        if(response.data == '1'){
            window.location = "<?=env('link');?>/teacher/profile";
        }else{
      
        } 
      })
      .catch(function(error) {
     
      });

      } else {
        alert('Hello Student');
        axios
      .post("<?=env('link');?>/api/check/student/login",this.login)
      .then(function(response) { 
        if(response.data == '1'){
            window.location = "<?=env('link');?>/student/profile";
        }else{
      
        } 
      })
      .catch(function(error) {
     
      });
        
      }
    },
 
    checkUser(){ 
        if(this.reg.username != null && this.reg.username != ''){
        let result =  axios.get('<?=env('link');?>/api/check/teacher/' + this.reg.username)
      .then((r) => {
          this.state_username = r.data;
      }).catch((e) => { 
          alert('error');
      });}else{
        this.state_username = 3;
          alert('กรุณาระบุชื่อผู้ใช้');
      }
    },
    registerStore(){
        axios
      .post("<?=env('link');?>/api/teacher",this.reg)
      .then(function(response) {
        alert('บันทึกข้อมูลสำเร็จ กรุณาเข้าสู่ระบบ');
       this.register = false;
      })
      .catch(function(error) {
        alert('กรุณาระบุข้อมูลให้ครบ');
      });
    }

  }
});

    </script>
@endsection