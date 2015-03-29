<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 27.03.2015
 * Time: 21:54
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConversationFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('reply', 'textarea',  array('label' => 'Message'));
        $builder->add('save', 'submit', array('label' => 'Post Reply'));
    }

    public function getName()
    {
        return 'conversation';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\ConversationReply'));
    }

}