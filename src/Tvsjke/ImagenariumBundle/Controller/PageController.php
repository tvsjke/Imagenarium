<?php

namespace Tvsjke\ImagenariumBundle\Controller;

use Tvsjke\ImagenariumBundle\Entity\Post;
use Tvsjke\ImagenariumBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {

  /**
   * @Route("/", defaults={"page": "1"}, name="home")
   * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="home_paginated")
   */
  public function indexAction($page) {
    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository(Post::class)->findLatest($page);

    return $this->render('ImagenariumBundle:Page:index.html.twig', ['posts' => $posts]);
  }

  /**
   * @Route("/create", name="create")
   */
  public function createAction(Request $request) {
    $post = new Post();

    $form = $this->createForm(PostType::class, $post);

    if ($request->isMethod($request::METHOD_POST)) {
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->redirect($this->generateUrl('home'));
      }
    }

    return $this->render('ImagenariumBundle:Page:create.html.twig', ['form' => $form->createView(),]);
  }

  /**
   * @Route("/{id}/remove", requirements={"id": "[1-9]\d*"}, name="remove")
   */
  public function removeAction($id) {
    $em = $this->getDoctrine()->getManager();
    $post = $em->getRepository(Post::class)->find($id);

    $em = $this->getDoctrine()->getManager();
    $em->remove($post);
    $em->flush();

    return $this->redirect($this->generateUrl('home'));
  }
}
