window.onload = main;
var camera, renderer, scene, importOBJ, lights;

function initLightPane(){
  var lightPanel = document.querySelector("#LightTable");
  for(var i = 0; i < lights.length; i++){
    var curLight = document.createElement("tr");
    var label = document.createElement("td");
    label.innerText = (i + ": ");
    curLight.append(label);
    if(lights[i] instanceof THREE.AmbientLight){
      label.innerText = ("Ambient");
      label.style.backgroundColor = "rgba(255, 255, 255, 0.1)";
      label.colSpan = "4";
    }
    else{
      var xposTD = document.createElement("td");
      var xpos = document.createElement("input");
      xpos.type = "number";
      xpos.id = i + "x";
      xpos.value = lights[i].position.x;
      xpos.addEventListener("input", updateLights);
      xposTD.append(xpos);
      var yposTD = document.createElement("td");
      var ypos = document.createElement("input");
      ypos.type = "number";
      ypos.id = i + "y";
      ypos.value = lights[i].position.y;
      ypos.addEventListener("input", updateLights);
      yposTD.append(ypos);
      var zposTD = document.createElement("td");
      var zpos = document.createElement("input");
      zpos.type = "number";
      zpos.id = i + "z";
      zpos.value = lights[i].position.z;
      zpos.addEventListener("input", updateLights);
      zposTD.append(zpos);
      curLight.append(xposTD);
      curLight.append(yposTD);
      curLight.append(zposTD);
    }
    var intensityTD = document.createElement("td");
    var intensity = document.createElement("input");
    intensity.type = "number";
    intensity.id = i + "i";
    intensity.value = lights[i].intensity;
    intensity.addEventListener("input", updateLights);
    intensityTD.append(intensity);
    curLight.append(intensityTD);
    var colorTD = document.createElement("td");
    var color = document.createElement("input");
    color.type = "color";
    color.id = i + "c";
    cstring = lights[i].color.getHexString();
    cstring = "#" + cstring;
    color.value = cstring;
    color.addEventListener("input", updateLights)
    colorTD.append(color);
    curLight.append(colorTD);
    lightPanel.append(curLight);
  }

}

function updateLights(e){
  var info = e.target.id;
  var action = info.charAt(info.length - 1);
  console.log(action);
  var i = info.substring(0, info.length - 1);
  console.log(i);
  switch (action){
    case 'x':
      lights[i].position.setX(e.target.value);
      break;
    case 'y':
      lights[i].position.setY(e.target.value);
      break;
    case 'z':
      lights[i].position.setZ(e.target.value);
      break;
    case 'i':
      lights[i].intensity = e.target.value;
      break;
    case 'c':
      lights[i].color = new THREE.Color(e.target.value);
  }
}

function addListeners(){
  window.addEventListener('resize', (e) => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  });

  //Input OBJ
  var upFile = document.getElementById("upfile");
  upFile.addEventListener('change', (e) => {
    if(e.target.files && e.target.files[0] && validateObj(e.target.value)){
      console.log(e.target.value);
      var objfile = URL.createObjectURL(e.target.files[0]);
      var loader = new THREE.OBJLoader();
      loader.setCrossOrigin("");
      loader.load(
        objfile,
        function(object){
          //remove old import
          if(importOBJ != null){
            scene.remove(importOBJ);
            importOBJ.traverse(function(child){
              if(child.material != null){
                if(child.material.map != null){
                  child.material.map.dispose();
                }
                child.material.dispose();
              }
              if(child.geometry != null){
                child.geometry.dispose();
              }
            });
          }
          //bring in new import
          var material = new THREE.MeshStandardMaterial({roughness: 0.5});
          importOBJ = object;
          object.traverse(function(child){
            if(child instanceof THREE.Mesh){
              child.material = material;
            }
          });
          scene.add(object);
      });
      URL.revokeObjectURL(objfile);
    }
    else{
      alert("Invalid OBJ file");
    }
  });

  var tinputs = document.getElementsByClassName("tinput");
  for(var i = 0; i < tinputs.length; i++){
    tinputs[i].addEventListener('input', updateTransform);
  }

  var colorpicker = document.querySelector("#colorpicker");

  colorpicker.addEventListener('input', (e) => {
    importOBJ.traverse(function(child){
      if(child instanceof THREE.Mesh){
        child.material.color = new THREE.Color(e.target.value);
      }
    });
  });

  //Diffuse texture input
  var texpicker = document.querySelector("#texpicker");
  texpicker.addEventListener('change', (e) => {
    if(e.target.files && e.target.files[0] && validateTex(e.target.value)){
      console.log(e.target.value);
      var texfile = URL.createObjectURL(e.target.files[0]);
      var loader = new THREE.TextureLoader();
      loader.setCrossOrigin("");
      loader.load(
        texfile,
        function (texture){
          importOBJ.traverse(function(child){
            if(child instanceof THREE.Mesh){
              child.material.needsUpdate = true;
              child.material.map = texture;
              child.material.needsUpdate = false;
            }
          });
          URL.revokeObjectURL(texfile);
      });
    }
    else{
      alert("Invalid texture file");
    }
  });

  var roughpicker = document.querySelector("#roughpicker");
  roughpicker.addEventListener('input', (e) => {
    importOBJ.traverse(function(child){
      if(child instanceof THREE.Mesh){
        child.material.roughness = e.target.value;
      }
    });
  });

  //Add listener to render image
  var saveButton = document.getElementById("sbutton");
  saveButton.addEventListener('click', (e) =>{
    renderer.render( scene, camera );
    var imgSrc = renderer.domElement.toDataURL();
    var img = document.getElementById("preview");
    img.src = imgSrc;
    document.getElementById("previewFig").style.display = "block";
  });

  //Listener to hide preview image
  var close = document.getElementById("closePreview");
  close.addEventListener('click', (e) =>{
    document.getElementById("previewFig").style.display = "none";
  });

  //Add listeners to visibility toggle buttons
  var visButtons = document.getElementsByClassName("visButton");
  for(var i = 0; i < visButtons.length; i++){
    visButtons[i].addEventListener('click', panelHandler);
  }
}

