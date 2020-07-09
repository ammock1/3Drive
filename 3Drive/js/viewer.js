window.onload = main;
var camera, renderer, importOBJ, lights;

function initLightPane(){
  var lightPanel = document.querySelector("#LightPanel");
  for(var i = 0; i < lights.length; i++){
    var curLight = document.createElement("div");
    var label = document.createElement("label");
    label.innerText = (i+1 + ": ");
    curLight.append(label);
    if(lights[i] instanceof THREE.AmbientLight){
      label.innerText = label.innerText + ("Ambient");
    }
    else{
      var xpos = document.createElement("input");
      xpos.type = "number";
      xpos.id = i + "x";
      xpos.value = lights[i].position.x;
      xpos.addEventListener("input", updateLights);
      var ypos = document.createElement("input");
      ypos.type = "number";
      ypos.id = i + "y";
      ypos.value = lights[i].position.y;
      ypos.addEventListener("input", updateLights);
      var zpos = document.createElement("input");
      zpos.type = "number";
      zpos.id = i + "z";
      zpos.value = lights[i].position.z;
      zpos.addEventListener("input", updateLights);
      curLight.append(xpos);
      curLight.append(ypos);
      curLight.append(zpos);
    }
    var intensity = document.createElement("input");
    intensity.type = "number";
    intensity.id = i + "i";
    intensity.value = lights[i].intensity;
    intensity.addEventListener("input", updateLights);
    curLight.append(intensity);
    var color = document.createElement("input");
    color.type = "color";
    color.id = i + "c";
    cstring = lights[i].color.getHexString();
    cstring = "#" + cstring;
    color.value = cstring;
    color.addEventListener("input", updateLights)
    curLight.append(color);
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

  var xpos = document.querySelector("#xpos");
  var ypos = document.querySelector("#ypos");
  var zpos = document.querySelector("#zpos");
  var xrot = document.querySelector("#xrot");
  var yrot = document.querySelector("#yrot");
  var zrot = document.querySelector("#zrot");
  var scale = document.querySelector("#scale");
  xpos.addEventListener('input', updateTransform);
  ypos.addEventListener('input', updateTransform);
  zpos.addEventListener('input', updateTransform);
  xrot.addEventListener('input', updateTransform);
  yrot.addEventListener('input', updateTransform);
  zrot.addEventListener('input', updateTransform);
  scale.addEventListener('input', updateTransform);
  var colorpicker = document.querySelector("#colorpicker");

  colorpicker.addEventListener('input', (e) => {
    importOBJ.traverse(function(child){
      if(child instanceof THREE.Mesh){
        child.material.color = new THREE.Color(e.target.value);
      }
    });
  });

  //uncomment and update for texture input
  /*var texpicker = document.querySelector("#texpicker");

  texpicker.addEventListener('input', (e) => {
    importOBJ.traverse(function(child){
      if(child instanceof THREE.Mesh){
        child.material.map = new THREE.TextureLoader().load(e.target.value);
      }
    });
  });*/

  var roughpicker = document.querySelector("#roughpicker")
  roughpicker.addEventListener('input', (e) => {
    importOBJ.traverse(function(child){
      if(child instanceof THREE.Mesh){
        child.material.roughness = e.target.value;
      }
    });
  });
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
  //Get openGL
  const canvas = document.querySelector("#glCanvas");
  const gl = canvas.getContext("webgl") || canvas.getContext("experimental-webgl");

  if(gl === null){
    alert("Sorry, your browser or machine does not support OpenGL");
    return;
  }

  //uncomment, update, and add map: texture to mat to load texture on startup
  //var texture = new THREE.TextureLoader().load('../testData/Diamond_Diffuse.png');
  var material = new THREE.MeshStandardMaterial({roughness: 0.5, metalness: 0.0});

  var scene = new THREE.Scene();
  var loader = new THREE.OBJLoader();
  loader.load(
    "../testData/Sphere.obj",
    function(object){
      importOBJ = object;
      object.traverse(function(child){
        if(child instanceof THREE.Mesh){
          child.material = material;
          child.material.needsUpdate = true;
        }
      });
      scene.add(object);
    });

  camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );

  renderer = new THREE.WebGLRenderer( { alpha: true } );
  renderer.setSize( window.innerWidth, window.innerHeight );
  renderer.setClearColor( 0x303030, 1.0 );
  document.body.appendChild( renderer.domElement );

  //Adding lights
  var ambient = new THREE.AmbientLight( 0x404040 );
  var mainLight = new THREE.DirectionalLight( 0xffffbb, 1.0);
  mainLight.position.set( 50, 150, 100 );
  var mainHelp = new THREE.DirectionalLightHelper(mainLight, 2);
  scene.add( mainHelp );
  var fillLight = new THREE.DirectionalLight(0xbbffff, 0.1);
  fillLight.position.set(-50, -50, -100);
  var fillHelp = new THREE.DirectionalLightHelper(fillLight, 2);
  scene.add (fillHelp);
  lights = [];
  lights.push(ambient);
  lights.push(mainLight);
  lights.push(fillLight)
  for(var i = 0; i < lights.length; i++){
    scene.add(lights[i]);
  }
  initLightPane();

  //Moving camera and setting up controls
  camera.position.z = 5;
  var controls = new THREE.OrbitControls(camera, renderer.domElement);

  var animate = function () {
    requestAnimationFrame( animate );
    controls.update();
    renderer.render( scene, camera );
  };
  addListeners();
  animate();
}
