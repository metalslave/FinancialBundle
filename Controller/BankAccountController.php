<?php

namespace Metalslave\FinancialBundle\Controller;

use Metalslave\FinancialBundle\Entity\BankAccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bankaccount controller.
 *
 * @Route("bank_account")
 */
class BankAccountController extends Controller
{
    /**
     * Lists all bankAccount entities.
     *
     * @Route("/", name="bank_account_index")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bankAccounts = $em->getRepository('MetalslaveFinancialBundle:BankAccount')->findAll();

        return $this->render('@MetalslaveFinancial/bankaccount/index.html.twig', array(
            'bankAccounts' => $bankAccounts,
        ));
    }

    /**
     * Creates a new bankAccount entity.
     *
     * @Route("/new", name="bank_account_new")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        $bankAccount = new Bankaccount();
        $form = $this->createForm('Metalslave\FinancialBundle\Form\BankAccountType', $bankAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bankAccount);
            $em->flush();

            return $this->redirectToRoute('bank_account_show', array('id' => $bankAccount->getId()));
        }

        return $this->render('@MetalslaveFinancial/bankaccount/new.html.twig', array(
            'bankAccount' => $bankAccount,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bankAccount entity.
     *
     * @Route("/{id}", name="bank_account_show")
     *
     * @Method("GET")
     *
     * @param BankAccount $bankAccount
     *
     * @return Response
     */
    public function showAction(BankAccount $bankAccount)
    {
        $deleteForm = $this->createDeleteForm($bankAccount);

        return $this->render('@MetalslaveFinancial/bankaccount/show.html.twig', array(
            'bankAccount' => $bankAccount,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bankAccount entity.
     *
     * @Route("/{id}/edit", name="bank_account_edit")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request     $request
     * @param BankAccount $bankAccount
     *
     * @return Response
     */
    public function editAction(Request $request, BankAccount $bankAccount)
    {
        $deleteForm = $this->createDeleteForm($bankAccount);
        $editForm = $this->createForm('Metalslave\FinancialBundle\Form\BankAccountType', $bankAccount);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bank_account_edit', array('id' => $bankAccount->getId()));
        }

        return $this->render('@MetalslaveFinancial/bankaccount/edit.html.twig', array(
            'bankAccount' => $bankAccount,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bankAccount entity.
     *
     * @Route("/{id}", name="bank_account_delete")
     *
     * @Method("DELETE")
     *
     * @param Request     $request
     * @param BankAccount $bankAccount
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, BankAccount $bankAccount)
    {
        $form = $this->createDeleteForm($bankAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bankAccount);
            $em->flush();
        }

        return $this->redirectToRoute('bank_account_index');
    }

    /**
     * Creates a form to delete a bankAccount entity.
     *
     * @param BankAccount $bankAccount The bankAccount entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BankAccount $bankAccount)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bank_account_delete', array('id' => $bankAccount->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
