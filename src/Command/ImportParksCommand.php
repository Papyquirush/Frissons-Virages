<?php

namespace App\Command;



use App\Service\ParkDatabaseService;
use App\Service\ParkService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\ProgressBar;

#[AsCommand(name: 'app:import-parks')]
class ImportParksCommand extends Command {

    public function __construct(private ParkService $parkService,
                                private ParkDatabaseService $parkDatabaseService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import parks from Captain Coaster API')
            ->setHelp('This command allows you to import parks from Captain Coaster API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /*
        $io = new SymfonyStyle($input, $output);

        $progressBar = new ProgressBar($output, 2000);
        $progressBar->start();

        $parks = [];
        for ($i = 0; $i <= 0; $i++) {
            $parks[] = $this->parkService->findParkById($i);
            $progressBar->advance();
        }
        $progressBar->finish();



        $parks = array_filter($parks, function($park) {
            return !empty($park);
        });


        foreach( $parks as $park){
            $this->parkDatabaseService->updateParks($park['name'], $park);
        }

        


        $io->success('Parks updated successfully!');


        return Command::SUCCESS;*/
    }

}