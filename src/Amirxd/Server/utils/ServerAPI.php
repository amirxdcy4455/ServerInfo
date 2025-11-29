<?php

namespace Amirxd\Server\utils;

use Amirxd\Server\ServerInfo;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class ServerAPI
{
    private ServerInfo $plugin;
    private Server $server;

    public function __construct()
    {
        $this->plugin = ServerInfo::getInstance();
        $this->server = Server::getInstance();
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function getTPS(): float
    {
        return $this->server->getTicksPerSecond();
    }

    public function getRoundedTPS(int $decimals = 1): float
    {
        return round($this->getTPS(), $decimals);
    }

    public function getColoredTPS(): float|string
    {
        $tps = $this->getTPS();

        if ($tps > 17.0) return TF::GREEN . $tps;
        if ($tps > 14.0) return TF::YELLOW . $tps;
        return TF::RED . $tps;
    }

    public function getOnlinePlayers(): int
    {
        return count($this->server->getOnlinePlayers());
    }

    public function getMaxPlayers(): int
    {
        return $this->server->getMaxPlayers();
    }

    public function getOnlinePercent(): float
    {
        $max = $this->getMaxPlayers();
        if ($max === 0) return 0.0;

        return round(($this->getOnlinePlayers() / $max) * 100, 1);
    }

    public function getUptime(): string
    {
        $uptime = (int)($this->getServer()->getTick() / 20);
        $hours = (int)($uptime / 3600);
        $minutes = (int)(($uptime % 3600) / 60);
        $seconds = $uptime % 60;
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }



    public function getMemoryUsage(): string
    {
        $memory = memory_get_usage(true);
        return $this->formatBytes($memory);
    }

    public function getMaxMemory(): string
    {
            $iniMemory = ini_get('memory_limit');
            return $iniMemory !== false ? $iniMemory : "Unlimited";

    }

    public function getMemoryInfo(): array
    {
        $memoryManager = $this->getServer()->getMemoryManager();

        return [
            "used" => memory_get_usage(true),
            "peak" => memory_get_peak_usage(true),
            "max" => $this->getMaxMemory()
        ];
    }

    public function displayMemoryInfo(): string
    {
        $memory = $this->getMemoryInfo();

        $info = [];
        $info[] = "§b» §eUsed: §a" . $this->formatBytes($memory['used']);
        $info[] = "§b» §ePeak: §6" . $this->formatBytes($memory['peak']);

        if($memory['max'] === -1) {
            $info[] = "§b» §eMax: §bUnlimited";
        } else {
            $info[] = "§b» §eMax: §b" . $memory['max'];
        }

        return implode("\n", $info);
    }

    public function getMemoryUsagePercent(): float
    {
        $usage = memory_get_usage(true);
        $peak = memory_get_peak_usage(true);
        return ($peak > 0) ? round(($usage / $peak) * 100, 1) : 0.0;
    }

    public function getWorldsCount(): int
    {
        return count($this->server->getWorldManager()->getWorlds());
    }

    public function getWorldsList(): array
    {
        $worlds = [];
        foreach ($this->server->getWorldManager()->getWorlds() as $world) {
            $worlds[] = $world->getDisplayName();
        }
        return $worlds;
    }

    public function getServerInfo(): array
    {
        $ip = $this->server->getIp();

        return [
            'tps' => $this->getTPS(),
            'online_players' => $this->getOnlinePlayers(),
            'max_players' => $this->getMaxPlayers(),
            'online_percent' => $this->getOnlinePercent(),
            'uptime' => $this->getUptime(),
            'memory_usage' => $this->getMemoryUsage(),
            'memory_percent' => $this->getMemoryUsagePercent(),
            'worlds_count' => $this->getWorldsCount(),
            'server_version' => $this->server->getVersion(),
            'api_version' => $this->server->getApiVersion(),
            'server_name' => $this->server->getName(),
            'server_ip' => $ip,
            'server_port' => $this->server->getPort(),
            'server_type' => $this->getServerType()
        ];
    }

    public function getServerType():string{
        $ip = $this->server->getIp();
        if ($ip === '0.0.0.0'){
            $server_type = 'localHost';
        }else{
            $server_type = 'Server';
        }
        return $server_type;
    }


    public function isServerHealthy(): bool
    {
        return $this->getTPS() >= 18.0;
    }

    public function getServerHealthStatus(): string
    {
        if ($this->isServerHealthy()) {
            return TF::GREEN . "Healthy";
        }

        if ($this->getTPS() < 15.0) {
            return TF::RED . "Critical";
        }

        return TF::YELLOW . "Warning";
    }

//    private function formatBytes(int $bytes): string         # method 1
//    {
//        $units = ['B', 'KB', 'MB', 'GB'];
//        $bytes = max($bytes, 0);
//        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
//        $pow = min($pow, count($units) - 1);
//        $bytes /= pow(1024, $pow);
//
//        return round($bytes, 2) . ' ' . $units[$pow];
//    }

    private function formatBytes(int $bytes): string           # method 2
    {
        if($bytes <= 0) return "0 B";

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $base = 1024;
        $exponent = (int)floor(log($bytes, $base));
        $exponent = min($exponent, count($units) - 1);

        $formatted = $bytes / pow($base, $exponent);
        return round($formatted, 2) . ' ' . $units[$exponent];
    }

    public function ChangeServerName(string $name):void{
        $this->server->getNetwork()->setName($name);
        $this->server->getNetwork()->updateName();
    }





}