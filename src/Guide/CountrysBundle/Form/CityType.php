<?php

namespace Guide\CountrysBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class CityType extends AbstractType
{
    private $entityManager;
    
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormEvent $event
     * @return bool
     */
    public function cityValidator(FormEvent $event)
    {
        $form      = $event ->getForm();
        $countryId = $form  ->get('country_id')->getData();
        if (empty($countryId)) {
            $form['country_id']->addError(new FormError("Country ID is required"));
            return false;
        }
        $countryRep = $this->entityManager->getRepository('GuideCountrysBundle:Country');
        $country    = $countryRep->findOneById($countryId);
        if (!$country) {
            $form['country_id']->addError(new FormError("Not found country with ID {$countryId}."));
            return false;
        }
        $sity = $event->getData();
        $sity ->setCountry($country);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('country_id')
        ;

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            array(
                $this,
                'cityValidator',
            )
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'Guide\CountrysBundle\Entity\City',
            'csrf_protection'    => false,
            'allow_extra_fields' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }


}
