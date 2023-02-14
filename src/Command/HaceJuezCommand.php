<?php

namespace App\Command;

use App\Repository\ParticipanteRepository;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:haceJuez',
    description: 'Le añade el rol de Juez a un participante.',
)]
class HaceJuezCommand extends Command
{
    private ParticipanteRepository $repoPart;

    public function __construct(ParticipanteRepository $repoPart)
    {
        parent::__construct();
        $this->repoPart = $repoPart;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = $io->ask('id', null, function ($id) {
            $participante = $this->repoPart->find($id);
    
            if ($participante === null) {
                throw new \RuntimeException("Id inválido, este participante no existe");
            }

            return $id;
        });

        $participante = $this->repoPart->find($id);

        $participante->setRoles(['ROLE_JUEZ']);

        $this->repoPart->save($participante, true);

        $io->success('Éxito!, el participante '.$participante->getIndicativo().' ahora es juez.');

        return Command::SUCCESS;
    }
}
