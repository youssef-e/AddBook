<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;


class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname',TextType::class, [
            'constraints'=> [
                new Assert\NotBlank(),
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                ])
            ]
        ]);
        $builder->add('lastname',TextType::class, [
            'constraints'=> [
                new Assert\NotBlank(),
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                ])
            ]
        ]);
        $builder->add('title',TextType::class, [
            'constraints'=> [
                new Assert\NotBlank(),
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                ])
            ]
        ]);
        $builder->add('phone',TextType::class, [
            'constraints'=> [
                new Assert\NotBlank(),
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                ])
            ]
        ]);
        $builder->add('email',TextType::class, [
            'constraints'=> [
                new Assert\NotBlank(),
                new Assert\Email(),
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                ])
            ]
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact',
            'csrf_protection'   => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }


}
