<?php

namespace Amirxd\Server;

use Amirxd\Server\commands\ServerInfoCommand;
use onebone\economyapi\EconomyAPI;
use pocketmine\utils\TextFormat as TF;

class ServerInfo extends \pocketmine\plugin\PluginBase
{

    public string $tag = TF::GRAY . "[" . TF::AQUA . "ServerInfo" . TF::GRAY . "] ";
    private static self $Instance;

    public function onLoad(): void
    {
    self::$Instance = $this;
    }

    public function onEnable(): void
    {
        $this->getLogger()->info($this->tag . TF::GREEN . "Enabled");
        $this->RegisterCommands();
        $this->saveDefaultConfig();
    }

    private function RegisterCommands():void
    {
        $cmd = new ServerInfoCommand($this, "serverinfo", "Show server information", ["si"]);
        $manager = $this->getServer()->getCommandMap();
        $manager->register("serverinfo", $cmd);
    }

    public static function getInstance():self{
        return self::$Instance;
    }

    public function getMessage(){

    }


}