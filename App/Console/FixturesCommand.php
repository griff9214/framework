<?php


namespace App\Console;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var string
     */
    private string $fixturesPath;

    public function __construct(EntityManagerInterface $em, string $fixturesPath, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->fixturesPath = $fixturesPath;
    }

    public function configure()
    {
        $this
            ->setName("fixtures:execute")
            ->setDescription('Generate fake data')
            ->setHelp('This command allows you to Generate fake data to DB');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<comment>Loading Fixtures</comment>");
        $loader = new Loader();
        $loader->loadFromDirectory($this->fixturesPath);

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());
        $output->writeLn("<info>Done!</info>");
        return Command::SUCCESS;
    }
}