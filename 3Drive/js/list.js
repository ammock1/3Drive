window.onLoad = main;

function main(){
  var options = document.getElementsByClassName("options");
  for(var i = 0; i < options.length; i++){
    options.style.display = "none";
  }
}
