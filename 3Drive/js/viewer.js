window.onload = main;
var camera, renderer, importOBJ;

function addListeners(){
  window.addEventListener('resize', (e) => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  });
  var colorpicker = document.querySelector("#colorpicker");

  colorpicker.addEventListener('input', (e) => {
    importOBJ.traverse(function(child){
      if(child instanceof THREE.Mesh){
        child.material.color = new THREE.Color(e.target.value);
      }
    });
  });

  var roughpicker = document.querySelector("#roughpicker")
  roughpicker.addEventListener('input', (e) => {
    importOBJ.traverse(function(child){
      if(child instanceof THREE.Mesh){
        child.material.roughness = e.target.value;
      }
    });
  });
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


  var material = new THREE.MeshStandardMaterial({roughness: 0.5, color: 0xffffff, metalness: 0.0});

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
  scene.add( ambient );
  var mainLight = new THREE.DirectionalLight( 0xffffbb, 1.0);
  mainLight.position.set( 50, 150, 100 );
  var mainHelp = new THREE.DirectionalLightHelper(mainLight, 2);
  scene.add( mainLight );
  scene.add( mainHelp );
  var fillLight = new THREE.DirectionalLight(0xbbffff, 0.1);
  fillLight.position.set(-50, -50, -100);
  var fillHelp = new THREE.DirectionalLightHelper(fillLight, 2);
  scene.add (fillLight);
  //scene.add (fillHelp);


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
