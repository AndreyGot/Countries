<?php

namespace Guide\CountrysBundle\Controller;

use Guide\CountrysBundle\Entity\Country;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Country controller.
 *
 * @Route("country")
 */
class CountryController extends FOSRestController
{
    /**
     * Lists all country entities.
     *
     * @Route("/", name="country_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em        = $this->getDoctrine()->getManager();
        $countries = $em->getRepository('GuideCountrysBundle:Country')->findAll();
        $view      = $this->view($countries, 200);
        return $this->handleView($view);
    }
    // public function indexAction()
    // {
    //     $em = $this->getDoctrine()->getManager();

    //     $countries = $em->getRepository('GuideCountrysBundle:Country')->findAll();

    //     return $this->render('GuideCountrysBundle:Country:index.html.twig', array(
    //         'countries' => $countries,
    //     ));
    // }


    /**
     * Creates a new country entity.
     *
     * @ApiDoc(
     *  description="Creates a new country entity",
     *  input="Guide\CountrysBundle\Form\CountryType",
     *  output="Guide\CountrysBundle\Entity\Country"
     * )
     * @Route("/new", name="country_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $country = new Country();
        $form = $this->createForm('Guide\CountrysBundle\Form\CountryType', $country);
        $form->handleRequest($request);

        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush($country);
            $view      = $this->view($country, 200);
            return $this->handleView($view);
            // return $this->redirectToRoute('country_show', array('id' => $country->getId()));
        }
        $view = $this->view($form, 500);
        return $this->handleView($view);


        // return $this->render('GuideCountrysBundle:Country:new.html.twig', array(
        //     'country' => $country,
        //     'form' => $form->createView(),
        // ));
    }

    /**
     * Finds and displays a country entity.
     *
     * @ApiDoc(
     *  description="show a country entity by id",
     *  output="Guide\CountrysBundle\Entity\Country"
     * )
     * @Route("/{id}", name="country_show")
     * @Method("GET")
     */
    public function showAction(Request $request, $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $country = $em->getRepository('GuideCountrysBundle:Country')->findOneById($id);
        $view = $this->view($country, 200);
        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing country entity.
     *
     * @Route("/{id}/edit", name="country_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Country $country)
    {
        $deleteForm = $this->createDeleteForm($country);
        $editForm = $this->createForm('Guide\CountrysBundle\Form\CountryType', $country);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('country_edit', array('id' => $country->getId()));
        }

        return $this->render('GuideCountrysBundle:Country:edit.html.twig', array(
            'country' => $country,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a country entity.
     *
     * @Route("/{id}", name="country_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Country $country)
    {
        $form = $this->createDeleteForm($country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($country);
            $em->flush($country);
        }

        return $this->redirectToRoute('country_index');
    }

    /**
     * Creates a form to delete a country entity.
     *
     * @param Country $country The country entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Country $country)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('country_delete', array('id' => $country->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
