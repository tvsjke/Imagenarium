<?php

namespace Tvsjke\ImagenariumBundle\Controller;

use Tvsjke\ImagenariumBundle\Entity\Post;
use Tvsjke\ImagenariumBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller {

  /**
   * @Route("/", defaults={"page": "1"}, name="home")
   * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="home_paginated")
   */
  public function indexAction($page) {
    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository(Post::class)->findLatest($page);

    return $this->render('ImagenariumBundle:Post:index.html.twig', ['posts' => $posts]);
  }

  /**
   * @Route("/create", name="create")
   */
  public function createAction(Request $request) {
    $post = new Post();

    $form = $this->createForm(PostType::class, $post);

    if ($request->isMethod($request::METHOD_POST)) {
      $form->handleRequest($request);

      if ($form->isValid()) {
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $post->getImage();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getParameter('images_directory'), $fileName);

        $post->setImage($fileName);

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->redirect($this->generateUrl('home'));
      }
    }

    return $this->render('ImagenariumBundle:Post:create.html.twig', ['form' => $form->createView(),]);
  }

  /**
   * @Route("/{id}/edit", requirements={"id": "[1-9]\d*"}, name="edit")
   */
  public function editAction(Request $request, Post $post) {
    $form = $this->createForm(PostType::class, $post);

    if ($request->isMethod($request::METHOD_POST)) {
      $form->handleRequest($request);

      if ($form->isValid()) {
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $post->getImage();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getParameter('images_directory'), $fileName);

        $post->setImage($fileName);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirect($this->generateUrl('home'));
      }
    }

    return $this->render('ImagenariumBundle:Post:edit.html.twig', ['form' => $form->createView(),]);
  }

  /**
   * @Route("/{id}/remove", requirements={"id": "[1-9]\d*"}, name="remove")
   */
  public function removeAction(Post $post) {
    $em = $this->getDoctrine()->getManager();
    $em->remove($post);
    $em->flush();

    return $this->redirect($this->generateUrl('home'));
  }

  /**
   * @Route("/search", name="search")
   */
  public function searchAction(Request $request)
  {
    $query = $request->query->get('q', '');
    $posts = $this->getDoctrine()->getRepository(Post::class)->findBySearchQuery($query);

    return $this->render('ImagenariumBundle:Post:index.html.twig', ['posts' => $posts, 'search' => true]);
  }
}
