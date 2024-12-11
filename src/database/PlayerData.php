<?php

namespace mineceit\data\players;

namespace MohamadRZ\gamemode1FFA\database;

class PlayerData
{
	private const TABLE_NAME = "player_data";

	public static function init(): void
	{
		$defaultKills = json_encode([
			"ffa_classic" => 0,
			"ffa_op" => 0,
			"ffa_combo" => 0,
			"ffa_archer" => 0,
			"ffa_sumo" => 0,
			"ffa_void" => 0,
			"ffa_build" => 0,
			"ffa_spleef" => 0,
		]);
		$defaultDeaths = json_encode([
			"ffa_classic" => 0,
			"ffa_op" => 0,
			"ffa_combo" => 0,
			"ffa_archer" => 0,
			"ffa_sumo" => 0,
			"ffa_void" => 0,
			"ffa_build" => 0,
			"ffa_spleef" => 0,
		]);

		SQLiteManager::execute("CREATE TABLE IF NOT EXISTS " . self::TABLE_NAME . " (
        player_name TEXT PRIMARY KEY,
        kills TEXT DEFAULT '$defaultKills',
        deaths TEXT DEFAULT '$defaultDeaths'
    )");
	}

	public static function createData(string $playerName): void
	{
		SQLiteManager::execute("INSERT OR IGNORE INTO " . self::TABLE_NAME . " (player_name) VALUES (:player_name)", [
			":player_name" => strtolower($playerName),
		]);
	}

	public static function getData(string $playerName): ?array
	{
		return SQLiteManager::fetch("SELECT * FROM " . self::TABLE_NAME . " WHERE player_name = :player_name", [
			":player_name" => strtolower($playerName),
		]);
	}

	public static function updateData(string $playerName, array $data): void
	{
		$query = "UPDATE " . self::TABLE_NAME . " SET ";
		$params = [":player_name" => strtolower($playerName)];
		foreach ($data as $key => $value) {
			$query .= "$key = :$key, ";
			$params[":$key"] = $value;
		}
		$query = rtrim($query, ", ") . " WHERE player_name = :player_name";
		SQLiteManager::execute($query, $params);
	}

	public static function deleteData(string $playerName): void
	{
		SQLiteManager::execute("DELETE FROM " . self::TABLE_NAME . " WHERE player_name = :player_name", [
			":player_name" => strtolower($playerName),
		]);
	}

	public static function updateKills(string $playerName, string $mode, int $kills): void
	{
		$currentKills = self::getKills($playerName);
		$currentKills[$mode] = $kills;

		SQLiteManager::execute("UPDATE " . self::TABLE_NAME . " SET kills = :kills WHERE player_name = :player_name", [
			":kills" => json_encode($currentKills),
			":player_name" => $playerName
		]);
	}

	public static function getKillCount(string $playerName, string $mode): int
	{
		$kills = self::getKills($playerName);
		return $kills[$mode] ?? 0;
	}

	public static function getKills(string $playerName): array
	{
		$result = SQLiteManager::query("SELECT kills FROM " . self::TABLE_NAME . " WHERE player_name = :player_name", [
			":player_name" => $playerName
		]);
		if ($result && isset($result[0]['kills'])) {
			return json_decode($result[0]['kills'], true) ?? [];
		}
		return [
			"ffa_classic" => 0,
			"ffa_op" => 0,
			"ffa_combo" => 0,
			"ffa_archer" => 0,
			"ffa_sumo" => 0,
			"ffa_void" => 0,
			"ffa_build" => 0,
			"ffa_spleef" => 0
		];
	}



	public static function updateDeaths(string $playerName, string $mode, int $Deaths): void
	{
		$currentDeaths = self::getDeaths($playerName);
		$currentDeaths[$mode] = $Deaths;

		SQLiteManager::execute("UPDATE " . self::TABLE_NAME . " SET deaths = :deaths WHERE player_name = :player_name", [
			":deaths" => json_encode($currentDeaths),
			":player_name" => $playerName
		]);
	}

	public static function getDeathsCount(string $playerName, string $mode): int
	{
		$Deaths = self::getDeaths($playerName);
		return $Deaths[$mode] ?? 0;
	}

	public static function getDeaths(string $playerName): array
	{
		$result = SQLiteManager::query("SELECT deaths FROM " . self::TABLE_NAME . " WHERE player_name = :player_name", [
			":player_name" => $playerName
		]);
		if ($result && isset($result[0]['deaths'])) {
			return json_decode($result[0]['deaths'], true) ?? [];
		}
		return [
			"ffa_classic" => 0,
			"ffa_op" => 0,
			"ffa_combo" => 0,
			"ffa_archer" => 0,
			"ffa_sumo" => 0,
			"ffa_void" => 0,
			"ffa_build" => 0,
			"ffa_spleef" => 0
		];
	}
}
