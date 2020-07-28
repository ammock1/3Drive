<?php
  class Vertex {
    //Default is -1 for error handling
    private int $id = -1;
    //card is short for cardinality
    private int $card = 0;
    private $facePointers;
    public function __construct(int $id){
      $this->facePointers = new \Ds\Vector();
      $this->id = $id;
      $this->card = 0;
    }
    public function getId(){
      return $this->id;
    }
    public function getCard(){
      return $this->card;
    }

    //link to face and increase card with one function
    public function addFace($faceInd){
      $this->facePointers->push($faceInd);
      $this->card++;
    }

    //old method of incrementing card
    public function incCard(){
      $this->card++;
    }

    public function getFacePointers(){
      return $this->facePointers;
    }
  }
?>
