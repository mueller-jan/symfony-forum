<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Thread;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateThreadType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea')
            //->add('date', 'hidden')
            ->add('save', 'submit', array('label' => 'Create Thread'))
            ->getForm();
    }

    public function getName()
    {
        return 'thread';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Thread::class,
            'action'        => '',
        ]);
    }
}