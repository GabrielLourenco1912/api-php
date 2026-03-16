<?php
namespace App\DAOs\DAOsImpl;

use App\DAOs\GenericDAO;
use config\database\database;
use App\Models\Users;

/**
* @implements GenericDAO<Users>
*/
class UsersDAOImpl implements GenericDAO
{
    private database $db;

    function __construct(database $db) {
        $this->db = $db;
    }

    public function save(object $entity): object {
        if (!$entity instanceof Users) {
            throw new \InvalidArgumentException("Entidade inválida para UsersDAOImpl");
        }
        $this->db->transaction(function (\PDO $pdo) use (&$entity) {
            $sql = "INSERT INTO users (name, email, role, senha) VALUES (:name, :email, :role, :senha)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $entity->getName(),
                ':email' => $entity->getEmail(),
                ':role' => $entity->getRole(),
                ':senha' => $entity->getSenha()
            ]);
             $entity->setId((int) $pdo->lastInsertId());
        });
        return $entity;
    }

    public function findById(int|string $id): ?object {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return new Users((int) $row['id'], (string) $row['name'], (string) $row['email'], (string) $row['role'], (string) $row['senha']);
    }

    public function findByEmail(string $email): ?object {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return new Users((int) $row['id'], (string) $row['name'], (string) $row['email'], (string) $row['role'], (string) $row['senha']);
    }

    public function findAll(): array {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM users";
        $stmt = $pdo->query($sql);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $array = array_map(
            fn($row) => new Users((int) $row['id'], (string) $row['name'], (string) $row['email'], (string) $row['role'], (string) $row['senha']),
            $rows
        );
        return $array;
    }


    public function update(object $entity): object {
        if (!$entity instanceof Users) {
            throw new \InvalidArgumentException("Entidade inválida para UsersDAOImpl");
        }
        $this->db->transaction(function (\PDO $pdo) use (&$entity) {
            $sql = "UPDATE users SET id = :id, name = :name, email = :email, role = :role, senha = :senha WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $entity->getId(),
                ':name' => $entity->getName(),
                ':email' => $entity->getEmail(),
                ':role' => $entity->getRole(),
                ':senha' => $entity->getSenha()
            ]);
            if ($stmt->rowCount() === 0) {
                throw new \RuntimeException("Nenhum registro foi atualizado.");
            }
        });
        return $entity;
    }

    public function deleteById(int|string $id): void {
        $this->db->transaction(function (\PDO $pdo) use ($id) {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
        });
    }
}