<?php

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegistrationType
 * @package AppBundle\Form\Type
 */

class ThreadCreationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('thread', new ThreadFormType());
        $builder->add('post', new PostFormType(), array('show_submit' => false));
        $builder->add('button', 'submit', array('label' => 'Create Thread'));
    }

    public function getName()
    {
        return 'threadCreation';
    }
}