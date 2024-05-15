<?php

declare(strict_types=1);

namespace Terpz710\FancyJoin;

//PluginBase
use pocketmine\plugin\PluginBase;

//Player
use pocketmine\player\Player;

//Sound
use pocketmine\network\mcpe\protocol\PlaySoundPacket;

//Particle
use pocketmine\world\particle\HugeExplodeParticle;

//Math(Vector3)
use pocketmine\math\Vector3;

//Events
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;

class Loader extends PluginBase implements Listener {

    public function onLoad(): void {
        $this->getLogger()->info("------------------------");
        $this->getLogger()->info("FancyJoin by Terpz710 has been enabled!");
        $this->getLogger()->info("BlueGamesNetwork LLC");
        $this->getLogger()->info("Made for BlueGamesNetwork!");
        $this->getLogger()->info("------------------------");
    }

    public function onEnable(): void {
        $this->registerEvent();
    }

    public function onDisable(): void {
        $this->getLogger()->info("------------------------");
        $this->getLogger()->info("FancyJoin by Terpz710 has been disabled!");
        $this->getLogger()->info("BlueGamesNetwork LLC");
        $this->getLogger()->info("Made for BlueGamesNetwork!");
        $this->getLogger()->info("------------------------");
    }

    private function registerEvent() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $playerName = $player->getName();
        $position = $player->getPosition();
        $world = $player->getPosition()->getWorld();
        $particle = new HugeExplodeParticle();

        $event->setJoinMessage("§l§7[§a+§7] {$playerName} has joined the game!");
        $player->sendTitle("§l§aWelcome!");
        $player->sendSubtitle("Enjoy your stay {$playerName}");
        $world->addParticle($position, $particle);
        $this->playSound($player, "random.explode");
    }

    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        $playerName = $player->getName();

        $event->setQuitMessage("§l§7[§4+§7] {$playerName} has left the game!");
    }

    private function playSound(Player $player, string $sound) {
        $pos = $player->getPosition();
        $packet = PlaySoundPacket::create($sound, $pos->getX(), $pos->getY(), $pos->getZ(), 150, 1);
        
        $player->getNetworkSession()->sendDataPacket($packet);
    }
}
