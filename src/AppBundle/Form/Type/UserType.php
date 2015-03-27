<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 07.03.2015
 * Time: 08:11
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('email', 'email');
        $builder->add('username', 'text');
        $builder->add(
            'password', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => 'password',
        ));
        $builder->add('birthday','date',array(
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'attr' => array('class' => 'date')
        ));
    }


    public function getName()
    {
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\User'));
    }
}