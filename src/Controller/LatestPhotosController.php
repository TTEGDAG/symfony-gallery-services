<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LatestPhotosController extends AbstractController
{
    /**
     * @Route("/latest", name="latest_photo")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $latestPhotosPublic = $em->getRepository( Photo::class)-> findBy(['is_public' => true]);
        return $this->render( ' ', [
            'latestPhotoPublic' => $latestPhotosPublic
        ] );
    }
}