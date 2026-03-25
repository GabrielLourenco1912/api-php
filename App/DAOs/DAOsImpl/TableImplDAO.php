<?php

namespace App\DAOs\DAOsImpl;

use config\database\database;

class TableImplDAO {
    private database $db;

    function __construct(database $db) {
        $this->db = $db;
    }

    function sanitizeInput($input) {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $input);
    }
    function createTable(array $columnsInput, $tableName) {
        $this->db->transaction(function(\PDO $pdo) use ($columnsInput, $tableName) {
            $sqlLines = [];
            $constraints = [];
            $indexes = [];

            foreach ($columnsInput as $col) {
                $name = $this->sanitizeInput($col['name']);
                $type = $this->sanitizeInput($col['type']);
                $length = filter_var($col['length'] ?? null, FILTER_SANITIZE_NUMBER_INT);

                $colDefinition = "$name $type";

                if (!empty($length) && in_array($type, ['VARCHAR', 'CHAR', 'DECIMAL'])) {
                    $colDefinition .= "($length)";
                }

                if (isset($col['not_null']) && $col['not_null'] == '1') {
                    $colDefinition .= " NOT NULL";
                }

                if (isset($col['ai']) && $col['ai'] == '1') {
                    $colDefinition .= " GENERATED ALWAYS AS IDENTITY";
                }

                $keyType = $col['key'] ?? '';

                switch ($keyType) {
                    case 'PRIMARY':
                        $colDefinition .= " PRIMARY KEY";
                        break;
                    case 'UNIQUE':
                        $colDefinition .= " UNIQUE";
                        break;
                    case 'FOREIGN':
                        $fkTable = $this->sanitizeInput($col['fk_table']);
                        $fkCol = $this->sanitizeInput($col['fk_column']);

                        if ($fkTable && $fkCol) {
                            $constraints[] = "CONSTRAINT fk_{$tableName}_{$name} FOREIGN KEY ($name) REFERENCES $fkTable($fkCol)";
                        }
                        break;
                    case 'INDEX':
                        $indexes[] = "CREATE INDEX idx_{$tableName}_{$name} ON $tableName($name);";
                        break;
                }

                $sqlLines[] = $colDefinition;
            }

            $allDefinitions = array_merge($sqlLines, $constraints);

            $body = implode(",\n    ", $allDefinitions);

            $sqlIndex = implode("\n", $indexes);

            $sqlTable = "CREATE TABLE $tableName (\n    $body\n);";

            $sql = $sqlTable . "\n" . $sqlIndex;

            echo "<pre>" . $sql . "</pre>";

            $pdo->exec($sql);
        });
    }
    public function getSchemaTables() {
        $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'";
        $stmt = $this->db->getConnection()->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function deleteTable(string $tableName): void
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            throw new \Exception("Nome de tabela inválido.", 400);
        }

        $sql = "DROP TABLE IF EXISTS \"$tableName\" CASCADE";

        $this->db->getConnection()->exec($sql);
    }
}