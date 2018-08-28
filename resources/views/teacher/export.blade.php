<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';}else{
    $id = $_SESSION['user'];
}
 
?>  
<style>
    .scr{
        overflow-x: scroll;
            overflow-y: scroll;
    }
        table {
            overflow-x: scroll;
            overflow-y: scroll;
            border-collapse: collapse;
            width: 100%;
        }
        
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
      
        </style>
@extends('core.vuetify') 
@section('vue')

<v-container>

    <v-btn color="success"  @click="backPage()"><v-icon>fas fa-arrow-left</v-icon> กลับ</v-btn>

        <a style="width:100%" class="v-btn box-blue wh" id="btnExport" onclick="javascript:xport.toCSV('testTable', 'outputdata');"><h3><v-icon class="wh">fas fa-file-excel</v-icon>&nbsp;ส่งออกเป็นไฟล์ CSV</h3></a> <br>
  <div class="scr">
        <table   id="testTable">
        <tr>
            <th>รหัสนิสิต</th>
            <th>ชื่อ</th>
            <th>คณะ</th>
            <th>สาขา</th>
                <th  v-for="data in datas.exercise">  @{{data.name}} </th>
                <th>คะแนนรวม</th>
          </tr>
          <tr v-for="data,index in datas.in">
                        <td>@{{data.student.username}}</td>
                        <td>@{{JSON.parse(data.student.data).FirstName_TH}}&nbsp;@{{JSON.parse(data.student.data).LastName_TH}}</td>
                        <td>@{{JSON.parse(data.student.data).FacultyName_TH}}</td>
                        <td>@{{JSON.parse(data.student.data).ProgramName_TH}}</td>
                        <th :id="'resd'+index" v-for="dataX in datas.exercise">  @{{getScore(dataX.id,data.student.username)}} </th>
                        <th>@{{countScore(data.student.username)}}</th>
                    </tr>
       

    </table>
</div>

</v-container>

@endsection
 <script>
 var xport = {
  _fallbacktoCSV: true,  
  toXLS: function(tableId, filename) {   
    this._filename = (typeof filename == 'undefined') ? tableId : filename;
    
    //var ieVersion = this._getMsieVersion();
    //Fallback to CSV for IE & Edge
    if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
      return this.toCSV(tableId);
    } else if (this._getMsieVersion() || this._isFirefox()) {
      alert("Not supported browser");
    }

    //Other Browser can download xls
    var htmltable = document.getElementById(tableId);
    var html = htmltable.outerHTML;

    this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls'); 
  },
  toCSV: function(tableId, filename) {
    this._filename = (typeof filename === 'undefined') ? tableId : filename;
    // Generate our CSV string from out HTML Table
    var csv = "\ufeff"+this._tableToCSV(document.getElementById(tableId));
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv;charset=utf-8" });

    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {      
      this._downloadAnchor(URL.createObjectURL(blob), 'csv');      
    }
  },
  _getMsieVersion: function() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }

    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }

    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }

    // other browser
    return false;
  },
  _isFirefox: function(){
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }
    
    return 0;
  },
  _downloadAnchor: function(content, ext) {
      var anchor = document.createElement("a");
      anchor.style = "display:none !important";
      anchor.id = "downloadanchor";
      document.body.appendChild(anchor);

      // If the [download] attribute is supported, try to use it
      
      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
  },
  _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;

    return slice
      .call(table.rows)
      .map(function(row) {
        return slice
          .call(row.cells)
          .map(function(cell) {
            return '"t"'.replace("t", cell.textContent);
          })
          .join(",");
      })
      .join("\r\n");
  }
};

 </script>
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {
    resw:[],
    datas:[],
 
  },
  methods: {
    backPage(){
            window.location=document.referrer;
    },

    countScore(studentID){
        let score =0;
        for(let i=0; i < this.datas.exercise.length;i++){
            console.log(Number(this.getScoreByExercised(this.datas.exercise[i].exercised,studentID)));
            if(!isNaN(Number(this.getScoreByExercised(this.datas.exercise[i].exercised,studentID))) ){
                score+= Number(this.getScoreByExercised(this.datas.exercise[i].exercised,studentID));
            }
         
        }
        return score;
    }, 
    
    getScore(exerciseID,studentID){
        let score = 0;
        for(let i=0; i < this.datas.exercise.length;i++)
        {
           
            if(this.datas.exercise[i].id == exerciseID ){
 
                score = this.getScoreByExercised(this.datas.exercise[i].exercised,studentID);
                
            }else{


                continue;

            }
          
        }
        return score;
    },

    getScoreByExercised(exercised,studentID){
       
        for(let i=0; i < exercised.length; i++){ 
            console.log(i);
            if(exercised[i].student == studentID){
              
                return exercised[i].score;
            }else{
                
            }
        }

    },
      
    getExport(){
        axios.get("/api/score/{{request()->route('id')}}")
        .then((r)=>{
            this.datas = r.data;
        }).catch((e)=>{
            alert('error: '+e);
        });
    },
    load(){
       this.getExport();
    }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection