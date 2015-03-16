<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 13.03.2015
 * Time: 11:00
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class BaseController extends Controller {
    protected function getClassName($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }

    protected  function renderForm(Request $request, $object, $actionType, $callback=null, $callbackArguments=null, $options) {
        $className = $this->getClassName($object);
        $lowerClassName = strtolower($className);
        $form = $this->createForm($lowerClassName, $object, $options);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if (!$this->isGranted('ROLE_USER')) {
                    return new Response('Missing Permission', Response:: HTTP_FORBIDDEN);
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($object);
                $entityManager->flush();
                if ($callback) {
                    return call_user_func_array($callback, $callbackArguments);
                }
            }
            else {
                return new Response('Validierungs-Fehler!', Response::HTTP_BAD_REQUEST);
            }
        }
        return $this->render('default/'.$className.'-'.$actionType.'.html.twig', ['form' => $form->createView()]);
    }
}