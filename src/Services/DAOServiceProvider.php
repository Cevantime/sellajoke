<?php
namespace Services;

/**
 * Description of DAOServiceProvider
 *
 * @author Formateur
 */
class DAOServiceProvider implements \Pimple\ServiceProviderInterface
{
    public function register(\Pimple\Container $app)
    {
        $app['dao.users'] = function () use ($app) {
            return new \DAO\UsersDAO($app['db']);
        };
        $app['dao.categories'] = function () use ($app) {
            return new \DAO\CategoriesDAO($app['db']);
        };
        $app['dao.jokes'] = function () use ($app) {
            return new \DAO\JokesDAO($app['db']);
        };
    }
}
