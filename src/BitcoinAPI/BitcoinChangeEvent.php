<?php

namespace BitcoinAPI;

use BitcoinAPI\Bitcoin;

use pocketmine\Player;

use BitcoinAPI\BitcoinEvent;

class BitcoinChangeEvent extends BitcoinEvent{
  
  public function __construct(Bitcoin $main, $player){
    $this->main = $main;
    $this->player = $player;
  }
  
  public function getPlayer(){
    return $this->player;
  }
  
  public function getBitcoin(){
    return $this->main->myBitcoin($this->player);
  }
}