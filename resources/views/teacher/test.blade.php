 

@extends('core.vuetify') 
 
    
@section('vue')
 @{{tmp}}
 
@endsection
 
@section('vue_script')
<script>
  new Vue({
  el: "#app",
  data: {
      tmp:{},
  },
  methods: { 
       
      load(){
        let result =  axios.get('<?=env('link');?>/api/teacher/1')
      .then((r) => {
          this.tmp = r.data;
      }).catch((e) => { 
          alert('error');
      });
      }
  },
  mounted(){
      this.load();
  }
});


</script>
@endsection
 