<?php

namespace Metalslave\FinancialBundle\Controller;

use Metalslave\FinancialBundle\Entity\TransactionCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Transactioncategory controller.
 *
 * @Route("transaction_category")
 */
class TransactionCategoryController extends Controller
{
    /**
     * Lists all transactionCategory entities.
     *
     * @Route("/", name="transaction_category_index")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transactionCategories = $em->getRepository('MetalslaveFinancialBundle:TransactionCategory')->findAll();

        return $this->render('@MetalslaveFinancial/transactioncategory/index.html.twig', array(
            'transactionCategories' => $transactionCategories,
        ));
    }

    /**
     * Creates a new transactionCategory entity.
     *
     * @Route("/new", name="transaction_category_new")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        $transactionCategory = new Transactioncategory();
        $form = $this->createForm('Metalslave\FinancialBundle\Form\TransactionCategoryType', $transactionCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transactionCategory);
            $em->flush();

            return $this->redirectToRoute('transaction_category_show', array('id' => $transactionCategory->getId()));
        }

        return $this->render('@MetalslaveFinancial/transactioncategory/new.html.twig', array(
            'transactionCategory' => $transactionCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a transactionCategory entity.
     *
     * @Route("/{id}", name="transaction_category_show")
     *
     * @Method("GET")
     *
     * @param TransactionCategory $transactionCategory
     *
     * @return Response
     */
    public function showAction(TransactionCategory $transactionCategory)
    {
        $deleteForm = $this->createDeleteForm($transactionCategory);

        return $this->render('@MetalslaveFinancial/transactioncategory/show.html.twig', array(
            'transactionCategory' => $transactionCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transactionCategory entity.
     *
     * @Route("/{id}/edit", name="transaction_category_edit")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request             $request
     * @param TransactionCategory $transactionCategory
     *
     * @return Response
     */
    public function editAction(Request $request, TransactionCategory $transactionCategory)
    {
        $deleteForm = $this->createDeleteForm($transactionCategory);
        $editForm = $this->createForm('Metalslave\FinancialBundle\Form\TransactionCategoryType', $transactionCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_category_edit', array('id' => $transactionCategory->getId()));
        }

        return $this->render('@MetalslaveFinancial/transactioncategory/edit.html.twig', array(
            'transactionCategory' => $transactionCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transactionCategory entity.
     *
     * @Route("/{id}", name="transaction_category_delete")
     *
     * @Method("DELETE")
     *
     * @param Request             $request
     * @param TransactionCategory $transactionCategory
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, TransactionCategory $transactionCategory)
    {
        $form = $this->createDeleteForm($transactionCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transactionCategory);
            $em->flush();
        }

        return $this->redirectToRoute('transaction_category_index');
    }

    /**
     * Creates a form to delete a transactionCategory entity.
     *
     * @param TransactionCategory $transactionCategory The transactionCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TransactionCategory $transactionCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transaction_category_delete', array('id' => $transactionCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
