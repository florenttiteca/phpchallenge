<?php

namespace App\Controller\Rest;

Use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use App\Entity\Category;

/**
 * Class CategoryController
 * @package App\Controller\Rest
 */
class CategoryController extends FOSRestController
{
    /**
     * List all categories
     * @Rest\Get("/category")
     * @return View
     */
    public function getCategories()
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $products = $categoryRepository->findAll();
        return View::create($products, Response::HTTP_OK);
    }
}
