<?php

namespace MohamadRZ\gamemode1FFA\database;

use SQLite3;

class SQLiteManager
{
	private static ?SQLite3 $db = null;

	public static function init(string $dbPath): void
	{
		if (self::$db === null) {
			self::$db = new SQLite3($dbPath);
		}
	}

	public static function execute(string $query, array $params = []): void
	{
		$stmt = self::$db->prepare($query);
		foreach ($params as $key => $value) {
			$stmt->bindValue($key, $value, self::getSQLiteType($value));
		}
		$stmt->execute();
	}

	public static function fetch(string $query, array $params = []): ?array
	{
		$stmt = self::$db->prepare($query);
		foreach ($params as $key => $value) {
			$stmt->bindValue($key, $value, self::getSQLiteType($value));
		}
		$result = $stmt->execute();
		return $result->fetchArray(SQLITE3_ASSOC) ?: null;
	}

	public static function fetchAll(string $query, array $params = []): array
	{
		$stmt = self::$db->prepare($query);
		foreach ($params as $key => $value) {
			$stmt->bindValue($key, $value, self::getSQLiteType($value));
		}
		$result = $stmt->execute();
		$data = [];
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public static function query(string $query, array $params = []): array
	{
		$stmt = self::$db->prepare($query);
		if ($stmt === false) {
			throw new \RuntimeException("Failed to prepare statement: " . self::$db->lastErrorMsg());
		}

		foreach ($params as $key => $value) {
			$stmt->bindValue($key, $value, is_int($value) ? SQLITE3_INTEGER : SQLITE3_TEXT);
		}

		$result = $stmt->execute();
		if ($result === false) {
			throw new \RuntimeException("Failed to execute query: " . self::$db->lastErrorMsg());
		}

		$data = [];
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$data[] = $row;
		}

		$result->finalize();
		$stmt->close();

		return $data;
	}

	public static function clearTable(string $table): void
	{
		self::execute("DELETE FROM $table");
	}

	private static function getSQLiteType($value): int
	{
		return match (gettype($value)) {
			"integer" => SQLITE3_INTEGER,
			"double" => SQLITE3_FLOAT,
			"boolean" => SQLITE3_INTEGER,
			"string" => SQLITE3_TEXT,
			default => SQLITE3_NULL,
		};
	}
}
