<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\Thread;
use AppBundle\Form\Type\CreateThreadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\CreatePostType;


class UserController extends BaseController
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/secured/{id}/create-new-thread", name="create_new_thread", defaults={"category" = null})
     * @ParamConverter("category", class="AppBundle:Category")
     */

    public function createThreadAction(Request $request, Category $category)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $thread = new Thread();
        $thread->setCreationDate(new \DateTime("now"));
        $thread->setLastModifiedDate(new \DateTime("now"));
        $thread->setViews(0);
        $thread->setUser($user);
        $thread -> setCategory($category);

        $actionURL = $this->generateUrl('create_new_thread', ['id'=>$category->getId()]);
        $callback  = array($this, 'showCategoryAction');
        $callbackArguments = array($request, $category->getId());
        return $this->renderForm($request, $thread, 'new', $callback, $callbackArguments, ['action' => $actionURL]);
    }

    /**
     * @Route("/secured/show-categories", name="show_categories")
     */
    public function showCategoriesAction(Request $request)
    {
        $request->getSession()->set('isInThread', false);
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();
        return $this->render('default/show-categories.html.twig', array('categories' => $categories));
    }


    /**
     * @Route("/secured/show-category/{id}", name="show_category")
     */
    public function showCategoryAction(Request $request, $id)
    {
        $request->getSession()->set('isInThread', false);
        //store current category that the user is browsing in session variable
        $request->getSession()->set('category_id', $id);
        $em = $this->getDoctrine()
            ->getManager();
        $category = $em->getRepository('AppBundle:Category')
            ->find($id);
        $threads = $this->getThreadsOrderedByLatestPost($id);
        if (!$category) {
            throw $this->createNotFoundException('No thread found for id '.$id);
        }
        return $this->render('default/show-threads.html.twig', array('threads' => $threads, 'category' => $category));
    }

    private function getThreadsOrderedByLatestPost($category_id)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Thread');

        $query = $repository->createQueryBuilder('t')
            ->where("t.category = :id")
            ->setParameter('id', $category_id)
            ->orderBy('t.last_modified_date', 'desc')
            ->getQuery();

        return $query->getResult();
    }


    /**
     * @Route("/secured/show-thread/{id}", name="show_thread")
     */
    public function showThreadWithId(Request $request, $id)
    {
        $request->getSession()->set('isInThread', true);
        $em = $this->getDoctrine()
            ->getManager();
        $thread = $em->getRepository('AppBundle:Thread')
            ->find($id);
        //update views value and persist thread
        $thread->setViews($thread->getViews()+1);
        $em->persist($thread);
        $em->flush();
        //get all posts from current thread
        $posts = $thread->getPosts();
        $postSubmitForm = $this->createPostSubmitForm($request, $thread);

        if (!$thread) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }
        return $this->render('default/show-thread.html.twig', array('posts' => $posts, 'thread' => $thread, 'form' => $postSubmitForm->createView()));
    }

    private function createPostSubmitForm(Request $request, $thread) {
        //create an add-post-form containing a dummy post
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $post = $this->createDummyPost();
        $form = $this->createForm(new CreatePostType(), $post);
        $post->setThread($thread);
        $thread->setLastModifiedDate(new \DateTime("now"));
        $post->setUser($user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }

        return $form;
    }

    private function createDummyPost()
    {
        $post = new Post();
        $post->setTitle("");
        $post->setContent("");
        $post->setDate(new \DateTime("now"));
        return $post;
    }
}
