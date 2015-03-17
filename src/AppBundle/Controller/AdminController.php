<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 12.03.2015
 * Time: 16:36
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use AppBundle\Form\Type\CategoryFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AdminController extends Controller{
    /**
     * @Route("/secured/admin/admin-panel", name="admin_panel")
     */
    public function showAdminPanelAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryFormType(), $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirect($this->generateUrl('show_categories'));
        }
        return $this->render('admin/admin-panel.html.twig', array('form' => $form->createView()));
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/secured/admin/delete-post/{id}", name="delete_post")
     */
    public function deletePostAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($id);
        $threadId = $post->getThread()->getId();

        if (!$post) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $em->remove($post);
        $em->flush();

        return $this->redirect($this->generateUrl('show_thread', array('id' => $threadId)));
    }

    /**
     * Deletes a Thread entity.
     *
     * @Route("/secured/admin/delete-thread/{id}", name="delete_thread")
     */
    public function deleteThreadAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $thread = $em->getRepository('AppBundle:Thread')->find($id);


        if (!$thread) {
            throw $this->createNotFoundException('Unable to find Thread entity.');
        }

        $em->remove($thread);
        $em->flush();

        return $this->redirect($this->generateUrl('show_category', array('id' => $thread->getCategory()->getId())));
    }

    /**
     * Deletes a Thread entity.
     *
     * @Route("/secured/admin/delete-category/{id}", name="delete_category")
     */
    public function deleteCategoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);


        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $em->remove($category);
        $em->flush();

        return $this->redirect($this->generateUrl('show_categories'));
    }


}