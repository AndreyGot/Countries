<?php

namespace Guide\CountrysBundle\Controller;

use Guide\CountrysBundle\Entity\Country;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Country controller.
 *
 * @Route("country")
 */
class CountryController extends FOSRestController
{
    /**
     * Lists all country entities.
     * @ApiDoc(
     *  description="Get list of countries",
     *  section = "Country",
     * )
     * @Route("", name="country_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em        = $this->getDoctrine()->getManager();
        $countries = $em->getRepository('GuideCountrysBundle:Country')->findAll();
        $view      = $this->view($countries, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Lists all country entities.
     * @ApiDoc(
     *  description="Get list of cities for country",
     *  section = "Country"
     * )
     * @Route("/list/{id}", name="city_list")
     * @Method("GET")
     */
    public function listCityAction(Request $request, $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $country = $em->getRepository('GuideCountrysBundle:Country')->findOneById($id);
        if(!$country){
            throw new HttpException(Response::HTTP_NOT_FOUND, "Not found.");
        }
        $view = $this->view($country->getCitys(), Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Creates a new country entity.
     * @ApiDoc(
     *  description="Creates a new country entity",
     *  section = "Country",
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

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush($country);
            $view      = $this->view($country, Response::HTTP_OK);
            return $this->handleView($view);
        }
        $view = $this->view($form, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a country entity.
     *
     * @ApiDoc(
     *  description="show a country entity by id",
     *  section = "Country",
     *  output="Guide\CountrysBundle\Entity\Country"
     * )
     * @Route("/{id}", name="country_show")
     * @Method("GET")
     */
    public function showAction(Request $request, $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $country = $em->getRepository('GuideCountrysBundle:Country')->findOneById($id);
        if(!$country){
            throw new HttpException(Response::HTTP_NOT_FOUND, "Not found.");
        }
        $view = $this->view($country, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing country entity.
     * @ApiDoc(
     *  description="Update country entity",
     *  section = "Country",
     *  input="Guide\CountrysBundle\Form\CountryType",
     *  output="Guide\CountrysBundle\Entity\Country"
     * )
     * @Route("/edit/{id}", name="country_edit")
     * @Method("PUT")
     */
    public function editAction(Request $request, $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $country = $em->getRepository('GuideCountrysBundle:Country')->findOneById($id);
        if(!$country){
            throw new HttpException(Response::HTTP_NOT_FOUND, "Not found.");
        }

        $params = array('method' => 'PUT');
        $editForm = $this->createForm('Guide\CountrysBundle\Form\CountryType', $country, $params);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();
            $view = $this->view($country, Response::HTTP_OK);
            return $this->handleView($view);
        }
        $view = $this->view($editForm, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Deletes a country entity.
     *
     * @ApiDoc(
     *  description="Deletes a country entity by id",
     *  section = "Country",
     *  output="Guide\CountrysBundle\Entity\Country"
     * )
     * @Route("/{id}", name="country_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $country = $em->getRepository('GuideCountrysBundle:Country')->findOneById($id);
        if(!$country){
            throw new HttpException(Response::HTTP_NOT_FOUND, "Not found.");
        }
        $em->remove($country);
        $em->flush();
        $view = $this->view($country, Response::HTTP_OK);
        return $this->handleView($view);
    }
}