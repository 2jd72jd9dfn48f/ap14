<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TourRepository;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TourController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class TourController
{
    private $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    /**
     * @Route("tour", name="add_tour", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $image = $data['image'];
        $description = $data['description'];
        $date = $data['date'];
        $days = $data['days'];
        $price = $data['price'];
        $categoria = $data['categoria'];

        if (empty($name) || empty($image) || empty($description) || empty($days) || empty($price) ) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->tourRepository->saveTour($name, $image, $description, $date, $days, $price, $categoria);

        return new JsonResponse(['status' => 'Tour created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("tour/{id}", name="get_one_tour", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $tour = $this->tourRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $tour->getId(),
            'name' => $tour->getTitulo(),
            'image' => $tour->getImagen(),
            'description' => $tour->getDescription(),
            'date' => $tour->getDate(),
            'days' => $tour->getDays(),
            'price' => $tour->getPrice(),
            'categoria' => $tour->getCategoria(),

        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("tours", name="get_all_tours", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $tours = $this->tourRepository->findAll();
        $data = [];

        foreach ($tours as $tour) {
            $data[] = [
                'id' => $tour->getId(),
                'name' => $tour->getTitulo(),
                'image' => $tour->getImagen(),
                'description' => $tour->getDescription(),
                'date' => $tour->getDate(),
                'days' => $tour->getDays(),
                'price' => $tour->getPrice(),
                'categoria' => $tour->getCategoria(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("tour/{id}", name="update_tour", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $tour = $this->tourRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $tour->setTitulo($data['name']);
        empty($data['image']) ? true : $tour->setImagen($data['image']);
        empty($data['description']) ? true : $tour->setDescription($data['description']);
        empty($data['date']) ? true : $tour->setDate($data['date']);
        empty($data['days']) ? true : $tour->setDays($data['days']);
        empty($data['price']) ? true : $tour->setPrice($data['price']);
        empty($data['categoria']) ? true : $tour->setCategoria($data['categoria']);


        $updatedTour = $this->tourRepository->updateTour($tour);

		return new JsonResponse(['status' => 'Tour updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("tour/{id}", name="delete_tour", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $tour = $this->tourRepository->findOneBy(['id' => $id]);

        $this->tourRepository->removeTour($tour);

        return new JsonResponse(['status' => 'Tour deleted'], Response::HTTP_OK);
    }
}
