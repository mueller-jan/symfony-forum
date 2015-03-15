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
use AppBundle\Form\Type\RegistrationType;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use AppBundle\Model\Registration;
use Symfony\Component\BrowserKit\Response;
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

        $this->createRolesIfNotExist();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();
            $user = $registration->getUser();
            /**
             * @todo implement proper way to assign roles
             */
            //assign admin role, if username equals admin (for testing purposes)
            if ($user->getUsername() == 'admin') {
                $role = $em->getRepository('AppBundle:Role')
                    ->find(2);

            } else {
                $role = $em->getRepository('AppBundle:Role')
                    ->find(1);
            }
            $role->addUser($user);
            $user->addRole($role);
            $em->persist($role);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('show_categories'));
        }

        return $this->render(
            'default/register.html.twig',
            array('form' => $form->createView())
        );
    }

    private function createRolesIfNotExist() {
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository('AppBundle:Role')
            ->find(1);
        if (!$role) {

            $role1 = new Role();
            $role1->setName('ROLE_USER');
            $role1->setRole('ROLE_USER');
            $role2 = new Role();
            $role2->setName('ROLE_ADMIN');
            $role2->setRole('ROLE_ADMIN');
            $em->persist($role1);
            $em->persist($role2);
            $em->flush();
        }


    }
}