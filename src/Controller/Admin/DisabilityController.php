<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Controller\Admin;

use App\Controller\Core\BaseController;
use App\Entity\Disability;
use App\Form\DisabilityFormFormType;
use App\Controller\Core\Exception\ValidationException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Renders the Disability pages.
 *
 * @Route("/admin/disability")
 */
class DisabilityController extends BaseController
{
    /**
     * @Route("/", name="admin_disability_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $disabilities = $this->repository($doctrine, Disability::class)->findAll();

        return $this->render('/admin/authenticated/disability/list.html.twig', [
            'disabilities' => $disabilities,
            'breadcrumb'   => [
                'Dashboard'    => $this->generateUrl('admin_dashboard'),
                'Disabilities' => $this->generateUrl('admin_disability_list'),
            ]
        ]);
    }

    /**
     * Creates a new disability entity.
     *
     * @Route("/create", name="admin_disability_create")
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     *
     * @return Response
     *
     * @throws Exception
     */
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $entity = new Disability();
        $form   = $this->createForm(DisabilityFormFormType::class, $entity);

        $response = $this->render('/admin/authenticated/disability/create.html.twig', [
            'entity'     => $entity,
            'form'       => $form->createView(),
            'breadcrumb' => [
                'Dashboard'         => $this->generateUrl('admin_dashboard'),
                'Disabilities'      => $this->generateUrl('admin_disability_list'),
                'Create disability' => $this->generateUrl('admin_disability_create'),
            ],
        ]);

        try {
            if (!$this->_save($request, $doctrine, $form, $entity)) {
                $this->notifyError('The data you provided are not secure data inputs.');

                return $response;
            }
        } catch (ValidationException $e) {
            $this->notifyError('The data you provided are not secure data inputs.');

            return $response;
        }

        return $this->redirectToRoute('admin_disability_list');
    }

    /**
     * Edits a new disability entity.
     *
     * @Route("/{id}/edit", name="admin_disability_edit")
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param Disability      $entity
     *
     * @return Response
     *
     * @throws Exception
     */
    public function edit(Request $request, ManagerRegistry $doctrine, Disability $entity): Response
    {
        $form     = $this->createForm(DisabilityFormFormType::class, $entity);
        $successResponse = $this->redirectToRoute('admin_disability_list');

        $failureResponse = $this->render('/admin/authenticated/disability/edit.html.twig', [
            'form'       => $form->createView(),
            'entity'     => $entity,
            'breadcrumb' => [
                'Dashboard'     => $this->generateUrl('admin_dashboard'),
                'Disabilities'  => $this->generateUrl('admin_disability_list'),
                'Edit Platform' => $this->generateUrl('admin_disability_edit', [
                    'id' => $entity->getId()
                ]),
            ],
        ]);

        try {
            if (!$this->_save($request, $doctrine, $form, $entity)) {
                $this->notifyError('The data you provided are not secure data inputs.');

                return $failureResponse;
            }
        } catch (ValidationException $e) {
            $this->notifyError('The data you provided are not secure data inputs.');

            return $failureResponse;
        }

        return $successResponse;
    }

    /**
     * Removes a disability entity.
     *
     * @Route("/{id}/remove", name="admin_disability_remove")
     *
     * @param ManagerRegistry $doctrine
     * @param Disability      $entity
     *
     * @return Response
     */
    public function remove(ManagerRegistry $doctrine, Disability $entity): Response
    {
        $this->em($doctrine)->remove($entity);
        $this->em($doctrine)->flush();

        return $this->redirectToRoute('admin_disability_list');
    }

    /**
     * Handles common actions used to save a disability.
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param FormInterface   $form
     * @param Disability      $entity
     *
     * @return bool
     * @throws Exception
     */
    private function _save(Request $request, ManagerRegistry $doctrine, FormInterface $form, Disability $entity): bool
    {
        /*
         * Skipping if not submitted or invalid form.
         */
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        // Validator
        $isValid = $this->validator()->isValidString($entity->getName());
        $isValid &= $this->validator()->isValidString($entity->getDescription(), null, null, false);

        if (!$isValid) {
            throw new ValidationException('Invalid validation.');
        }

        $em = $this->em($doctrine);
        $em->persist($entity);
        $em->flush();

        $isEdit = (bool)$entity->getId();
        if ($isEdit) {
            $this->notifySuccess("The disability \"{$entity->getName()}\" has been successfully updated.");
        } else {
            $this->notifySuccess("The disability \"{$entity->getName()}\" has been successfully created.");
        }

        return true;
    }
}
