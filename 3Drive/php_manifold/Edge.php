<?php
  class Edge{
    private int $vert1;
    private int $vert2;
    private int $card = 1;

    public function __construct($vert1, $vert2){
      if($vert1 == $vert2){
        throw new Exception("Invalid edge!", 1);
      }
      else{
        $this->vert1 = $vert1;
        $this->vert2 = $vert2;
      }
    }
    public function getVert1(){
      return $this->vert1;
    }
    public function getVert2(){
      return $this->vert2;
    }
    public function equals($target){
      //If one edge is x, y and other is y, x, the normals are correct and the
      //edges are the same. Return 1
      if($this->vert1 == $target->vert2 && $this->vert2 == $target->vert1){
        return 1;
      }
      //If both edges are x, y, the normals are incorrect and the model
      //is non-manifold. Return -1
      else if($this->vert1 == $target->vert1 && $this->vert2 == $target->vert2){
        return -1;
      }
      //Return 0 if edges are completely different
      else{
        return 0;
      }
    }
    public function incCard(){
      $this->card++;
    }
    public function getCard(){
      return $this->card;
    }
    public function toString(){
      return "(".$this->vert1.", ".$this->vert2.")";
    }
  }
?>
