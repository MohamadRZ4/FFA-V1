<?php

namespace MohamadRZ\gamemode1FFA;

use pocketmine\utils\TextFormat;

class Utils
{

	public static function minecraftColorToHex(string $minecraftColor): ?string
	{
		$colorMap = [
			TextFormat::BLACK => "#000000",
			TextFormat::DARK_BLUE => "#0000AA",
			TextFormat::DARK_GREEN => "#00AA00",
			TextFormat::DARK_AQUA => "#00AAAA",
			TextFormat::DARK_RED => "#AA0000",
			TextFormat::DARK_PURPLE => "#AA00AA",
			TextFormat::GOLD => "#FFAA00",
			TextFormat::GRAY => "#AAAAAA",
			TextFormat::DARK_GRAY => "#555555",
			TextFormat::BLUE => "#5555FF",
			TextFormat::GREEN => "#55FF55",
			TextFormat::AQUA => "#55FFFF",
			TextFormat::RED => "#FF5555",
			TextFormat::LIGHT_PURPLE => "#FF55FF",
			TextFormat::YELLOW => "#FFFF55",
			TextFormat::WHITE => "#FFFFFF",
		];

		return $colorMap[$minecraftColor] ?? null;
	}
}
