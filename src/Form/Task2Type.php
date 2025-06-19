<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class Task2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('planet', TextType::class, [
                'label' => 'Planeta',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Zadejte jméno planety',
                ],
                'data' => 'Kashyyyk',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Prosím zadejte jméno planety.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
