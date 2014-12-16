<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendStartMailCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cleaning:start')
            ->addArgument('date', InputArgument::OPTIONAL, 'Set date to create', 'now')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()
            ->get('appbundle.service.team')
            ->sendMailToTeam(new \DateTime($input->getArgument('date')))
        ;
    }

}
