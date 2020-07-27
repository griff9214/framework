<?php


namespace Framework\Container\Factories\db;

use Framework\Container\Factories\FactoryInterface;
use PDO;
use Psr\Container\ContainerInterface;

class PDOFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        $database = $c->get("params")["pdo"]["database"];
        $user = $c->get("params")["pdo"]["username"];
        $password = $c->get("params")["pdo"]["password"];
        $options = $c->get("params")["pdo"]["options"];
        $dsn = "sqlite:$database";
        return new PDO($dsn, $user, $password, $options);
    }
}