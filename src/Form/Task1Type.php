<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Task1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('itemCount', IntegerType::class, [
                'label' => 'Počet položek pole typu integer',
                'required' => true,
                'attr' => ['min' => 1],
            ])
            ->add('min', IntegerType::class, [
                'label' => 'Minimální náhodná hodnota položky',
                'required' => true,
            ])
            ->add('max', IntegerType::class, [
                'label' => 'Maximální náhodná hodnota položky',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}