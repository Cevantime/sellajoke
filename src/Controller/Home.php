<?php

namespace Controller;

/**
 * Description of Home
 *
 * @author cevantime
 */
class Home
{
    public function index(\Silex\Application $app)
    {
        $jokes = $app['dao.jokes']->findLast([], 5);
        
        return $app['twig']->render('home/index.html.twig', ['jokes' => $jokes]);
    }
}
