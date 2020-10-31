<?php

namespace App\Commands;

use App\Lottery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetNextValidDrawCommandBasedOnCurrentDate  extends Command
{
    protected static $defaultName = 'generate:next-draw-based-on-current-time';

    protected function configure()
    {
        $this
            ->setDescription('This command will generate next drawing day based on the current time');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $welcomeMessage = <<<MESSAGE

░██╗░░░░░░░██╗███████╗██╗░░░░░░█████╗░░█████╗░███╗░░░███╗███████╗
░██║░░██╗░░██║██╔════╝██║░░░░░██╔══██╗██╔══██╗████╗░████║██╔════╝
░╚██╗████╗██╔╝█████╗░░██║░░░░░██║░░╚═╝██║░░██║██╔████╔██║█████╗░░
░░████╔═████║░██╔══╝░░██║░░░░░██║░░██╗██║░░██║██║╚██╔╝██║██╔══╝░░
░░╚██╔╝░╚██╔╝░███████╗███████╗╚█████╔╝╚█████╔╝██║░╚═╝░██║███████╗
░░░╚═╝░░░╚═╝░░╚══════╝╚══════╝░╚════╝░░╚════╝░╚═╝░░░░░╚═╝╚══════╝
MESSAGE;

        $output->writeln($welcomeMessage);

        $currentDate = new \DateTime('now');
        $lottery = new Lottery($currentDate);

        $output->writeln('Next draw: ' . $lottery->getNextDraw());

        return Command::SUCCESS;
    }
}
