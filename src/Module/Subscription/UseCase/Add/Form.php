<?php

declare(strict_types=1);

namespace App\Module\Subscription\UseCase\Add;

use App\Module\Service\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'placeholder' => '',
                'label' => 'Выберите сервис'
            ])
            ->add('count', TextType::class, ['label' => 'Колличество'])
            ->add('save', SubmitType::class, ['label' => 'Создать']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
