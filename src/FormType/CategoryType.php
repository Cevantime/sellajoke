<?php

namespace FormType;

/**
 * Description of CategoryType
 *
 * @author cevantime
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver ;

use Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;


class CategoryType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('name', TextType::class, array(
			'constraints' => array(new Assert\Length(array('min'=>2, 'max'=>'50'))),
			'label' => 'Nom de la catégorie'
		));
		
		$builder->add('icon', FileType::class, array(
			'constraints' => new Assert\File(array(
					'mimeTypes' => array('image/png','image/jpg', 'image/gif','image/svg+xml'),
					'maxSize' => '200k'
				)
			),
			'label' => 'Icône',
			'required' => false
		));
		
		$builder->add('save', SubmitType::class);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
			'data_class' => Category::class,
		));
	}
}
