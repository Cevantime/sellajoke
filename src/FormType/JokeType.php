<?php

namespace FormType;

/**
 * Description of JokeType
 *
 * @author cevantime
 */
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Entity\Joke;
use Symfony\Component\Validator\Constraints as Assert;

class JokeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'constraints' => new Assert\Length(['min' => '2', 'max' => '50']),
            'label' => 'Titre de la blague'
        ]);

        $builder->add('text', TextareaType::class, [
            'constraints' => new Assert\Length(['min' => '2', 'max' => '65000']),
            'label' => 'La blague'
        ]);

        $builder->add('image', FileType::class, [
            'constraints' => new Assert\File(
                [
                'mimeTypes' => ['image/png', 'image/jpg', 'image/gif', 'image/svg+xml'],
                'maxSize' => '500k'
                ]
            ),
            'label' => 'Image'
        ]);

        $builder->add('category', CategoryType::class, [
            'label' => 'Catégorie'
        ]);

        /*
         * on ne souhaite pas que l'utilisateur puisse changer l'icône de la
         * catégorie depuis ce formulaire
         */
        $builder->get('category')->remove('icon');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Joke::class,
        ]);
    }

}
