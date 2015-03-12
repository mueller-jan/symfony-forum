<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 07.03.2015
 * Time: 08:40
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\RegistrationType;
use AppBundle\Model\Registration;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{

    /**
     * @Route("/register", name="account_register")
     */
    public function registerAction()
    {
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('account_create'),
        ));

        return $this->render(
            'default/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register/create", name="account_create")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            $em->persist($registration->getUser());
            $em->flush();

            return $this->redirect($this->generateUrl('show_categories'));
        }

        return $this->render(
            'default/register.html.twig',
            array('form' => $form->createView())
        );
    }
}