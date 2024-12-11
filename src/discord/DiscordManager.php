<?php

namespace MohamadRZ\gamemode1FFA\discord;

class DiscordManager
{
	private DiscordConnector $connector;

	public function __construct(string $webhookUrl)
	{
		$this->connector = new DiscordConnector($webhookUrl);
	}

	public function sendMessage(string $message): bool
	{
		return $this->connector->sendMessage($message);
	}

	public function sendEmbed(string $title, string $description, string $color): bool
	{
		$embed = [
			"title" => $title,
			"description" => $description,
			"color" => hexdec($color)
		];

		return $this->connector->sendEmbed($embed);
	}
}
