<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:test-mail',
    description: 'Test envoi mail Symfony'
)]
class TestMailCommand extends Command
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (new Email())
            ->from('gestionstockgbtn@gmail.com')
            ->to('ton.email@exemple.com')
            ->subject('Test Symfony Mailer')
            ->text('Ceci est un test d\'envoi d\'email via Symfony Mailer.');

        $this->mailer->send($email);

        $output->writeln('Email envoyé !');
        return Command::SUCCESS;
    }
}