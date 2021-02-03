<?php

namespace App\Controller;

use App\Repository\TourRepository;
use App\Repository\ContactoRepository;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tour;
use App\Entity\Categoria;
use App\Entity\Contacto;

class Proyecto2Controller extends AbstractController
{
    /**
     * 
     * @package App\Controller
     * @Route("/proyecto2", name="proyecto2")
     */
    public function findDate(): JsonResponse
    {
        $entidades = $this->getDoctrine()->getRepository(Contacto::class)->findCosas();
        $data=[];
        foreach($entidades as $ent){
            array_push($data, [
                "id" => $ent->getId(),
                "name" => $ent->getName(),
                "email" => $ent->getEmail(),
                "date" => $ent->getDate()->format('d-m-Y H:i:s'),
            ]);
            
        }
    return new JsonResponse($data, Response::HTTP_OK);
    }



}
