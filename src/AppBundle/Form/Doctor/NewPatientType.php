<?php

namespace AppBundle\Form\Doctor;

use AppBundle\Enum\Gender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewPatientType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('dob', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
            ->add(
                'gender',
                ChoiceType::class,
                [
                    'choices' => [
                        Gender::MALE,
                        Gender::FEMALE,
                    ],
                    'choices_as_values' => true
                ]
            );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
