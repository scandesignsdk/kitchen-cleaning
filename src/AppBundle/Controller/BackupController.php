<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Cleaning;
use AppBundle\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class BackupController extends \BaseController
{

    /**
     * @Route("/usebackup/{id}/{user}/{token}", name="backup")
     *
     * @param Cleaning $cleaning
     * @param User $user
     * @param string $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Cleaning $cleaning, User $user, $token)
    {
        if ($this->get('appbundle.service.token')->validateBackupToken($token, $user, $cleaning)) {
            try {
                $this->get('appbundle.service.team')->setBackupUser($user, $cleaning);
                $this->addFlash('success', $this->get('translator')->trans('You have been added as cleaner today', [], 'backup'));
            } catch (\Exception $e) {
                $this->addFlash('error', $this->get('translator')->trans('%error%', ['%error%' => $e->getMessage()], 'backup'));
            }
        } else {
            $this->addFlash('error', $this->get('translator')->trans('Whoops - Email csrf token not valid', [], 'backup'));
        }

        return $this->redirectToRoute('homepage');
    }

}
