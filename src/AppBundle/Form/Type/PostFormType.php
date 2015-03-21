<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('required' => false, 'label' => 'Post Title'))
            ->add(
                'content',
                'textarea',
                array(
                    'attr' => array('cols' => '80', 'rows' => '10'),
                )
            );

            if ($options['show_submit'])
            {
                $builder->add('save', 'submit', array('label' => 'Post Reply'));
            }
    }

    public function getName()
    {
        return 'post';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Post::class,
            'action'        => '',
            'show_submit' => true
        ]);
    }
}