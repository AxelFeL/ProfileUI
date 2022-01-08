<?php

namespace AxelFeL\Stats;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use jojoe77777\FormAPI\SimpleForm;

class Profile extends PluginBase implements Listener{
    
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Plugin ProfileUI Enabled By AxelFeL!");
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
    switch($cmd->getName()){
      case "stats":
        if($sender instanceof Player){
          $this->openMyForm($sender);
        }else{
          $sender->sendMessage("§cUse this command in game");
        }
      break;
    }
    return true;
  }
    
    public function openMyForm($sender){
        $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if($result === null){
                return true;
            }
            switch($result){
                case 0:
                    
                break;
                
             }
        });
        $p = $sender;
        $name = $p->getName();
        $rank = $this->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->getGroup($p)->getName();
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $date = date("d/m/Y H:i:s");
        $money = $eco->myMoney($p);
        $ping = $p->getNetworkSession()->getPing();
        $world = $p->getWorld()->getProvider()->getWorldData()->getName();
        $x = $p->getPosition()->getX();
        $y = $p->getPosition()->getY();
        $z = $p->getPosition()->getZ();
        $form->setTitle("§bProfile");
        $form->setContent("This is your profile on this server!\n\n§7".$date."\n§fName : §a".$name."\n§fRank : §a".$rank."\n§fMoney : §a".$money."\n§fPing : §a".$ping."\n§fWorld/Map : §a".$world."\n§fPosition : §a".$x." ".$y." ".$z."\n§fFirst Join : §a".date("F, j Y H:i:s", $sender->getFirstPlayed() / 1000)." WIB");
        $form->addButton("EXIT",0, "textures/ui/cancel");
        $form->sendToPlayer($sender);
        return $form;
    }
}
