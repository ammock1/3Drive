window.onLoad = main;

function main(){
  var hams = document.getElementsByClassName("ham");
  for(var i = 0; i < hams.length; i++){
    hams[i].addEventListener("click", toggleMenu);
  }
  console.log("Listeners added");
  var options = document.getElementsByClassName("options");
  for(var i = 0; i < options.length; i++){
    options[i].style.display = "none";
  }
  console.log("Options hidden")
}

function toggleMenu(e){
  console.log("Listener called");
  var obj = e.target.parentNode.parentNode;
  var children = obj.childNodes;
  var image;
  var options;
  //get image and options for particular obj
  for(var i = 0; i < children.lenght; i++){
    if(children[i].className == "image"){
      image = children[i];
    }
    else if(children[i].className == "options"){
      opions = children[i];
    }
  }
  if(image.style.display=="none"){
    image.style.display=="block";
    options.style.display=="none";
  }
  else{
    image.style.display=="none";
    options.style.display=="block";
  }
}
