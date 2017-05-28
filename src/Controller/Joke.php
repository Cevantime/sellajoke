<?php



namespace Controller;

use Silex\Application;
use FormType\JokeType;
use Entity\Joke as MyJoke;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Description of Joke
 *
 * @author cevantime
 */
class Joke {
	
	public function lastJokes(Application $app) {
		$lastJokes = $app['dao.jokes']->findLast( null, 6);
		
		return $app['twig']->render('jokes/lasts.html.twig');
	}
	
	public function editJoke(Application $app, Request $request, $jokeId= null) {
		
		if(empty($jokeId)) {
			$joke = new MyJoke();
		} else {
			$joke = $app['dao.jokes']->find($jokeId);
		}
		
		$form = $app['form.factory']->create(JokeType::class, $joke);
		
		if($joke->getId()) {
			/*
			 * si la blague existe déjà, on rend non-obligatoire l'ajout d'une image
			 * il existe des manières plus propre de faire cela en utilisant
			 * un EventSubscriber ou en définissant un autre type de formulaire
			 */
			$options = $form->get('image')->getConfig()->getOptions();
			$form->add('image', FileType::class, array_merge($options, array('required' => false)));
		}
		
		$form->handleRequest($request);
		
		/*
		 * Traitement du formulaire si celui-ci est envoyé et valide
		 */
		if($form->isSubmitted() && $form->isValid()) {
			
			/*
			 *  on commence par gérer l'upload du fichier image si il existe
			 */
			$image = $joke->getImage();
			/*
			 * Voir ce post sur stackoverflow pour comprendre comment patcher 
			 * l'image si et seuelement si elle est renseignée:
			 * https://stackoverflow.com/questions/22557340/symfony2-do-not-update-a-form-field-if-not-provided
			 * 
			 * Sinon, cette méthode fait l'affaire pour l'instant
			 */
			
			if($image) {
				// on commence par renommer notre fichier
				$fileName = md5(uniqid()).'.'.$image->guessExtension();
				
				// on déplace le fichier uploadé vers sa destination permanente
				
				$image->move('uploads/jokes', $fileName);
				
				$joke->setImage(new File('uploads/jokes/'.$fileName));
				
			}
			
			$category = $joke->getCategory();
			
			// si une catégorie de ce nom existe déjà, on la définit comme entité
			// de joke
			$cat = $app['dao.categories']->findByName($category->getName());
			
			if($cat) {
				$joke->setCategory($cat);
			}
			
			$app['dao.categories']->save($joke->getCategory());
			$app['dao.jokes']->save($joke);
			
		}
		
		$formView = $form->createView();
		
		return $app['twig']->render('joke/joke-form.html.twig', array('form' => $formView ));
	}
	
}
