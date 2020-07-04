window.onload = main;
var mouseX, mouseY, camX, camY, camZ, camera, cube, radius;

function addListeners(container){

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

  var scene = new THREE.Scene();
  var loader = new THREE.OBJLoader();
  loader.load(
    "../testData/Diamond.obj",
    function(object){
      scene.add(object);
    }
  );
  camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );

  var renderer = new THREE.WebGLRenderer( { alpha: true } );
  renderer.setSize( window.innerWidth, window.innerHeight );
  renderer.setClearColor( 0x303030, 1.0 );
  document.body.appendChild( renderer.domElement );
  //addListeners(renderer.domElement);

  /*var geometry = new THREE.BoxGeometry();
  var material = new THREE.MeshStandardMaterial({roughness: 0.2, color: 0x2020ff, metalness: 0.0});
  cube = new THREE.Mesh( geometry, material );
  scene.add( cube );*/


  var light = new THREE.AmbientLight( 0x404040 ); // soft white light
  scene.add( light );
  var light2 = new THREE.DirectionalLight( 0xffff90);
  light2.position.set( 50, 50, 100 );
  light2.rotation.set( 20, 20, 20);
  var helper = new THREE.DirectionalLightHelper(light2, 5);
  scene.add( light2 );
  scene.add( helper );

  camera.position.z = 5;
  var controls = new THREE.OrbitControls(camera, renderer.domElement);

  var animate = function () {
    requestAnimationFrame( animate );
    controls.update();
    renderer.render( scene, camera );
  };

  animate();
}
