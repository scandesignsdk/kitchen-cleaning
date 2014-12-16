<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Cleaning;
use AppBundle\Entity\Point;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SmileyController extends \BaseController
{

    /**
     * @Route("/smiley/{id}/{user}/{points}/{token}", name="smiley", requirements={"points": "\d+"})
     *
     * @param Cleaning $cleaning
     * @param User $user
     * @param int $points
     * @param string $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Cleaning $cleaning, User $user, $points, $token)
    {
        if ($this->get('appbundle.service.token')->validateSmileyToken($token, $user, $points, $cleaning)) {
            try {
                $this->get('appbundle.service.smiley')->setPoints($cleaning, $user, $points);
                $this->addFlash('success', $this->get('translator')->trans('Your score has been saved', [], 'smiley'));
            } catch (\Exception $e) {
                $this->addFlash('error', $this->get('translator')->trans('%error%', ['%error%' => $e->getMessage()], 'smiley'));
            }
        } else {
            $this->addFlash('error', $this->get('translator')->trans('Whoops - Email csrf token not valid', [], 'smiley'));
        }

        return $this->redirectToRoute('homepage');
    }

}
