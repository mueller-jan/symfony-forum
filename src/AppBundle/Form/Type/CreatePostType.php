<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreatePostType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text')
            ->add('content', 'textarea', array(
                'attr' => array('cols' => '80', 'rows' => '10'),))
            //->add('date', 'date')
            ->add('save', 'submit', array('label' => 'Post Reply'))
            ->getForm();
    }

    public function getName()
    {
        return 'post';
    }
}