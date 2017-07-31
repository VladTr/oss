<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function editAction(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $product->setImage(null);
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $product->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move('uploads/img', $fileName);
            $product->setImage('uploads/img/'.$fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirect($this->generateUrl('product'));
        }

        return $this->render('AppBundle:Product:edit.html.twig', array(
           'form'=>$form->createView()
        ));

    }

    public function addAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $product->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move('uploads/img', $fileName);
            $product->setImage('uploads/img/'.$fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirect($this->generateUrl('product'));
        }

        return $this->render('AppBundle:Product:add.html.twig', array(
            'form'=>$form->createView()
        ));
    }


    public function deleteAction($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirect($this->generateUrl('product'));
    }

    public function listAction(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('AppBundle:Product:list.html.twig', array('products'=>$result));
    }


    public function searchAction(Request $request)
    {
        $search = $request->query->get('search');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Product');
        $query = $repository->createQueryBuilder('p')
            ->where('p.title LIKE :word')
            ->setParameter('word', '%'.$search.'%')
            ->getQuery();
        $products = $query->getResult();
        return $this->render('AppBundle:Product:show.html.twig', array(
            'products'=>$products,
            'search'=>$search
        ));
    }

}
