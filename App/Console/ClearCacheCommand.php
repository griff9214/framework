<?php


namespace App\Console;

use Framework\Console\ConsoleInput;
use Framework\Console\ConsoleOutput;
use Framework\Helpers\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class ClearCacheCommand extends Command
{
    private array $paths;

    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
        array_unshift($this->paths, 'ALL');
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName("cache:clear")
            ->setDescription('Clear cache')
            ->setHelp('This command allows you to clear App cache folders...')
            ->addArgument('paths', InputArgument::OPTIONAL, 'Paths to clear');
            //->setHelperSet($this->getApplication()->getHelperSet());
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $paths = $input->getArgument('paths');
        if (empty($paths)) {
            /**
             * @var
             * QuestionHelper $helper
             */
            $helper = $this->getHelper("question");
            $question = new ChoiceQuestion("What path do you want to clear?", $this->paths);
            $choose = $helper->ask($input, $output, $question);
            if ($choose === "ALL") {
                $paths = array_slice($this->paths, 1);
            } else {
                $paths[] = $choose;
            }
        }
        $output->writeLn("<fg=red>Clearing cache:</>");
        foreach ($paths as $path) {
            if (file_exists($path)) {
                echo "Removing: " . $path . PHP_EOL;
                FileSystem::delete($path);
            } else {
                echo "Skipped " . $path . PHP_EOL;
            }
        }
        $output->writeLn("<info>Done!</info>");
        return Command::SUCCESS;
    }

}