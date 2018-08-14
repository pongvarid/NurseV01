<?php
function alert(){
    ?>
<v-snackbar
      v-model="alert_bar"
    >
       {{alert_text}}
      <v-btn
        color="pink"
        flat
        @click="alert_bar = false">
        Close
      </v-btn>
    </v-snackbar>
    <?php
}
function script_alert(){
    ?>
    alert_bar:false,
    alert_text:null,
    <?php
}


function open_alert(){
    ?>
    alert_open(tmp){
        this.alert_bar = true;
        this.alert_text = tmp
    },
    <?php
}
?>

