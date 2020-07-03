window.onload = main;
var camera, importOBJ;

function main(){
  console.log("Window loaded");
  //Get openGL
  const canvas = document.querySelector("#glCanvas");
  const gl = canvas.getContext("webgl") || canvas.getContext("experimental-webgl");

  if(gl === null){
    alert("Sorry, your browser or machine does not support OpenGL");
    return;
  }


  var material = new THREE.MeshStandardMaterial({roughness: 0.5, color: 0x20ffff, metalness: 0.0});

  var scene = new THREE.Scene();
  var loader = new THREE.OBJLoader();
  loader.load(
    "../testData/Diamond.obj",
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

  var renderer = new THREE.WebGLRenderer( { alpha: true } );
  renderer.setSize( window.innerWidth, window.innerHeight );
  renderer.setClearColor( 0x303030, 1.0 );
  document.body.appendChild( renderer.domElement );




  var light = new THREE.AmbientLight( 0x404040 );
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
