<html>
  <head>
    <title>Manifold-Check</title>
  </head>
  <body>
    <h1>Checking for non-manifold geometry...</h1>
    <?php
      include 'Vertex.php';
      include 'Edge.php';
      include 'Face.php';
      $user=urldecode($_REQUEST["user"]);
      $file = urldecode($_REQUEST["file"]);
      $filepath = "../file-upload/" . $user . "/" . $file;
      $objFile = fopen($filepath, "r") or die ("Error opening file!");
      $verts = new \Ds\Vector();
      $edges = new \Ds\Vector();
      $completeEdges = new \Ds\Vector();
      $faces = new \Ds\Vector();
      $vNum = 0;
      $isManifold = true;
      $reason = "No non-manifold geometry detected";

      //Import geometry
      while(!feof($objFile) && $isManifold){
        //get line
        $line = fgets($objFile);
        //split line
        $lineSplit = explode(" ", $line);
        //get command from line--used in switch case. Ex: v, vt, vn, f, o
        $cmd = $lineSplit[0];
        //echo "<p>".$cmd."</p>";
        switch ($cmd){
          case "v":
          //add new vertex to verts
            $verts->push(new Vertex($vNum));
            $vNum++;
            break;
          case "f":
            $fverts = new \Ds\Vector();
            //create vector of face vertices
            for($i = 1; $i < count($lineSplit); $i++){
              $splitPos = strpos($lineSplit[$i], "/");
              $vert = substr($lineSplit[$i], 0, $splitPos);
              $fverts->push($vert);
            }
            $faces->push(new Face($fverts));
            //for each vert in the face, increase cardinality of vert and create/update edge
            for($i = 0; $i < count($fverts); $i++){
              //obj file uses 1+ indexing instead of 0+, so must subtract 1
              $vert1 = intval($fverts[$i]) - 1;
              $vert2 = intval($fverts[($i + 1) % count($fverts)]) - 1;

              //Only addFace to vert1 to prevent duplicates!
              $verts[$vert1]->addFace($faces[count($faces) - 1]);

              //Create tmp edge
              $tmpEdge = new Edge($vert1, $vert2);
              $newEdge = true;

              //If new edge matches existing edge, update old edge and put in $completeEdges
              for($j = 0; $j < count($edges); $j++){
                $conType = $tmpEdge->equals($edges[$j]);
                if($conType == 1){
                  $newEdge = false;
                  //In a manifold mesh, each edge must be part of exactly 2 faces
                  //If already in 2, and used again, mesh is non-manifold
                  if($edges[$j]->getCard() > 1){
                    $reason = "Internal geometry detected";
                    $isManifold = false;
                  }
                  //If only used once, increase card to 2
                  $edges[$j]->incCard();
                  //Add reference to edge to new face
                  $faces[count($faces) - 1]->addEdge($edges[$j]);
                  $completeEdges->push($edges[$j]);
                  $edges->remove($j);
                  break;
                }
                else if($conType == -1){
                  $newEdge = false;
                  $isManifold = false;
                  $reason = "Incorrect normals or internal faces detected";
                  break;
                }
              }

              //Add new edge if it doesn't already exist. New edges go in $edges
              if($newEdge){
                $edges->push($tmpEdge);
                $faces[count($faces) - 1]->addEdge($tmpEdge);
              }
            }
            break;
          case "l":
            $isManifold = false;
            $reason = "Loose edge detected";
            break;
          default:
            //  echo "ignore";
            break;
        }
      }

      //Look for boundary edges
      if($isManifold && count($edges) != 0){
        $isManifold = false;
        $reason = "Boundary edges or internal faces detected";
      }

      //Look for loose verts and bowtie geometry
      if($isManifold){
        for($i = 0; $i < count($verts); $i++){
          //search for bowtie if card of the vertex is 6 or more
          if($verts[$i]->getCard() > 5){
            //sussFaces are under scrutiny
            $sussFaces = $verts[$i]->getFacePointers();

            /*
              linkedFaces are sussFaces connected to the first sussFace by
              an edge. If linkedFaces can be built up to the size of
              sussFaces, then it is a manifold pole. If not, it is a bowtie
            */
            $linkedFaces = new \Ds\Vector();
            $linkedFaces->push($sussFaces[0]);
            $sussFaces->remove(0);
            $j = 0;
            $conFound = true;
            while(count($sussFaces) > 0 && $conFound){
              $conFound = false;
              for($k = 0; $k < count($sussFaces); $k++){
                if($linkedFaces[$j]->isConnected($sussFaces[$k])){
                  $conFound = true;
                  $linkedFaces->push($sussFaces[$k]);
                  $sussFaces->remove($k);
                }
              }
              $j++;
            }
            if(count($sussFaces) > 0){
              $isManifold = false;
              $reason = "Bowtie detected";
              break;
            }
          }
          //loose verts have card = 0
          else if($verts[$i]->getCard() == 0){
            $isManifold = false;
            $reason = "Loose vertex detected";
            break;
          }
        }
      }

      /*for($i = 0; $i < count($faces); $i++){
        echo "<p>Face ".($i + 1).": ".$faces[$i]->vertList()."</p>";
      }*/

      echo "<p>Model contains ".$vNum." vertices</p>";
      if($isManifold){
        echo "<p>Model is manifold: ";
      }
      else{
        echo "<p>Model is non-manifold: ";
      }
      echo $reason."</p>";
      fclose($objFile);
    ?>
    	<h3><a href = "../html/list.php"> Return </a></h3>
  </body>
</html>
