<?php
/*
Hi I am a plugin developer. The plugin is still in beta. If you have any problems, please give me feedback: https://www.facebook.com/profile.php?id=100071316150096 
*/

namespace BitcoinAPI;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

use pocketmine\utils\Config;

use pocketmine\event\player\PlayerJoinEvent;

use BitcoinAPI\BitcoinChangeEvent;
use BitcoinAPI\BitcoinEvent;

class Bitcoin extends PluginBase implements Listener {
  
  public function onEnable(){
    $this->getLogger()->info("Bitcoin API BETA-0.2");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->bitcoin = new Config($this->getDataFolder() . "bitcoin.yml", Config::YAML);
  }
  
  public function onDisable(){
    $this->getLogger()->info("Bitcoin API BETA-0.2");
  }
  
  public function onJoin(PlayerJoinEvent $event){
    $player = $event->getPlayer();
    if(!$this->bitcoin->exists($player->getName())){
      $this->bitcoin->set($player->getName(), 0);
      $this->bitcoin->save();
      $this->getServer()->getPluginManager()->callEvent(new BitcoinChangeEvent($this, $player));
    }
  }
  
  public function reduceBitcoin($player, $bitcoin){
    if($player instanceof Player){
      if(is_numeric($bitcoin)){
         $this->bitcoin->set($player->getName(), ($this->bitcoin->get($player->getName()) - $bitcoin));
         $this->getServer()->getPluginManager()->callEvent(new BitcoinChangeEvent($this, $player));
      }
    }
  }
  
  public function addBitcoin($player, $bitcoin){
    if($player instanceof Player){
      if(is_numeric($bitcoin)){
         $this->bitcoin->set($player->getName(), ($this->bitcoin->get($player->getName()) + $bitcoin));
         $this->getServer()->getPluginManager()->callEvent(new BitcoinChangeEvent($this, $player));
      }
    }
  }
  
  public function myBitcoin($player){
    if($player instanceof Player){
      
      return ($this->bitcoin->get($player->getName()));
    }
  }
  
  public function getAllBitcoin(){
    return $this->bitcoin->getAll();
  }
  
  public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args): bool{
    switch($cmd->getName()){
      case "mybitcoin":
        if($sender instanceof Player){
          $bitcoin = $this->myBitcoin($sender);
          $sender->sendMessage("Your Bitcoin: " . $bitcoin);
        }else{
          $sender->sendMessage("Pls Use In Game");
        }
        break;
        
        case "setbitcoin":
          if($sender instanceof Player){
            if($sender->hasPermission("setbitcoin.pmmdst")){
              if(isset($args[0])){
                if(isset($args[1])){
                  $player = $this->getServer()->getPlayer($args[0]);
                  if(!is_numeric($args[1])){
                    $sender->sendMessage("§cPlease enter the amount in digits!");
                    return true;
                  }
                  if(!$player instanceof Player){
                    $sender->sendMessage("§cPlayer " . $args[0] . " not online!");
                    return true;
                  }
                  
                  $this->bitcoin->set($player->getName(), $args[1]);
                  $this->bitcoin->save();
                  $sender->sendMessage("§aSuccessfully set " . $args[0] . " bitcoin to " . $args[1]);
                  $player->sendMessage("§aYour bitcoin have been set to " . $args[1]);
                  $this->getServer()->getPluginManager()->callEvent(new BitcoinChangeEvent($this, $player));
                }else{
                  $sender->sendMessage("Usage: /setbitcoin {player} {amount}");
                }
              }else{
                $sender->sendMessage("Usage: /setbitcoin {player} {amount}");
              }
            }
          }else{
            $sender->sendMessage("Pls Use In Game");
          }
          break;
          
          case "topbitcoin":
            $bitcoinall = $this->getAllBitcoin();
            arsort($bitcoinall);
            $bitcoinall = array_slice($bitcoinall, 0, 9);
            $top = 1;
            foreach($bitcoinall as $name => $count){
              $sender->sendMessage("Top " . $top . " belong to " . $name . " with " . $count . " bitcoin");
              $top++;
            }
            break;
            
            case "paybitcoin":
              if($sender instanceof Player){
                if(isset($args[0])){
                  if(isset($args[1])){
                    $player2 = $this->getServer()->getPlayer($args[0]);
                    $bitcoin = $this->myBitcoin($sender);
                    if(!$player2 instanceof Player){
                      $sender->sendMessage("§cPlayer " . $args[0] . " not online!");
                      return true;
                    }
                    if(!is_numeric($args[1])){
                      $sender->sendMessage("Pls Type The Amount With Number");
                      return true;
                    }
                    if($args[0] === $sender->getName()){
                      $sender->sendMessage("§cCan't pay bitcoin to yourself");
                      return true;
                    }
                    if($bitcoin >= $args[1]){
                      $this->reduceBitcoin($sender, $args[1]);
                      $this->addBitcoin($player2, $args[1]);
                      $sender->sendMessage("§aPay " . $args[1] . " complete to " . $args[0]);
                      $player2->sendMessage("§aPlayer " . $sender->getName() . " pay you " . $args[1] . " bitcoin");
                    }else{
                      $sender->sendMessage("§cNot have enough bitcoin");
                      return true;
                    }
                  }else{
                    $sender->sendMessage("Usage: /paybitcoin {player} {amount}");
                  }
                }else{
                  $sender->sendMessage("Usage: /paybitcoin {player} {amount}");
                }
              }else{
                $sender->sendMessage("You Must Use Command In Game");
              }
              break;
    }
    return true;
  }
}
