<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 12.03.2015
 * Time: 16:39
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateCategoryType extends  AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('save', 'submit', array('label' => 'Create Category'))
            ->getForm();
    }

    public function getName()
    {
        return 'category';
    }
}