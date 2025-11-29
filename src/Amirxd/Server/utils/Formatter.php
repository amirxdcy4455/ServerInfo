<?php

namespace Amirxd\Server\utils;

use Amirxd\Server\ServerInfo;
use pocketmine\utils\TextFormat as TF;

class Formatter
{
    private ServerInfo $plugin;
    private ServerAPI $api;

    public function __construct()
    {
        $this->plugin = ServerInfo::getInstance();
        $this->api = new ServerAPI();
    }

    public function format(string $text): string
    {
        $serverInfo = $this->api->getServerInfo();

        $tags = [
            '&' => '§',
            '{server.tps}' => (string)$this->api->getTPS(),
            '{server.tps_rounded}' => (string)$this->api->getRoundedTPS(),
            '{server.tps_colored}' => $this->api->getColoredTPS(),
            '{server.name}' => $serverInfo['server_name'],
            '{server.motd}' => $this->api->getServer()->getMotd(),
            '{server.version}' => $serverInfo['server_version'],
            '{server.api_version}' => $serverInfo['api_version'],
            '{server.port}' => (string)$serverInfo['server_port'],
            '{server.ip}' => $serverInfo['server_ip'],
            '{server.players.online}' => (string)$serverInfo['online_players'],
            '{server.players.max}' => (string)$serverInfo['max_players'],
            '{server.players.percent}' => (string)$serverInfo['online_percent'],
            '{server.worlds.count}' => (string)$serverInfo['worlds_count'],
            '{server.uptime}' => (string)$serverInfo['uptime'],
            '{server.memory.usage}' => $serverInfo['memory_usage'],
            '{server.memory.max}' => $this->api->getMaxMemory(),
            '{server.memory.percent}' => (string)$serverInfo['memory_percent'],
            '{server.health.status}' => $this->api->getServerHealthStatus(),
            '{server.health.healthy}' => $this->api->isServerHealthy() ? 'Yes' : 'No',
            '{server.memory.allData}' => $this->api->displayMemoryInfo(),
            '{server_type}' => $serverInfo["server_type"],
            '{border}' => '===================',

            '{line}' => "\n",
            '{color.black}' => TF::BLACK,
            '{color.dark_blue}' => TF::DARK_BLUE,
            '{color.dark_green}' => TF::DARK_GREEN,
            '{color.dark_aqua}' => TF::DARK_AQUA,
            '{color.dark_red}' => TF::DARK_RED,
            '{color.dark_purple}' => TF::DARK_PURPLE,
            '{color.gold}' => TF::GOLD,
            '{color.gray}' => TF::GRAY,
            '{color.dark_gray}' => TF::DARK_GRAY,
            '{color.blue}' => TF::BLUE,
            '{color.green}' => TF::GREEN,
            '{color.aqua}' => TF::AQUA,
            '{color.red}' => TF::RED,
            '{color.light_purple}' => TF::LIGHT_PURPLE,
            '{color.yellow}' => TF::YELLOW,
            '{color.white}' => TF::WHITE,
            '{color.reset}' => TF::RESET,
        ];


        return str_replace(array_keys($tags), array_values($tags), $text);
    }
}