<?php

namespace App\Controller;
use App\Repository\TourRepository;
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
use App\Entity\Contacto;
use App\Entity\Categoria;

class Proyecto1Controller extends AbstractController
{
    /**
     ** Class Proyecto1Controller
     * @package App\Controller
     * @Route("/proyecto1", name="proyecto1")
     */
    public function toursCategorias(): JsonResponse
    {
        $tours = $this->getDoctrine()->getRepository(Tour::class)->findAllWithCategory();
        $data=[];
        foreach($tours as $tour){
            array_push($data, [
                "id" => $tour->getId(),
                "name" => $tour->getTitulo(),
                "categoria" => $tour->getCategoria()->getId(),
            ]);
            
        }
    return new JsonResponse($data, Response::HTTP_OK);
    }
}
