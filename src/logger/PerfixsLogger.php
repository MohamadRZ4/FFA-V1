<?php

namespace MohamadRZ\gamemode1FFA\logger;

use pocketmine\utils\TextFormat;

class PerfixsLogger
{
	const WARNING = "warning";
	const INFO = "info";
	const DANGER = "danger";
	const ERROR = "error";

	public static function getPrefix(string $type): string {
		switch (strtolower($type)) {
			case "warning":
				return "[WARNING]";
			case "danger":
				return "[DANGER]";
			case "error":
				return "[ERROR]";
			default:
				return "[INFO]";
		}
	}

	public static function getPrefixColor(string $type): string {
		switch (strtolower($type)) {
			case "warning":
				return TextFormat::YELLOW;
			case "danger":
				return TextFormat::RED;
			case "error":
				return TextFormat::DARK_RED;
			default:
				return TextFormat::WHITE;
		}
	}
}