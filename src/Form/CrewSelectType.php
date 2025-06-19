<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Crew;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CrewSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('crew', EntityType::class, [
            'class' => Crew::class,
            'choice_label' => function (Crew $crew) {
                return $crew->getParent() === null
                    ? $crew->getFullname() . ' - Kapitán'
                    : $crew->getFullname();
            },
            'label' => 'Člen posádky',
            'placeholder' => 'Vyber člena posádky',
            'mapped' => false,
            'required' => true,
            'constraints' => [
                new NotBlank(['message' => 'Prosím vyberte člena posádky.']),
            ],
        ])
        ->add('resultType', ChoiceType::class, [
            'label' => 'Typ výsledku',
            'choices' => [
                'Členové posádky, co se mohli od této osoby nakazit dřív než nakazili kapitána' => 'plague',
                'Podřízení' => 'subordinate',
            ],
            'expanded' => false,
            'multiple' => false,
            'mapped' => false,
            'placeholder' => 'Vyberte typ výsledku',
            'required' => true,
            'constraints' => [
                new NotBlank(['message' => 'Prosím vyberte typ výsledku.']),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Crew::class,
        ]);
    }
}
