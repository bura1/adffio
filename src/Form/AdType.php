<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\App;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->userId = $options['userId'];

        $builder
            ->add('app', EntityType::class, [
                'class' => App::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('app')
                        ->andWhere('app.user = ' . $this->userId);
                },
            ])
            ->add('name', TextType::class)
            ->add('message', TextareaType::class)
            ->add('url', TextType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Add New App',
                'attr' => [
                    'class' => 'btn-dark'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
            'userId' => 'null'
        ]);
    }
}
