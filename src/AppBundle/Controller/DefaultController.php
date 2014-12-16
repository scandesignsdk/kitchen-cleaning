<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends \BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $team = $this->getManager()->getRepository('AppBundle:Cleaning')->findTeam();
        if (! is_object($team)) {
            return $this->render(':default:notselected.html.twig', ['date' => new \DateTime()]);
        }

        return $this->render(':default:index.html.twig', ['team' => $team, 'date' => new \DateTime()]);
    }

    /**
     * @Route("/topscore", name="topscore")
     */
    public function topscoreAction()
    {
        return $this->render(':default:topscore.html.twig', [
            'topscores' => $this->getManager()->getRepository('AppBundle:Cleaning')->findTopscore()
        ]);
    }
}
