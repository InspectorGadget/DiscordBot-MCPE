<?php

/* 
 * Copyright (C) 2017 RTG
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace RTG\DiscordBot;

/* Essentials */
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use RTG\DiscordBot\Task;

class Loader extends PluginBase {
    
    public $cfg;
    
    public function onEnable() {
        
        @mkdir($this->getDataFolder());
        $this->cfg = new Config($this->getDataFolder() . 'config.yml', Config::YAML, array(
            "webhook" => "",
            "username" => "Bot",
            "# Shutdown",
            "enable" => false,
            "ticks" => 500,
            "shut_message" => ""
        ));
        $this->cfg->save();
        
        $period = $this->cfg->get("ticks");
        
        $this->getServer()->getScheduler()->scheduleTask(new Task($this), $period);
        
    }
    
    public function onDisable() {
        
        $this->cfg->save();
        
    }
    
}