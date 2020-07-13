<?php
	include ('logincode.php')
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Viewer</title>
    <link rel="stylesheet" href="../css/viewer.css" />
  </head>

  <body>
    <script src="../js/three.js"></script>
    <script src="../js/OBJLoader.js"></script>
    <script type="module">
      //import {TextureLoader} from '../js/TextureLoader.js';
    </script>
    <script src="../js/OrbitControls.js"></script>
    <canvas id = "glCanvas" width="0" height="0"></canvas>
    <div id = "container" width="640" height="480"></div>
    <script src="../js/viewer.js"></script>
    <a href = "../html/list.php" id="goback">Go Back</a>
    <div id="sidebar">
      <div id = "panelsDiv">
        <div id="TransformPanel" class="panel">
          <label> Translate </label><br>
          <label> x: </label>
          <input type = "number" value="0" id="xpos" class="tinput">
          <label> y: </label>
          <input type = "number" value="0" id="ypos" class="tinput">
          <label> z: </label>
          <input type = "number" value="0" id="zpos" class="tinput"><br>
          <label> Rotate </label><br>
          <label> x: </label>
          <input type = "number" value="0" id="xrot" class = "tinput">
          <label> y: </label>
          <input type = "number" value="0" id="yrot" class = "tinput">
          <label> z: </label>
          <input type = "number" value="0" id="zrot" class = "tinput"><br>
          <label> Scale: </label>
          <input type= "number" value = "1" id="scale" class= "tinput">
        </div>
        <div id= "LightPanel" class="panel"></div>
        <div id= "MatPanel" class="panel">
          <label> Color: </label>
          <input id = "colorpicker" type="color" value="#ffffff"/><br>
          <label> Texture: </label>
          <input id = "texpicker" type="file" accept="image/png, image/jpeg"><br>
          <label> Roughness: </label>
          <input id = "roughpicker" type="number" min="0" max="1" value = "0.5">
        </div>
        <div id= "SavePanel" class="panel"></div>
      </div>
      <div id = "buttonsDiv">
        <button id="tbutton" class="visButton"> Transform </button>
        <button id="lbutton" class="visButton"> Edit Lighting </button>
        <button id="mbutton" class="visButton"> Edit Material </button>
        <button id ="sbutton" class="visButton"> Save Image </button><br>
      </div>
    </div>
  </body>

</html>
