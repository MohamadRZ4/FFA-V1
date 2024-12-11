<?php

declare(strict_types=1);

namespace MohamadRZ\gamemode1FFA;

use MohamadRZ\gamemode1FFA\database\PlayerData;
use MohamadRZ\gamemode1FFA\database\SQLiteManager;
use MohamadRZ\gamemode1FFA\discord\DiscordConnector;
use MohamadRZ\gamemode1FFA\logger\Logger;
use MohamadRZ\gamemode1FFA\logger\PerfixsLogger;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	private static Main $main;
	private $logger;

	private DiscordConnector $discordManager;
	const WEBHOOKURL_DISCORD = "https://discord.com/api/webhooks/1212009695166857276/-tbo1Z-AJVM7PU0lY7PxY982iBEAdTPkWkC-fmtE5SjK7zQUfsaMuiEslD0hMJc8wGEw";

	private $availabilityOfFeatures = [
		"logger" => true,
		/*"" => true,*/
	];

	protected function onEnable(): void
	{
		parent::onEnable();
		self::$main = $this;

		$this->discordManager = new DiscordConnector(self::WEBHOOKURL_DISCORD);

		$this->logger = new Logger();

		$dbPath = $this->getDataFolder() . "data.db";

		if (!file_exists($dbPath)) {
			@mkdir(dirname($dbPath), 0755, true);
			touch($dbPath);
		}

		SQLiteManager::init($dbPath);
		PlayerData::init();

	}



	protected function onDisable(): void
	{
		parent::onDisable(); // TODO: Change the autogenerated stub
	}




#################################################
#################################################
#################################################
#################################################
#################################################
#################################################




	public static function getMain(): Main
	{
		return self::$main;
	}

	public function logger(): Logger
	{
		return $this->logger;
	}

	public function setFeatureAvailability(string $featureName, bool $status): ?bool {
		if (array_key_exists($featureName, $this->availabilityOfFeatures)) {
			$this->availabilityOfFeatures[$featureName] = $status;
			return true;
		} else {
			return null;
		}
	}

	public function getFeatureAvailability(string $featureName): ?bool {
		if (array_key_exists($featureName, $this->availabilityOfFeatures)) {
			return $this->availabilityOfFeatures[$featureName];
		} else {
			return null;
		}
	}
}