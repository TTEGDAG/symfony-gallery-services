<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\UploadPhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(UploadPhotoType::class);

        //obsługa wysłanego formularza
        $form->handleRequest($request);

        //sprawdzamy czy formularz jest potwierdzony i poprawnie zwalidowany
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            //sprawdzamy czy użytkownik jest zalogowany
            if($this->getUser()){
                $entityPhotos = new Photo();
                $entityPhotos->setFilename($form->get('filename')->getData());
                $entityPhotos->setIsPublic($form->get('is_public')->getData());
                $entityPhotos->setUploadedAt(new \DateTime());
                $entityPhotos->setUser($this->getUser());

                $em->persist($entityPhotos);
                $em->flush();
            }
        }
        
        return $this->render('index/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
