<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 11/09/18
 * Time: 14:04
 */

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\Team;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('strip', TextType::class)
            ->add(
                'league',
                EntityType::class,
                [
                    'class'        => 'App:League',
                    'choice_label' => 'name',
                    'label'        => 'League Name',
                    'placeholder'  => 'Choose league',
                    'constraints'  => [
                        new NotBlank(),
                    ],
                ]
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'App\Entity\Team',
            'data_class' => Team::class,
        ));
    }

    public function getName()
    {
        return 'team';
    }
}