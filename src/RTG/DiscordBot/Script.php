<?php

/* 
 * 
 *   _____  _______  _____  _____           _____            _             
 *  |  __ \|__   __|/ ____||  __ \         / ____|          | |            
 *  | |__) |  | |  | |  __ | |  | |  __ _ | |      ___    __| |  ___  _ __ 
 *  |  _  /   | |  | | |_ || |  | | / _` || |     / _ \  / _` | / _ \| '__|
 *  | | \ \   | |  | |__| || |__| || (_| || |____| (_) || (_| ||  __/| |   
 *  |_|  \_\  |_|   \_____||_____/  \__,_| \_____|\___/  \__,_| \___||_|
 * 
 * 
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
 * 
 * 
 */

class Script 
{
    
    public function __construct($url, $username) {
        $avatar = "http://benjiflaming.com/wp-content/uploads/2010/06/white.png";
        
        $ch = curl_init();
        
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode(array(
                "content" => "This is a test message",
                "username" => $username,
                "avatar_url" => $avatar
            ))
        ));
        
        $res = curl_exec($ch);
        $error = curl_error($ch);
        
        if ($res === false) {
            echo "Nope - " . $error;
        } else {
            echo "sent";
        }
        
    }
    
    
    
}
