<?php
class Decks
{
    public $stack;
    public $i;
    public $key;
    public $deck_one;
    //creating 32 cards using value, deck and color
    public function __construct($value,$deck) 
    {
        $key=0;
        for($i=0;$i<count($value);$i++)
      {
          foreach($deck as $deck_one)
          {
              $this->stack[$key]["value"]=$value[$i];
              $this->stack[$key]["deck"]=$deck_one;
              $key++;
          }
            
      }
      shuffle($this->stack);
      
    }
    public function getValue()
      {
          return $this->stack;
      }
    


    public function distributionCards()
    {
      $stack = $this->stack;
      $players = array();
      $John=array();
      $Jane=array();
      $Jan=array();
      $Otto=array();
      $element=0;
       //Getting elements for 4 player 
        for($limit=0;$limit<8;$limit++)
        {
            $start=$element;
            $John[$limit]=$stack[$element];
            $element++;
            $Jane[$limit]=$stack[$element];
            $element++;
            $Jan[$limit]=$stack[$element];
            $element++;
            $Otto[$limit]=$stack[$element];
            $element++;
            
            
        }
        $players=array("John"=>$John,"Jane"=>$Jane,"Jan"=>$Jan,"Otto"=>$Otto);

        return $players;
    }
}

$value=array("7","8","9","10","A","J","K","Q");
$deck=array("Club","Diamond","Heart","Spade");
