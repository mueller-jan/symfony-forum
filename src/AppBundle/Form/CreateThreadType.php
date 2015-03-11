<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateThreadType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea')
            //->add('date', 'date')
            ->add('save', 'submit', array('label' => 'Create Thread'))
            ->getForm();
    }

    public function getName()
    {
        return 'thread';
    }
}