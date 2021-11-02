<?php

namespace BitcoinAPI;

use BitcoinAPI\Bitcoin;

use pocketmine\event\plugin\PluginEvent;

class BitcoinEvent extends PluginEvent{
  
  public function __construct(Bitcoin $main){
    $this->main = $main;
  }
}