<?php

namespace App\Form;

use App\Entity\SurveyAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
