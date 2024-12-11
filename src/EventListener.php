<?php

namespace MohamadRZ\gamemode1FFA;
use MohamadRZ\gamemode1FFA\database\PlayerData;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class EventListener implements Listener
{
	public function onJoin(PlayerJoinEvent $event) {
		$player = $event->getPlayer();

		PlayerData::createData($player->getName());
	}
}