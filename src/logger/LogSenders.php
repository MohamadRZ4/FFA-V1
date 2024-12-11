<?php

namespace MohamadRZ\gamemode1FFA\logger;

use MohamadRZ\gamemode1FFA\discord\DiscordManager;
use MohamadRZ\gamemode1FFA\Main;
use MohamadRZ\gamemode1FFA\Utils;
use pocketmine\player\Player;
use pocketmine\Server;

class LogSenders
{
	public function sendLogToStaffs(string $log, string $type): void
	{
		$prefix = PerfixsLogger::getPrefix($type);
		$message = "$prefix $log";

		foreach (Server::getInstance()->getOnlinePlayers() as $player) {
			if ($player->hasPermission("stafflog")) {
				$player->sendMessage($message);
			}
		}
	}

	public function sendLogToDiscord(string $log, string $type): void
	{
		$webhookUrl = Main::WEBHOOKURL_DISCORD;
		if (empty($webhookUrl)) {
			Server::getInstance()->getLogger()->warning("Discord webhook URL is not set.");
			return;
		}

		$discordManager = new DiscordManager($webhookUrl);
		$prefix = PerfixsLogger::getPrefix($type);
		$color = Utils::minecraftColorToHex(PerfixsLogger::getPrefixColor($type));
		if ($color === null) {
			Server::getInstance()->getLogger()->warning("Invalid Minecraft color for Discord log.");
			return;
		}

		$discordManager->sendEmbed(
			"Log - $type",
			"$prefix $log",
			substr($color, 1)
		);
	}
}