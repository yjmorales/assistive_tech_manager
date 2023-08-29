<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Controller\Admin;

use App\Controller\Core\BaseController;
use App\Controller\Core\Exception\ValidationException;
use App\Entity\ATPlatform;
use App\Form\ATPlatformFormType;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Renders the platform pages.
 *
 * @Route("/admin/platform")
 */
class PlatformController extends BaseController
{
    /**
     * @Route("/", name="admin_platform_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $platforms = $this->repository($doctrine, ATPlatform::class)->findAll();

        return $this->render('/admin/authenticated/platform/list.html.twig', [
            'platforms'  => $platforms,
            'breadcrumb' => [
                'Dashboard' => $this->generateUrl('admin_dashboard'),
                'Platforms' => $this->generateUrl('admin_platform_list'),
            ]
        ]);
    }

    /**
     * Creates a new platform entity.
     *
     * @Route("/create", name="admin_platform_create")
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
        $entity          = new ATPlatform();
        $form            = $this->createForm(ATPlatformFormType::class, $entity);
        $failureResponse = $this->render('/admin/authenticated/platform/create.html.twig', [
            'entity'     => $entity,
            'form'       => $form->createView(),
            'breadcrumb' => [
                'Dashboard'       => $this->generateUrl('admin_dashboard'),
                'Platforms'       => $this->generateUrl('admin_platform_list'),
                'Create platform' => $this->generateUrl('admin_platform_create'),
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

        return $this->redirectToRoute('admin_platform_list');
    }

    /**
     * Edits a new platform entity.
     *
     * @Route("/{id}/edit", name="admin_platform_edit")
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param ATPlatform      $entity
     *
     * @return Response
     *
     * @throws Exception
     */
    public function edit(Request $request, ManagerRegistry $doctrine, ATPlatform $entity): Response
    {
        $form            = $this->createForm(ATPlatformFormType::class, $entity);
        $failureResponse = $this->render('/admin/authenticated/platform/edit.html.twig', [
            'form'       => $form->createView(),
            'entity'     => $entity,
            'breadcrumb' => [
                'Dashboard'     => $this->generateUrl('admin_dashboard'),
                'Platforms'     => $this->generateUrl('admin_platform_list'),
                'Edit Platform' => $this->generateUrl('admin_platform_edit', [
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

        return $this->redirectToRoute('admin_platform_list');
    }

    /**
     * Removes a platform entity.
     *
     * @Route("/{id}/remove", name="admin_platform_remove")
     *
     * @param ManagerRegistry $doctrine
     * @param ATPlatform      $entity
     *
     * @return Response
     */
    public function remove(ManagerRegistry $doctrine, ATPlatform $entity): Response
    {
        $this->em($doctrine)->remove($entity);
        $this->em($doctrine)->flush();

        return $this->redirectToRoute('admin_platform_list');
    }

    /**
     * Handles common actions used to save a platform.
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param FormInterface   $form
     * @param ATPlatform      $entity
     *
     * @return bool
     * @throws Exception
     */
    private function _save(Request $request, ManagerRegistry $doctrine, FormInterface $form, ATPlatform $entity): bool
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
            $this->notifySuccess("The platform \"{$entity->getName()}\" has been successfully updated.");
        } else {
            $this->notifySuccess("The platform \"{$entity->getName()}\" has been successfully created.");
        }

        return true;
    }
}
