<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class PlaceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class, [
            'constraints'=> [
                new Assert\NotBlank(),
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                    'minMessage' => 'Name must be at least {{ limit }} characters long',
                    'maxMessage' => 'Name cannot be longer than {{ limit }} characters',
                ])
            ]
        ]);
        $builder->add('address',TextType::class, [
            'constraints'=> [
                new Assert\NotBlank(),
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                    'minMessage' => 'Address must be at least {{ limit }} characters long',
                    'maxMessage' => 'Address cannot be longer than {{ limit }} characters',
                ])
            ]
        ]);
        $builder->add('comment',TextType::class, [
            'constraints'=> [
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                    'minMessage' => 'Comment must be at least {{ limit }} characters long',
                    'maxMessage' => 'Comment cannot be longer than {{ limit }} characters',
                ])
            ]
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Place',
            'csrf_protection'   => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_place';
    }


}
