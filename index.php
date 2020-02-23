
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
       include 'Deck.php'; 
       include 'Symbol.php';
       include 'Score.php';
     $object_deck=new Decks($value,$deck);
     $object_score=new Score($value);
     $current_value=array();
     $player_scores=array("John"=>0,"Jane"=>0,"Jan"=>0,"Otto"=>0);

    
     $gamerover=FALSE;
     $playernames= array('John','Jane','Jan','Otto');
     $startgame = true;
        
     $players =$object_deck->distributionCards();
        
        while(!$gamerover)
         {
            $roundscore = 0;
            if($startgame){
                $start_person = array_rand($playernames);
                $playernames = change_order($start_person,$playernames);
            }
            
                $i = 0;

                $current_player = $playernames[$i];
                $current_value= array_shift($players[$current_player]);
                 $maximum_match_value = $current_value;
                $lost_player = $current_player;

                $symbol=Get_symbol($current_value["deck"]);
                echo '===============================';      
                echo "$current_player  plays {$current_value['value']}  $symbol"."<br>";
                $current_score = $object_score->getScore($current_value);
                $roundscore = $roundscore + $current_score;               
                
               for($j=1;$j<count($playernames);$j++) {
               $player = $players[$playernames[$j]];
               compare($playernames[$j],$player,$roundscore,$current_value,$maximum_match_value,$lost_player,$object_score);
               $players[$playernames[$j]] = $player;
               

             }
             //echo "score ------ $roundscore <br>";
             //echo "lost player $lost_player <br>";
             $player_scores[$lost_player] = $player_scores[$lost_player]+$roundscore;
             
             $startgame = FALSE;
            if(empty($player))
                {
                  //var_dump($player_scores);
                  if(max($player_scores)>=50){
                    $loses_game = array_search(max($player_scores),$player_scores);
                     echo $loses_game." loses the game! <br>";
                     echo "points.<br>";
                    foreach($player_scores as $score_key => $score_value){
                      echo $score_key.": ".$score_value."<br>";
                    }
                    $gamerover=TRUE;
                    break;

                    
                  }
                  $players =$object_deck->distributionCards();
                  
                }
                $playernames = change_order($i+1,$playernames);
             
          }

// compare the values and print output
   function compare($key,&$player,&$roundscore,&$current_value,&$maximum_match_value,&$lost_player,$object_score)
   {
    
    $playingcard=array();
    $temp = array();
    $score = 0;
    $flag = 0;
         for($k=0;$k<count($player);$k++)
         {
              
          if($player[$k]['deck'] == $current_value['deck'])
          {
            if($player[$k]["value"]<=$current_value["value"])
            {
                 //var_dump($player[$k]);
                  $playingcard=$player[$k];   
                  $current_value = $playingcard; 
                  array_splice($player,$k,1);  
                  $flag =1;     
                  break;
            }
            else{
                $temp = $player[$k];
                $temp_key = $k;
                //var_dump($temp);
                if(count($temp)){
                    if($player[$k]['value'] <$temp['value'])
                    {
                      $temp = $player[$k];
                      $temp_key = $k;
                    }
                    
                }
            }
          }
          if(($k+1 == count($player)) && count($temp)){
               $playingcard=$temp;   
              array_splice($player,$temp_key,1);       
        

            }
       
         }
       
       if(empty($playingcard))
       {
          $playingcard=  array_shift($player);
        }
          $score = $object_score->getScore($playingcard);
          //echo "$score"." "."<br>";
          if(!$flag){
            if(($playingcard['deck'] == $maximum_match_value['deck']) &&
              $playingcard['value'] > $maximum_match_value['value']){
              $maximum_match_value = $playingcard;
              $lost_player = $key;
              //print "$lost_player"."=----------= <br>";
            }
            
          }
          $roundscore = $roundscore + $score;
          $symbol=Get_symbol($playingcard["deck"]);
           echo "$key  plays {$playingcard['value']}  $symbol"."<br>";
      
}

//starting next player
function change_order($start_person,$playernames){
    $change_array = array_splice($playernames, 0,$start_person);
  //var_dump($change_array);
  if(count($change_array) > 0){
      foreach ($change_array as  $value) {
        array_push($playernames,$value);
      }
    }
    
  return $playernames;
}


 ?>
    </body>
</html>
