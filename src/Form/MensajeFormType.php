<?php

namespace App\Form;

use App\Entity\Banda;
use App\Entity\Mensaje;
use App\Entity\Modo;
use App\Entity\Participante;
use App\Repository\BandaRepository;
use App\Repository\MensajeRepository;
use App\Repository\ModoRepository;
use App\Repository\ParticipanteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MensajeFormType extends AbstractType
{
    private BandaRepository $repoBand;
    private ModoRepository $repoModo;
    private ParticipanteRepository $repoPart;
    private Security $security;

    public function __construct(BandaRepository $repoBand, ModoRepository $repoModo, ParticipanteRepository $repoPart, Security $security)
    {
        $this->repoBand = $repoBand;
        $this->repoModo = $repoModo;
        $this->repoPart = $repoPart;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($this->repoPart->findAllJueces());

        $builder
            ->add('banda', EntityType::class, [
                'class' => Banda::class,
                'choices' => $this->repoBand->findAll(),
                'choice_label' => 'nombre'
            ])
            ->add('modo', EntityType::class, [
                'class' => Modo::class,
                'choices' => $this->repoModo->findAll(),
                'choice_label' => 'nombre'
            ])
            ->add('indicativoJuez', ChoiceType::class, [
                'choices' => $this->repoPart->findAllJueces(),
                // 'choice_label' => 'choi,
            ])
            ->add('hora')
            ->add('enviar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mensaje::class,
        ]);
    }
}
