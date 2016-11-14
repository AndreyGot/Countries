<?php

namespace Guide\CountrysBundle\Controller;

use Guide\CountrysBundle\Entity\City;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * City controller.
 *
 * @Route("city")
 */
class CityController extends FOSRestController
{
    /**
     * Lists all city entities.
     * @ApiDoc(
     *  description="Get list of countries",
     *  section = "City",
     * )
     * @Route("", name="city_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em        = $this->getDoctrine()->getManager();
        $cities    = $em->getRepository('GuideCountrysBundle:City')->findAll();
        $view      = $this->view($cities, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Creates a new city entity.
     * @ApiDoc(
     *  description="Creates a new city entity",
     *  section = "City",
     *  input="Guide\CountrysBundle\Form\CityType",
     *  output="Guide\CountrysBundle\Entity\City"
     * )
     * @Route("/new", name="city_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $city = new City();
        $form = $this->createForm('Guide\CountrysBundle\Form\CityType', $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush($city);

            $view      = $this->view($city, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Finds and displays a city entity.
     * @ApiDoc(
     *  description="show a city entity by id",
     *  section = "City",
     *  output="Guide\CountrysBundle\Entity\City"
     * )
     * @Route("/{id}", name="city_show")
     * @Method("GET")
     */
    public function showAction(Request $request, $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $city = $em->getRepository('GuideCountrysBundle:City')->findOneById($id);
        if(!$city){
            throw new HttpException(Response::HTTP_NOT_FOUND, "Not found.");
        }
        $view = $this->view($city, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing city entity.
     * @ApiDoc(
     *  description="Update city entity",
     *  section = "City",
     *  input="Guide\CountrysBundle\Form\CityType",
     *  output="Guide\CountrysBundle\Entity\City"
     * )
     * @Route("/edit/{id}", name="city_edit")
     * @Method("PUT")
     */
    public function editAction(Request $request, $id)
    {
        $em   = $this->getDoctrine()->getManager();
        $city = $em->getRepository('GuideCountrysBundle:City')->findOneById($id);
        if(!$city){
            throw new HttpException(Response::HTTP_NOT_FOUND, "Not found.");
        }

        $params   = array('method' => 'PUT');
        $editForm = $this->createForm('Guide\CountrysBundle\Form\CityType', $city, $params);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();
            $view = $this->view($city, Response::HTTP_OK);
            return $this->handleView($view);
        }
        $view = $this->view($editForm, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * Deletes a city entity.
     * @ApiDoc(
     *  description="Deletes a city entity by id",
     *  section = "City",
     *  output="Guide\CountrysBundle\Entity\City"
     * )
     * @Route("/{id}", name="city_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $city = $em->getRepository('GuideCountrysBundle:City')->findOneById($id);
        if(!$city){
            throw new HttpException(Response::HTTP_NOT_FOUND, "Not found.");
        }
        $em->remove($city);
        $em->flush();
        $view = $this->view($city, Response::HTTP_OK);
        return $this->handleView($view);
    }

}