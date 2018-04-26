<?php

namespace Metalslave\FinancialBundle\Controller;

use Metalslave\FinancialBundle\Entity\AccountCurrency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Accountcurrency controller.
 *
 * @Route("account_currency")
 */
class AccountCurrencyController extends Controller
{
    /**
     * Lists all accountCurrency entities.
     *
     * @Route("/", name="account_currency_index")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accountCurrencies = $em->getRepository('MetalslaveFinancialBundle:AccountCurrency')->findAll();

        return $this->render('@MetalslaveFinancial/accountcurrency/index.html.twig', array(
            'accountCurrencies' => $accountCurrencies,
        ));
    }

    /**
     * Creates a new accountCurrency entity.
     *
     * @Route("/new", name="account_currency_new")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        $accountCurrency = new Accountcurrency();
        $form = $this->createForm('Metalslave\FinancialBundle\Form\AccountCurrencyType', $accountCurrency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accountCurrency);
            $em->flush();

            return $this->redirectToRoute('account_currency_show', array('id' => $accountCurrency->getId()));
        }

        return $this->render('@MetalslaveFinancial/accountcurrency/new.html.twig', array(
            'accountCurrency' => $accountCurrency,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a accountCurrency entity.
     *
     * @Route("/{id}", name="account_currency_show")
     *
     * @Method("GET")
     *
     * @param AccountCurrency $accountCurrency
     *
     * @return Response
     */
    public function showAction(AccountCurrency $accountCurrency)
    {
        $deleteForm = $this->createDeleteForm($accountCurrency);

        return $this->render('@MetalslaveFinancial/accountcurrency/show.html.twig', array(
            'accountCurrency' => $accountCurrency,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing accountCurrency entity.
     *
     * @Route("/{id}/edit", name="account_currency_edit")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request         $request
     * @param AccountCurrency $accountCurrency
     *
     * @return Response
     */
    public function editAction(Request $request, AccountCurrency $accountCurrency)
    {
        $deleteForm = $this->createDeleteForm($accountCurrency);
        $editForm = $this->createForm('Metalslave\FinancialBundle\Form\AccountCurrencyType', $accountCurrency);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_currency_edit', array('id' => $accountCurrency->getId()));
        }

        return $this->render('@MetalslaveFinancial/accountcurrency/edit.html.twig', array(
            'accountCurrency' => $accountCurrency,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a accountCurrency entity.
     *
     * @Route("/{id}", name="account_currency_delete")
     *
     * @Method("DELETE")
     *
     * @param Request         $request
     * @param AccountCurrency $accountCurrency
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, AccountCurrency $accountCurrency)
    {
        $form = $this->createDeleteForm($accountCurrency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($accountCurrency);
            $em->flush();
        }

        return $this->redirectToRoute('account_currency_index');
    }

    /**
     * Creates a form to delete a accountCurrency entity.
     *
     * @param AccountCurrency $accountCurrency The accountCurrency entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AccountCurrency $accountCurrency)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('account_currency_delete', array('id' => $accountCurrency->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
