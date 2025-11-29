<?php

namespace Amirxd\Server\commands;

use Amirxd\Server\utils\Formatter;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as TF;

class ServerInfoCommand extends \CortexPE\Commando\BaseCommand
{
    protected function prepare(): void
    {
        $this->setPermission("serverinfo.cmd");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {


       $formatter = new Formatter();
       $config = $this->plugin->getConfig();

       $messages = $config->get("messages", [
           "Server Information:",
           "TPS: {server.tps}",
           "Players: {server.players.online}/{server.players.max}",
           "Uptime: {server.uptime}"
       ]);

       foreach ($messages as $message) {
           if (!is_string($message)) continue;
           $formattedMessage = $formatter->format($message);
           $sender->sendMessage($formattedMessage);

       }
    }
}