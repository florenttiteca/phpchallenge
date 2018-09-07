<?php

namespace App\Controller\Rest;

Use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use App\Entity\Product;
use App\Entity\Category;

/**
 * Class CategoryController
 * @package App\Controller\Rest
 */
class ProductController extends FOSRestController
{
    /**
     * Post a product
     * @Rest\Post("/product")
     * @param Request $request
     * @return View
     */
    public function postArticle(Request $request) : View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $category = $categoryRepository->findOneBy(['name' => $request->get('category')]);
        if (!$category) {
            $category = new Category();
            $category->setName($request->get('category'));
            $entityManager->persist($category);
        }

        $product = new Product();
        $product->setName($request->get('name'));
        $product->setCategory($category);
        $product->setSku($request->get('sku'));
        $product->setPrice($request->get('price'));
        $product->setQuantity($request->get('quantity'));
        $product->setCreatedAt(new \DateTime("now"));
        $product->setUpdatedAt(new \DateTime("now"));

        $entityManager->persist($product);
        $entityManager->flush();

        return View::create($product, Response::HTTP_CREATED);
    }

    /**
     * Get a product
     * @Rest\Get("/product/{productId}")
     * @param int $productId
     * @return View
     */
    public function getProduct(int $productId) : View
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($productId);

        return View::create($product, Response::HTTP_OK);
    }

    /**
     * Update a product
     * @Rest\Put("/product/{productId}")
     * @param int $productId
     * @param Request $request
     * @return View
     */
    public function putProduct(int $productId, Request $request) : View
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$productId
            );
        }

        $product->setName($request->get('name'));
        $product->setQuantity($request->get('quantity'));
        $product->setUpdatedAt(new \DateTime("now"));
        $entityManager->flush();

        return View::create($product, Response::HTTP_OK);
    }

    /**
     * Delete a product
     * @Rest\Delete("/product/{productId}")
     * @param int $productId
     * @return View
     */
    public function deleteProduct(int $productId) : View
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($productId);

        if ($product) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return View::create([], Response::HTTP_NO_CONTENT);
    }

    /**
     * List all products
     * @Rest\Get("/product")
     * @return View
     */
    public function getProducts() : View
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();

        return View::create($products, Response::HTTP_OK);
    }
}
