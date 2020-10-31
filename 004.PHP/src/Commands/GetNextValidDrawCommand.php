<?php

namespace App\Commands;

use App\Lottery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetNextValidDrawCommand  extends Command
{
    protected static $defaultName = 'generate:next-draw';

    protected function configure()
    {
        $this
            ->setDescription('This command will generate next drawing day based on the user input time')
            ->setDefinition(
            new InputDefinition([
                new InputArgument('date', InputArgument::REQUIRED, 'Please provide a valid date format "Y-m-d H:i:s"'),
            ])
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currentDate = $input->getArgument('date');
        if($input->getArgument('date')) {
            $currentDate = \DateTime::createFromFormat('Y-m-d H:i:s', $currentDate);
            if(!$currentDate) {
                $output->writeln('<error>Please provide a valid date format "Y-m-d H:i:s"</error>');
                return Command::FAILURE;
            }
        }

        $welcomeMessage = <<<MESSAGE

░██╗░░░░░░░██╗███████╗██╗░░░░░░█████╗░░█████╗░███╗░░░███╗███████╗
░██║░░██╗░░██║██╔════╝██║░░░░░██╔══██╗██╔══██╗████╗░████║██╔════╝
░╚██╗████╗██╔╝█████╗░░██║░░░░░██║░░╚═╝██║░░██║██╔████╔██║█████╗░░
░░████╔═████║░██╔══╝░░██║░░░░░██║░░██╗██║░░██║██║╚██╔╝██║██╔══╝░░
░░╚██╔╝░╚██╔╝░███████╗███████╗╚█████╔╝╚█████╔╝██║░╚═╝░██║███████╗
░░░╚═╝░░░╚═╝░░╚══════╝╚══════╝░╚════╝░░╚════╝░╚═╝░░░░░╚═╝╚══════╝
MESSAGE;

        $output->writeln($welcomeMessage);
        $lottery = new Lottery($currentDate);
        $output->writeln('Next draw: ' . $lottery->getNextDraw());

        return Command::SUCCESS;
    }
}
