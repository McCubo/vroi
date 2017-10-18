<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AmlUserType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('useName')
                ->add('useEmail')
                ->add('usePhoneNumber')
                ->add('useCou')
                ->add('useRol')
                ->add('useSta');
        /*
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();
            
        });*/
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AmlUser'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_amluser';
    }

}
