<?php
declare(strict_types=1);
namespace Services;


use Adapter\DatabaseInterface;
//use Models\User;

class UserService implements UserServiceInterface
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function register($username, $password): bool
    {
        $stmt = $this->db->prepare("
                INSERT INTO members
                SET 
                    name = :username, 
                    pass = :pass
        ");

        return $stmt->execute(
            [
                'pass' => $password,
                'username' => $username
            ]
        );
    }

    public function exists($username): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM members WHERE user = ?");
        $stmt->execute(
            [
                $username
            ]
        );

        return !!$stmt->fetchRow();
    }

    public function isPasswordMatch($password, $confirm): bool
    {
        return $password == $confirm;
    }

    public function login($username, $password)
    {
        $stmt = $this->db->prepare("
            SELECT user, pass FROM members
            WHERE user = ?
        ");

        $stmt->execute(
            [
                $username
            ]
        );

        $user = $stmt->fetchRow();

        if (!$user) {
            throw new \Exception("Username does not exist");
        }

        if ($user['password'] != $password) {
            throw new \Exception("Password mismatch");
        }

        return $user['user'];
    }


    public function getInfo($user): User
    {
        $stmt = $this->db->prepare("
            SELECT user
            FROM members
            WHERE user = ?
        ");
        $stmt->execute([$user]);

        return $stmt->fetchObject(User::class);
    }
}