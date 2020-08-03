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
      import {TextureLoader} from '../js/TextureLoader.js';
    </script>
    <script src="../js/OrbitControls.js"></script>
    <canvas id = "glCanvas" width="0" height="0"></canvas>
    <div id = "container" width="640" height="480"></div>
    <script src="../js/viewer.js"></script>
    <a href = "3drive.html" id="goback">
      <img src="../images/back.png" alt="Go Back" width = 100px>
    </a>
    <div id="sidebar">
      <div id = "panelsDiv">
        <div id="TransformPanel" class="panel">
          <h1> Transform </h1>
          <h2> Translate </h2>
          <label> x: </label>
          <input type = "number" value="0" id="xpos" class="tinput">
          <label> y: </label>
          <input type = "number" value="0" id="ypos" class="tinput">
          <label> z: </label>
          <input type = "number" value="0" id="zpos" class="tinput"><br>
          <h2> Rotate </h2>
          <label> x: </label>
          <input type = "number" value="0" id="xrot" class = "tinput">
          <label> y: </label>
          <input type = "number" value="0" id="yrot" class = "tinput">
          <label> z: </label>
          <input type = "number" value="0" id="zrot" class = "tinput"><br>
          <h2 id="scaleLabel"> Scale: </h2>
          <input type= "number" value = "1" id="scale" class= "tinput">
        </div>
        <div id= "LightPanel" class="panel">
          <h1> Lights </h1>
          <table id= "LightTable">
            <tr>
              <td> Number </td>
              <td> X </td>
              <td> Y </td>
              <td> Z </td>
              <td> Intensity </td>
              <td> Color </td>
            </tr>
          </table>
        </div>
        <div id= "MatPanel" class="panel">
          <h1> Material </h1>
          <label> Color: </label>
          <input id = "colorpicker" type="color" value="#ffffff"/><br>
          <label> Texture: </label>
          <input id = "texpicker" type="file" accept="image/png, image/jpeg"><br>
          <label> Roughness: </label>
          <input id = "roughpicker" type="number" min="0" max="1" value = "0.5">
        </div>
        <div id= "SavePanel" class="panel">
          <h1> Render </h1>
          <button id = "download_img">Render Image</button>
          <button id = "set_thumbnail">Set Thumbnail</button>
        </div>
      </div>
      <div id = "buttonsDiv">
        <button id="tbutton" class="visButton"></button>
        <button id="lbutton" class="visButton"></button>
        <button id="mbutton" class="visButton"></button>
        <button id ="sbutton" class="visButton"></button><br>
      </div>
    </div>
    <div id = "previewFig"
      <figure>
        <img id = "preview" width = 256px/>
        <figcaption>Right click on the preview image to save!</figcaption>
      </figure>
      <button id = "closePreview" class = "x">x</button>
    </div>
  </body>

</html>
