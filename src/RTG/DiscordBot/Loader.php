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
use pocketmine\event\Listener;

use RTG\DiscordBot\TaskMCPE;

class Loader extends PluginBase implements Listener {
    
    public $cfg;
    
    public function onEnable() {
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
            
        @mkdir($this->getDataFolder());
        $this->cfg = new Config($this->getDataFolder() . 'config.yml', Config::YAML, array(
            "webhook" => "",
            "username" => "",
            "serverhost" => "",
            "# Shutdown",
            "enable" => false,
            "ticks" => 1,
            "shut_message" => ""
        ));
        
        $period = $this->cfg->get("ticks");
        
        $this->getServer()->getScheduler()->scheduleTask(new TaskMCPE($this), $period);
        
        if($this->cfg->get("serverhost") === "") {
            $this->getLogger()->warning("Make sure you have set your ServerHost before using this plugin!");
            $this->setEnabled(false);
        }
        
    }
    
    public function run() {
        
        if($this->cfg->get("enable") === true) {
                
            $this->getLogger()->warning("hey");
                
            $command = "say hi"; // used for testing!
                
            $msg = $this->cfg->get("shut_message");
            $user = $this->cfg->get("username");
            $url = $this->cfg->get("webhook");
            $host = $this->cfg->get("serverhost");

            /* Thanks Niekert for these lines! */
                
            $curl  = curl_init();
            $line = array("content" => $msg, "username" => "$user");
                
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($line));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    
            curl_exec($curl);
                    
            /* ------ */
            
            if($host === strtolower("multicraft")) {
                $this->getLogger()->warning("Good bye!");
                $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender, $command);
            }
            else {
                $this->getLogger()->warning("You can't use this function on other servers yet!");
                $this->setEnabled(false);
            }
        
        }
        
    }
    
    public function onDisable() {
        
    }
    
}