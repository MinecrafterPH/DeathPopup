<?php
namespace Sean_M\DeathPopup;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utils\TextFormat;
use pocketmine\block\Block;

class Main extends PluginBase implements Listener{
  
  public function onEnable(){      
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info("DeathPopup enabled!");
  }
    
  public function onDisable(){
    $this->getLogger()->info("DeathPopup disabled!");
  }
  public function onPlayerDeath(PlayerDeathEvent $event){
  $p = $event->getEntity();
  $causeId = $p->getLastDamageCause()->getCause();
  $cause = $p->getLastDamageCause();
  switch($causeId){
    case EntityDamageEvent::CAUSE_DROWNING:
      $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You drowned!");
      break;
    case EntityDamageEvent::CAUSE_FALL:
      $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You fell from a high place!");
      break;
    case EntityDamageEvent::CAUSE_LAVA:
      $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You tried to swim in lava!");
      break;
    case EntityDamageEvent::CAUSE_FIRE:
      $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You burned to death!");
      break;
    case EntityDamageEvent::CAUSE_FIRE_TICK:
      $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You burned to death!");
      break;
    case EntityDamageEvent::CAUSE_SUICIDE:
      $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You died!");
      break;
    case EntityDamageEvent::CAUSE_CONTACT:
	if($cause instanceof EntityDamageByBlockEvent){
	        if($cause->getDamager()->getId() === Block::CACTUS){
		       $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You have been pricked to death!");
		}
	}
      break;
    case EntityDamageEvent::CAUSE_PROJECTILE:
	if($cause instanceof EntityDamageByEntityEvent){
            $e = $cause->getDamager();
		if($e instanceof Living){
			$p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You were shot by" . TextFormat::GREEN . "{$e->getName()}" . TextFormat::GOLD . "!");
                        if($e instanceof Player) $e->sendMessage(TextFormat::GOLD . TextFormat::BOLD . "You shot " . TextFormat::GREEN . "{$p->getName()}" . TextFormat::GOLD . "!");
		}else{
			  $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "An" . TextFormat::RESET . TextFormat::ITALIC . TextFormat::GREEN . "unknown force" . TextFormat::RESET . TextFormat::BOLD . TextFormat::GOLD . "has shot you!");
                }
        }
      break;
    case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
        if($cause instanceof EntityDamageByEntityEvent){
                if($e instanceof Living){
                        $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You were slain by" . TextFormat::GREEN . "{$e->getName()}" . TextFormat::GOLD . "!");
                        if($e instanceof Player) $e->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "You slayed" . TextFormat::GREEN . "{$p->getName()}" . TextFormat::GOLD . "!");
                }else{
                          $p->sendPopup(TextFormat::GOLD . TextFormat::BOLD . "An" . TextFormat::RESET . TextFormat::ITALIC . TextFormat::GREEN . "unknown force" . TextFormat::RESET . TextFormat::BOLD . TextFormat::GOLD . "has slain you!");
                        }
		}
	}
	break;		
  }
 }
