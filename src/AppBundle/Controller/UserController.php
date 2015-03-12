<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Thread;
use AppBundle\Form\CreateThreadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CreatePostType;

class UserController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/secured/create-post", name="create_post")
     */
    public function createPostAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $post = new Post();
        $post->setTitle("The title".$user->getUsername());
        $post->setContent("The content");
        $post->setDate(new \DateTime("now"));
        $form = $this->createForm(new CreatePostType(), $post);
        $form->handleRequest($request);

        $thread_id = $request->getSession()->get('thread_id');
        $thread = $this->getDoctrine()->getRepository('AppBundle:Thread')->find($thread_id);
        $post->setThread($thread);
        $thread->setLastModifiedDate(new \DateTime("now"));

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }
        return $this->render('default/create-post.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/secured/create-thread", name="create_thread")
     */
    public function createThreadAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $thread = new Thread();
        $thread->setTitle("The title");
        $thread->setDescription("The content");
        $thread->setCreationDate(new \DateTime("now"));
        $thread->setLastModifiedDate(new \DateTime("now"));
        $thread->setViews(0);
        $thread->setUser($user);

        $form = $this->createForm(new CreateThreadType(), $thread);

        $form->handleRequest($request);

        $category_id = $request->getSession()->get('category_id');
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($category_id);
        $thread->setCategory($category);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($thread);
            $em->flush();
            return $this->redirect($this->generateUrl('show_category', array('id' => $category_id)));
        }
        return $this->render('default/create-thread.html.twig', array('form' => $form->createView()));
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
    public function showCategoryWithId(Request $request, $id)
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
        //store current thread that the user is browsing in session variable
        $request->getSession()->set('thread_id', $id);

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
