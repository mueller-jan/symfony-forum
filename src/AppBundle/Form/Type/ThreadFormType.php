<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Thread;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Class ThreadFormType
 *
 * form for thread creation
 *
 * @package AppBundle\Form\Type
 */
class ThreadFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('title', 'text',  array('label' => 'Thread title'))
            ->add('description', 'textarea', array('label' => 'Thread description'))
            ->getForm();
    }

    public function getName()
    {
        return 'thread';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Thread'));
    }

}