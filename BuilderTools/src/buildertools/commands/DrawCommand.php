<?php

/**
 * Copyright 2018 CzechPMDevs
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace buildertools\commands;

use buildertools\BuilderTools;
use buildertools\editors\Printer;
use buildertools\Selectors;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

/**
 * Class DrawCommand
 * @package buildertools\commands
 */
class DrawCommand extends Command implements PluginIdentifiableCommand {

    /** @var int $minBrush */
    private $minBrush = 1;

    /** @var int $maxBrush */
    private $maxBrush = 6;

    /**
     * DrawCommand constructor.
     */
    public function __construct() {
        parent::__construct("/draw", "Draw witch blocks", null, []);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player) {
            $sender->sendMessage("§cThis command can be used only in-game!");
            return;
        }
        if(!$sender->hasPermission("bt.cmd.draw")) {
            $sender->sendMessage("§cYou have not permissions to use this command!");
            return;
        }
        if(empty($args[0])) {
            $sender->sendMessage("§cUsage: §7//draw <cube|sphere|custom|off> [brush: {$this->minBrush}-{$this->maxBrush} | on | off]  [fall = false]");
            return;
        }
        if(!in_array(strval($args[0]), ["on", "off", "cube", "sphere", "custom"])) {
            $sender->sendMessage("§cUsage: §7//draw <cube|sphere|custom|off> [brush: {$this->minBrush}-{$this->maxBrush}]  [fall = false]");
            return;
        }
        if(isset($args[1]) && is_numeric($args[1]) && intval($args[1]) >= $this->maxBrush && intval($args[1]) <= $this->minBrush) {
            $sender->sendMessage("§cBrush #{$args[1]} does not exists!");
            return;
        }
        if($args[0] == "off") {
            Selectors::removeDrawnigPlayer($sender);
            $sender->sendMessage(BuilderTools::getPrefix()."§aBrush removed!");
            return;
        }

        $mode = 0;

        if($args[0] == "cube") $mode = Printer::CUBE;
        if($args[0] == "sphere") $mode = Printer::SPHERE;
        if($args[0] == "hsphere") $mode = Printer::HSPHERE;
        if($args[0] == "custom") $mode = -1;

        $brush = 1;

        if(isset($args[1]) && is_numeric($args[1])) {
            $brush = intval($args[1]);
        }

        $fall = false;

        if(isset($args[2]) && $args[2] == "true") {
            $fall = true;
        }

        Selectors::addDrawingPlayer($sender, $brush, $mode, $fall);

        $fall = $fall ? "§2true§a" : "§cfalse§a";

        $sender->sendMessage(BuilderTools::getPrefix()."§aSelected brush §7#{$brush} §a(shape: §7{$args[1]} §aFall:&$fall)!");
    }

    /**
     * @return Plugin|BuilderTools
     */
    public function getPlugin(): Plugin {
        return BuilderTools::getInstance();
    }
}