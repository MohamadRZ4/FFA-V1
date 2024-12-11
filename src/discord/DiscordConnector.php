<?php

namespace MohamadRZ\gamemode1FFA\discord;

class DiscordConnector
{
	private string $webhookUrl;

	public function __construct(string $webhookUrl)
	{
		$this->webhookUrl = $webhookUrl;
	}

	public function sendMessage(string $content): bool
	{
		$data = json_encode([
			"content" => $content
		]);

		return $this->sendRequest($data);
	}

	public function sendEmbed(array $embedData): bool
	{
		$data = json_encode([
			"embeds" => [$embedData]
		]);

		return $this->sendRequest($data);
	}

	private function sendRequest(string $data): bool
	{
		$ch = curl_init($this->webhookUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json'
		]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		return $httpCode === 204;
	}
}
