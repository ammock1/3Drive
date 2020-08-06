<?php
  class Face{
    //Verts and edges hold indexes to the verts and edges in the master list, not
    //the objects themselves
    private $verts;
    private $edges;

    public function __construct($verts){
      $this->verts = new \Ds\Vector();
      $this->edges = new \Ds\Vector();
      for($i = 0; $i < count($verts); $i++){
        $this->verts->push($verts[$i]);
      }
    }
    public function vertList(){
      $result = "";
      for($i = 0; $i < count($this->verts) - 1; $i++){
        $result = $result.$this->verts[$i].", ";
      }
      $result = $result.$this->verts[count($this->verts) - 1];
      return $result;
    }
    public function addEdge($edge){
      $this->edges->push($edge);
    }
    public function isConnected($target){
      $isConnected = false;
      for($i = 0; $i < count($this->edges); $i++){
        for($j = 0; $j < count($target->edges); $j++){
          if($this->edges[$i]==$target->edges[$j]){
            $isConnected = true;
          }
        }
      }
      return $isConnected;
    }
  }
?>
