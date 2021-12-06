<?php

declare(strict_types=1);

namespace App\Module\Transaction\UseCase\Search;

use App\Module\Service\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'required' => false,
                'label' => 'Выберите сервис'
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'label' => 'Начальная дата'
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'label' => 'Конечная дата'
            ])
            ->add('save', SubmitType::class, ['label' => 'Найти']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}

