<?php


namespace Framework\Console;


abstract class ConsoleCommand
{
    protected string $name;
    protected string $description;

    public function __construct(string $name = null)
    {
        if ($name) {
            $this->setName($name);
        } else {
            $this->setName(static::class);
        }
        $this->configure();
    }

    abstract public function execute(ConsoleInput $input, ConsoleOutput $output): void;

    public function configure()
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}