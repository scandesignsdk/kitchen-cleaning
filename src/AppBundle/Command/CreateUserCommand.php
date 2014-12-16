<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cleaning:adduser')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $namequestion = new Question('Enter the name of the user: ');
        $emailquestion = new Question('Enter the email of the user: ');
        $name = $helper->ask($input, $output, $namequestion);
        $email = $helper->ask($input, $output, $emailquestion);
        $this->getContainer()->get('appbundle.service.team')->addUser($name, $email);
        $output->writeln(sprintf('User "%s" with email "%s" created', $name, $email));
    }


}
