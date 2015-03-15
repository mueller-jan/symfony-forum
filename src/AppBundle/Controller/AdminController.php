<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 12.03.2015
 * Time: 16:36
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use AppBundle\Form\CreateCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller{
    /**
     * @Route("/secured/admin/admin-panel", name="admin_panel")
     */
    public function showAdminPanelAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CreateCategoryType(), $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirect($this->generateUrl('show_categories'));
        }
        return $this->render('admin/admin-panel.html.twig', array('form' => $form->createView()));
    }



}