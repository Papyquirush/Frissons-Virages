<?php

namespace App\Command;

use App\Service\CoasterService;
use App\Service\CoasterDatabaseService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\ProgressBar;

#[AsCommand(name: 'app:import-coasters')]
class ImportCoastersCommand extends Command
{
    public function __construct(private CoasterService $coasterService,
                                private CoasterDatabaseService $coasterDatabaseService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import coasters from Captain Coaster API')
            ->setHelp('This command allows you to import coasters from Captain Coaster API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        $progressBar = new ProgressBar($output, 1000);
        $progressBar->start();

        $coasters = [];
        for ($i = 0; $i <= 0; $i++) {
            $coasters[] = $this->coasterService->getCoasterById($i);
            $progressBar->advance();
        }

        $progressBar->finish();


        $coasters = array_filter($coasters, function($coaster) {
            return !empty($coaster);
        });

        $this->coasterDatabaseService->saveCoasters($coasters);

        $io->success('Coasters imported successfully!');

        return Command::SUCCESS;
    }
}