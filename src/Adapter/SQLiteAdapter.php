<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Adapter;

use BPM\OwnCdn\Exception\DatabaseException;
use SQLite3;

class SQLiteAdapter
{
    private const DATABASE_NAME = DATABASE_DIR . '/own-cdn.sqlite3';

    /**
     * @throws DatabaseException
     */
    public function fetchOne(string $tableName, string $attribute, string $value): null|object|array
    {
        $sqlite = new SQLite3(self::DATABASE_NAME);
        $result = $sqlite->querySingle(
            'SELECT * FROM ' . $tableName . ' WHERE "' . $attribute . '" = "' . $value . '"',
            true,
        );

        if ($result === false) {
            throw new DatabaseException('Problem with DB: ' . $sqlite->lastErrorMsg());
        }

        if ($result === []) {
            return null;
        }

        return $result;
    }

    /**
     * @param string[] $updateArray
     * @throws DatabaseException
     */
    public function update(string $tableName, string $whereAttribute, string $whereValue, array $updateArray): void
    {
        $whereAttributes = [];
        foreach ($updateArray as $colum => $value) {
            $whereAttributes[] = '\'' . $colum . '\' = \'' . $value . '\'';
        }

        $sqlite = new SQLite3(self::DATABASE_NAME);
        if (
            $sqlite->exec(
                'UPDATE ' . $tableName . ' SET ' . implode(', ', $whereAttributes) . ' WHERE ' . $whereAttribute . ' = \'' . $whereValue . '\'',
            )
            === false
        ) {
            throw new DatabaseException('Problem with DB: ' . $sqlite->lastErrorMsg());
        }
    }

    /**
     * @throws DatabaseException
     */
    public function insert(string $tableName, array $insertArray): bool
    {
        $sqlite = new SQLite3(self::DATABASE_NAME);

        if ($insertArray !== []) {
            $insertArray = array_map(
                static function ($value) {
                    if (is_bool($value)) {
                        return $value ? '1': '0';
                    }

                    return $value;
                },
                $insertArray,
            );

            $result = $sqlite->exec(
                'INSERT INTO ' . $tableName . ' (\'' . implode('\',\'', array_keys($insertArray)) . '\') '
                . 'VALUES (\'' . implode('\',\'', array_values($insertArray)) . '\')'
            );
        } else {
            return false;
        }

        if ($result === false) {
            throw new DatabaseException('Problem with DB: ' . $sqlite->lastErrorMsg());
        }

        return $result;
    }
}
