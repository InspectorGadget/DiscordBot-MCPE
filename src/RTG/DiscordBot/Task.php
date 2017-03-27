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
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;

use RTG\DiscordBot\Loader;

class Task extends PluginTask {
    
    public $plugin;
    
    public function __construct(Loader $plugin) {
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    
    public function onRun($currentTick) {
        
            if($this->plugin->cfg->get("enable") === true) {
                
                $command = "restart";
                
                $msg = $this->plugin->cfg->get("shut_message");
                $user = $this->plugin->cfg->get("username");

                /* Thanks Niekert for these lines! */
                
                $curl  = curl_init();
                $line = array("content" => $msg, "username" => "$user");
                
                    curl_setopt($curl, CURLOPT_URL, $this->plugin->cfg->get("webhook"));
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $line);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    
                    curl_exec($curl);
                    
                /* ------ */
                    
                    $this->getLogger()->warning("Bot says GoodBye!");
                    
                $this->plugin->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender, $command);
                       
            }
        
    }
    
}