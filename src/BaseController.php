<?php

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * @param string $intention
     * @param string $token
     * @return bool
     */
    protected function validateToken($intention, $token)
    {
        return $this->get('form.csrf_provider')->isCsrfTokenValid($intention, $token);
    }

    /**
     * @param string $intention
     * @param string $token
     * @param array $params
     * @return bool
     */
    protected function validateEmailToken($intention, $token, array $params = array())
    {
        return $this->generateEmailToken($intention, $params) === $token;
    }

    /**
     * @param string $intention
     * @param array $params
     * @return string
     */
    protected function generateEmailToken($intention, array $params = array())
    {
        $secret = $this->get('service_container')->getParameter('secret');
        $paramstring = join('', $params);
        return md5($secret . $intention . $paramstring);
    }
}
 