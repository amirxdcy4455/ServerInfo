# ServerInfo Plugin

<p align="center">
  <img src="https://img.shields.io/badge/PocketMine-5.0.0+-blue.svg" alt="PocketMine Version">
  <img src="https://img.shields.io/badge/PHP-8.0+-purple.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
  <img src="https://img.shields.io/badge/API-Developer%20Friendly-green.svg" alt="API">
</p>

A comprehensive PocketMine-MP plugin that provides detailed server information through commands and a developer-friendly API for other plugins.

## 📋 Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Placeholders](#placeholders)
- [Developer API](#developer-api)
- [Examples](#examples)
- [Permissions](#permissions)

## ✨ Features

- 📊 **Real-time server statistics** (TPS, players, memory, uptime)
- 🎨 **Customizable message formatting** with color codes
- 🔧 **Developer-friendly API** for integration with other plugins
- ⚡ **Lightweight and efficient** performance
- 🎯 **Easy-to-use commands**
- 📝 **Fully configurable** display messages

## 📥 Installation

1. Download the latest `ServerInfo.phar` file from releases
2. Place it in your server's `plugins` folder
3. Restart your server
4. The plugin will generate default configuration files
5. Customize the plugin in `plugins/ServerInfo/config.yml`

## 🚀 Usage

### Basic Command
```bash
/serverinfo
# or use alias
/si
```

### Example Output
When you run the command, you'll see output similar to this: <br>
<img src="ServerInfo.png"></img>
## ⚙️ Configuration

Edit `plugins/ServerInfo/config.yml` to customize the display:

```yaml
# ServerInfo Configuration
# Customize the server info display message

messages:
  - "&8&e{border}&r &6&lServer Info &8&e{border}"
  - "&b» &fTPS: {server.tps_colored}&f &7({server.tps_rounded})"
  - "&b» &fPlayers: &a{server.players.online}&7/&a{server.players.max} &7(&a{server.players.percent}%&7)"
  - "&b» &fUptime: &a{server.uptime}"
  - "&b» &fWorlds: &a{server.worlds.count}"
  - "&b» &fVersion: &a{server.version}"
  - "&b» &fAPI: &a{server.api_version}"
  - "&b» &fIP: &a{server.ip}:{server.port}"
  - "&b» &fServer Type: &a{server_type}"
  - "&b» &fName: &a{server.name}"
  - "&b» &fServer Health: {server.health.status}"
  - "&b» &fMemory All Data : {line} {server.memory.allData}"
  - "&8&m                                                          "
```

## 🔤 Available Placeholders

### Server Performance
| Placeholder | Description | Example |
|-------------|-------------|---------|
| `{server.tps}` | Current TPS | `20` |
| `{server.tps_rounded}` | Rounded TPS (1 decimal) | `20.0` |
| `{server.tps_colored}` | Color-coded TPS | `§a20` |
| `{server.health.status}` | Server health status | `§aHealthy` |
| `{server.health.healthy}` | Is server healthy | `Yes` |

### Player Information
| Placeholder | Description | Example |
|-------------|-------------|---------|
| `{server.players.online}` | Online players count | `1` |
| `{server.players.max}` | Maximum players | `100` |
| `{server.players.percent}` | Online percentage | `1%` |

### Server Details
| Placeholder | Description | Example |
|-------------|-------------|---------|
| `{server.name}` | Server name | `PocketMine-MP` |
| `{server.motd}` | Server MOTD | `A PocketMine-MP Server` |
| `{server.version}` | Server version | `v1.21.50` |
| `{server.api_version}` | API version | `5.24.0` |
| `{server.ip}` | Server IP | `0.0.0.0` |
| `{server.port}` | Server port | `19132` |
| `{server_type}` | Server type | `localHost` |

### Memory & Resources
| Placeholder | Description | Example |
|-------------|-------------|---------|
| `{server.uptime}` | Server uptime | `00:00:43` |
| `{server.worlds.count}` | Number of loaded worlds | `1` |
| `{server.memory.usage}` | Current memory usage | `102 MB` |
| `{server.memory.max}` | Maximum memory | `2000M` |
| `{server.memory.percent}` | Memory usage percentage | `5.1%` |
| `{server.memory.allData}` | Detailed memory information | Multi-line output |

### Formatting
| Placeholder | Description |
|-------------|-------------|
| `{border}` | Decorative border line |
| `{line}` | Line break |
| `{color.black}` - `{color.white}` | Color codes |
| `{color.reset}` | Reset color formatting |

## 🛠 Developer API

### Getting Started

```php
use Amirxd\Server\utils\ServerAPI;

// Initialize the API
$api = new ServerAPI();
```

### Core Methods

#### Server Performance Methods
```php
$api->getTPS();                    // float - Current TPS
$api->getRoundedTPS($decimals);    // float - Rounded TPS
$api->getColoredTPS();             // string - Color-coded TPS
$api->isServerHealthy();           // bool - Server health check
$api->getServerHealthStatus();     // string - Health status with colors
```

#### Player Management
```php
$api->getOnlinePlayers();          // int - Online players count
$api->getMaxPlayers();             // int - Max players
$api->getOnlinePercent();          // float - Online percentage
```

#### Memory Information
```php
$api->getMemoryUsage();            // string - Formatted memory usage
$api->getMaxMemory();              // string - Max memory limit
$api->getMemoryUsagePercent();     // float - Memory usage percentage
$api->getMemoryInfo();             // array - Detailed memory info
$api->displayMemoryInfo();         // string - Formatted memory display
```

#### World Information
```php
$api->getWorldsCount();            // int - Number of worlds
$api->getWorldsList();             // array - List of world names
```

#### Server Information
```php
$api->getServerInfo();             // array - Complete server info
$api->getUptime();                 // string - Server uptime
$api->getServerType();             // string - Server type
$api->ChangeServerName($name);     // void - Change server name
```

## 💡 Examples

### Basic Usage Example
```php
use Amirxd\Server\utils\ServerAPI;

class MyPlugin extends PluginBase {
    
    public function displayServerStatus(Player $player) {
        $api = new ServerAPI();
        
        $player->sendMessage("§6=== Server Status ===");
        $player->sendMessage("§bTPS: " . $api->getColoredTPS());
        $player->sendMessage("§bPlayers: §a" . $api->getOnlinePlayers() . "§7/§a" . $api->getMaxPlayers());
        $player->sendMessage("§bUptime: §a" . $api->getUptime());
        $player->sendMessage("§bMemory: §a" . $api->getMemoryUsage());
    }
}
```

### Advanced Integration
```php
use Amirxd\Server\utils\ServerAPI;
use Amirxd\Server\utils\Formatter;

class AdvancedMonitor extends PluginBase {
    
    public function checkServerHealth() {
        $api = new ServerAPI();
        
        if (!$api->isServerHealthy()) {
            $this->getLogger()->warning("Server health check failed!");
            $this->getLogger()->info("TPS: " . $api->getTPS());
            $this->getLogger()->info("Memory: " . $api->getMemoryUsage());
            $this->getLogger()->info("Health Status: " . $api->getServerHealthStatus());
        }
    }
    
    public function getFormattedStats(): string {
        $formatter = new Formatter();
        return $formatter->format(
            "&6Server Stats: &fTPS: {server.tps_colored}, " .
            "Players: &a{server.players.online}&7/&a{server.players.max}, " .
            "Memory: &e{server.memory.usage}"
        );
    }
}
```

### Using Formatter Class
```php
use Amirxd\Server\utils\Formatter;

$formatter = new Formatter();

// Custom message with placeholders
$customMessage = "&6» &fOur Server Stats:{line}" .
                 "&bTPS: {server.tps_colored}{line}" .
                 "&bPlayers: &a{server.players.online}&7/&a{server.players.max}{line}" .
                 "&bUptime: &e{server.uptime}";

$formatted = $formatter->format($customMessage);
$player->sendMessage($formatted);
```

### Complete Server Info Array
```php
$api = new ServerAPI();
$serverInfo = $api->getServerInfo();

/*
Returns:
[
    'tps' => 20.0,
    'online_players' => 1,
    'max_players' => 100,
    'online_percent' => 1.0,
    'uptime' => '00:00:43',
    'memory_usage' => '102 MB',
    'memory_percent' => 5.1,
    'worlds_count' => 1,
    'server_version' => 'v1.21.50',
    'api_version' => '5.24.0',
    'server_name' => 'PocketMine-MP',
    'server_ip' => '0.0.0.0',
    'server_port' => 19132,
    'server_type' => 'localHost'
]
*/
```

## 🔒 Permissions

| Permission | Description | Default |
|------------|-------------|---------|
| `serverinfo.cmd` | Access to `/serverinfo` command | `op` |

## 🤝 Support

If you encounter any issues:
1. Check your PocketMine-MP version compatibility
2. Verify PHP version meets requirements (8.0+)
3. Review the configuration file for errors
4. Check server logs for specific error messages

## 📄 License

This project is licensed under the MIT License.

---

**Developer**: Amirxd  
**PocketMine-MP**: 5.0.0+  
**PHP Requirement**: 8.0+  


For more information, visit the [GitHub repository](https://github.com/amirxdcy4455/ServerInfo).
