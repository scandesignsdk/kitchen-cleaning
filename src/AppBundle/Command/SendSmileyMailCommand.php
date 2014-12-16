<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendSmileyMailCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cleaning:smiley')
            ->addArgument('date', InputArgument::OPTIONAL, 'Set date to send', 'now')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()
            ->get('appbundle.service.smiley')
            ->sendSmileyMails(new \DateTime($input->getArgument('date')))
        ;
    }

}
