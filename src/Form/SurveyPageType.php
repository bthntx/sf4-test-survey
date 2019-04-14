<?php


namespace App\Form;


use App\Entity\SurveyPageModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SurveyPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('answers', CollectionType::class, [
            'label' => false,
            'entry_type' => SurveyAnswerType::class,
            'entry_options' => ['label' => false],
        ])
        ->add(
            'submit',
            SubmitType::class,
            [
                'attr' => ['class' => 'btn-primary'],'label' => 'Next'
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SurveyPageModel::class,
        ]);
    }

}
