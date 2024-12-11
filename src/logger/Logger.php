<?php

namespace MohamadRZ\gamemode1FFA\logger;

use MohamadRZ\gamemode1FFA\Main;
use pocketmine\Server;

class Logger
{
	private bool $logger = true;
	public string $logFilePath = "";

	public function __construct() {
		if (!Main::getMain()->getFeatureAvailability("logger")) {
			$this->logger = false;
		}
		$this->logFilePath = Main::getMain()->getDataFolder() . "FFA-log.log";

		$this->createLogDirectoryIfNotExists();
	}

	private function createLogDirectoryIfNotExists(): void {
		$logDirectory = dirname($this->logFilePath);
		if (!is_dir($logDirectory)) {
			if (!mkdir($logDirectory, 0777, true) && !is_dir($logDirectory)) {
				return;
			}
		}
	}

	/**
	 * @throws \Exception
	 */
	public function logging(string $log, string $type = "info"): bool {
		if (!$this->logger) {
			return false;
		}
		$prefix = PerfixsLogger::getPrefix($type);
		$formattedLog = "[" . date("Y-m-d H:i:s") . "] " . $prefix . " " . $log;

		$this->writeToFile($formattedLog);
		(new LogSenders())->sendLogToDiscord($log, $type);
		(new LogSenders())->sendLogToStaffs($log, $type);

		return true;
	}


	private function writeToFile(string $log): void {
		try {
			$fileHandle = fopen($this->logFilePath, "a");
			if ($fileHandle === false) {
				return;
			}

			if (fwrite($fileHandle, $log . PHP_EOL) === false) {
				return;
			}

			fclose($fileHandle);
		} catch (\Exception $e) {
			return;
		}
	}

}
