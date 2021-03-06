<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Mission;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Umbrella\CoreBundle\Form\CkeditorType;

class MissionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('city')
            ->add('intro', CkeditorType::class, [
                'config_name' => 'minimal',
                'config' => [
                    'uiColor' => '#EEF2F7',
                ]
            ])
            ->add('content', CkeditorType::class, [
                'config_name' => 'all',
                'config' => [
                    'uiColor' => '#CCCCCC',
                ]
            ])
            ->add('owner', EntityType::class, [
                'choice_label' => 'email',
                'class' => User::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Mission::class,
        ));
    }
}
