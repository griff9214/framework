<?php


namespace Framework\Console;


use Psr\Container\ContainerInterface;

class ConsoleApplication
{
    private ContainerInterface $container;
    /**
     * @var ConsoleCommand[]
     */
    protected array $commands;

    public function __construct(ContainerInterface $container, array $commands)
    {
        $this->container = $container;
        foreach ($commands as $commandName => $commandClass) {
            $this->addCommand($commandClass);
        }
    }

    public function addCommand(string $commandClass): void
    {
        $commandInstance = $this->container->get($commandClass);
        if ($commandInstance instanceof ConsoleCommand) {
            $this->commands[] = $commandInstance;
        } else {
            throw new \InvalidArgumentException("Console command must be an instance of ConsoleCommand::class");
        }
    }

    public function run(ConsoleInput $input, ConsoleOutput $output): void
    {
        $commandName = $input->getCommandName();
        foreach ($this->commands as $command) {
            if ($command->getName() == $commandName) {
                $command->execute($input, $output);
                return;
            }
        }
        $output->writeLn("<red>May be you need help! Available commands list:</red>");
        foreach ($this->commands as $command) {
            $output->writeLn("<green>{$command->getName()}</green> - {$command->getDescription()}");
        }
    }
}