function validateTex(filename){
  var parts = filename.split('.');
  var type = parts[parts.length - 1];
  switch (type.toLowerCase()) {
    case "png":
    case "jpg":
    case "jpeg":
      return true;
      break;
    default:
      return false;
      break;
  }
}

function validateObj(filename){
  var parts = filename.split('.');
  var type = parts[parts.length - 1];
  if(type.toLowerCase().localeCompare("obj") == 0){
    return true;
  }
  else{
    return false;
  }
}

function panelHandler(e){
  var button = e.target.id;
  var target;
  var panels = document.getElementsByClassName("panel");
  switch (button){
    case "tbutton":
      target = document.querySelector("#TransformPanel");
      break;
    case "lbutton":
      target = document.querySelector("#LightPanel");
      break;
    case "mbutton":
      target = document.querySelector("#MatPanel");
      break;
  }
  if(target.style.display == "none"){
    for(var i = 0; i < panels.length; i++){
      panels[i].style.display = "none";
    }
    target.style.display = "block";
  }
  else{
    target.style.display = "none";
  }
}

function updateTransform(e){
  var xpos = document.querySelector("#xpos").value;
  var ypos = document.querySelector("#ypos").value;
  var zpos = document.querySelector("#zpos").value;
  var xrot = document.querySelector("#xrot").value;
  var yrot = document.querySelector("#yrot").value;
  var zrot = document.querySelector("#zrot").value;
  var scale = document.querySelector("#scale").value;

  importOBJ.position.set(xpos, ypos, zpos);
  importOBJ.rotation.set(xrot, yrot, zrot);
  importOBJ.scale.set(scale, scale, scale);
}

function main(){
  console.log("Window loaded");
  var panels = document.getElementsByClassName("panel");
  for(var i = 0; i < panels.length; i++){
    panels[i].style.display = "none";
  }
  var figure = document.getElementById("previewFig");
  figure.style.display = "none";
  //Get openGL
  const canvas = document.querySelector("#glCanvas");
  const gl = canvas.getContext("webgl") || canvas.getContext("experimental-webgl");

  if(gl === null){
    alert("Sorry, your browser or machine does not support OpenGL");
    return;
  }

  //uncomment, update, and add map: texture to mat to load texture on startup
  //var texture = new THREE.TextureLoader().load('../testData/Diamond_Diffuse.png');
  //var material = new THREE.MeshStandardMaterial({roughness: 0.5, metalness: 0.0});

  scene = new THREE.Scene();
  /*var loader = new THREE.OBJLoader();


  let params = new URLSearchParams(location.search);
  var filename =params.get('filename');
  var user=params.get('user');
  loader.load(
    //First file is for use on live server, second file is for local testing
    "../file-upload/"+ user + "/" + filename,
    //"../testData/Sphere.obj",
    function(object){
      importOBJ = object;
      object.traverse(function(child){
        if(child instanceof THREE.Mesh){
          child.material = material;
          child.material.needsUpdate = true;
        }
      });
      scene.add(object);
    });*/

  camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );

  renderer = new THREE.WebGLRenderer( { alpha: true } );
  renderer.setSize( window.innerWidth, window.innerHeight );
  renderer.setClearColor( 0x303030, 1.0 );
  document.body.appendChild( renderer.domElement );

  //Adding lights
  var ambient = new THREE.AmbientLight( 0x404040 );
  var mainLight = new THREE.DirectionalLight( 0xffffbb, 1.0);
  mainLight.position.set( 50, 150, 100 );
  var fillLight = new THREE.DirectionalLight(0xbbffff, 0.1);
  fillLight.position.set(-50, -50, -100);
  lights = [];
  lights.push(ambient);
  lights.push(mainLight);
  lights.push(fillLight)
  for(var i = 0; i < lights.length; i++){
    scene.add(lights[i]);
  }
  initLightPane();
  addListeners();
  //Moving camera and setting up controls
  camera.position.z = 5;
  var controls = new THREE.OrbitControls(camera, renderer.domElement);

  var animate = function () {
    requestAnimationFrame( animate );
    controls.update();
    renderer.render( scene, camera );
  };
  animate();
}
