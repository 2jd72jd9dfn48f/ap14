<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategoriaRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoriaController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class CategoriaController
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * @Route("categoria", name="add_categoria", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $id = $data['id'];
        $categoria = $data['categoria'];

        if (empty($id) || empty($categoria)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->categoriaRepository->saveCategoria($id, $categoria);

        return new JsonResponse(['status' => 'Categoria created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("categoria/{id}", name="get_one_categoria", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $categoria = $this->categoriaRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $categoria->getId(),
            'categoria' => $categoria->getCategoria(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("categorias", name="get_all_categorias", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $categorias = $this->categoriaRepository->findAll();
        $data = [];

        foreach ($categorias as $categoria) {
            $data[] = [
                'id' => $categoria->getId(),
                'categoria' => $categoria->getCategoria(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("categoria/{id}", name="update_categoria", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $categoria = $this->categoriaRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['id']) ? true : $categoria->setCategoria($data['id']);
        empty($data['categoria']) ? true : $categoria->setCategoria($data['categoria']);

        $updatedCategoria = $this->categoriaRepository->updateCategoria($categoria);

		return new JsonResponse(['status' => 'Categoria updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("categoria/{id}", name="delete_categoria", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $categoria = $this->categoriaRepository->findOneBy(['id' => $id]);

        $this->categoriaRepository->removeCategoria($categoria);

        return new JsonResponse(['status' => 'Categoria deleted'], Response::HTTP_OK);
    }
}
