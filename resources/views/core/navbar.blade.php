<div class="w3-bar w3-red">
    <a href="#" class="w3-bar-item w3-button">Home</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small">Link 1</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small">Link 2</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small">Link 3</a>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="myFunction()">&#9776;</a>
  </div>
  
  <div id="demo" class="w3-bar-block w3-red w3-hide w3-hide-large w3-hide-medium">
    <a href="#" class="w3-bar-item w3-button">Link 1</a>
    <a href="#" class="w3-bar-item w3-button">Link 2</a>
    <a href="#" class="w3-bar-item w3-button">Link 3</a>
  </div>
   
  <script>
  function myFunction() {
      var x = document.getElementById("demo");
      if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
      } else { 
          x.className = x.className.replace(" w3-show", "");
      }
  }
  </script>