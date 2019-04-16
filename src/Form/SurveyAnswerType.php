<?php

namespace App\Form;

use App\Entity\SurveyAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;


class SurveyAnswerType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) {
                    $form   = $event->getForm();
                    $entity = $event->getData();
                    if ($entity) {
                        $form->add('value', ChoiceType::class, [
                            'required' => true,
                            'constraints' => [new NotNull(), new Range(['min' => 0, 'max' => 5])],
                            'label' => $entity->getQuestion()->getQuestion(),
                            'choices' => [
                                '0' => '0',
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5',
                            ],
                            'attr' => ['class' => 'col-12 d-flex flex-row justify-content-around'],
                            'expanded' => true,
                        ]);
                    }
                }
            );


    }



    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => SurveyAnswer::class,
        ]);
    }
}
