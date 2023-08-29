<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Controller\Admin;

use App\Controller\Core\BaseController;
use App\Controller\Core\Exception\ValidationException;
use App\Entity\ATDevice;
use App\Form\ATDeviceFormType;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Manage the ATDevices pages.
 *
 * @Route("/admin/at-device")
 */
class ATDeviceController extends BaseController
{
    /**
     * Lists the devices
     *
     * @Route("/", name="admin_at_device_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        return $this->render('/admin/authenticated/at_device/list.html.twig', [
            'atDevices'  => $this->repository($doctrine, ATDevice::class)->findAll(),
            'breadcrumb' => [
                'Dashboard'  => $this->generateUrl('admin_dashboard'),
                'AT Devices' => $this->generateUrl('admin_at_device_list'),
            ]
        ]);
    }

    /**
     * Creates a new entity.
     *
     * @Route("/create", name="admin_at_device_create")
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
        $entity = new ATDevice();
        $form   = $this->createForm(ATDeviceFormType::class, $entity);

        $failureResponse = $this->render('/admin/authenticated/at_device/create.html.twig', [
            'entity'     => $entity,
            'form'       => $form->createView(),
            'breadcrumb' => [
                'Dashboard'        => $this->generateUrl('admin_dashboard'),
                'AT Device'        => $this->generateUrl('admin_at_device_list'),
                'Create AT Device' => $this->generateUrl('admin_at_device_create'),
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

        return $this->redirectToRoute('admin_at_device_list');
    }

    /**
     * Edits a new device entity.
     *
     * @Route("/{id}/edit", name="admin_at_device_edit")
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param ATDevice        $entity
     *
     * @return Response
     *
     * @throws Exception
     */
    public function edit(Request $request, ManagerRegistry $doctrine, ATDevice $entity): Response
    {
        $form            = $this->createForm(ATDeviceFormType::class, $entity);
        $failureResponse = $this->render('/admin/authenticated/at_device/edit.html.twig', [
            'form'       => $form->createView(),
            'entity'     => $entity,
            'breadcrumb' => [
                'Dashboard'      => $this->generateUrl('admin_dashboard'),
                'AT Devices'     => $this->generateUrl('admin_at_device_list'),
                'Edit AT Device' => $this->generateUrl('admin_at_device_edit', [
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

        return $this->redirectToRoute('admin_at_device_list');
    }

    /**
     * Removes an entity.
     *
     * @Route("/{id}/remove", name="admin_at_device_remove")
     *
     * @param ManagerRegistry $doctrine
     * @param ATDevice        $entity
     *
     * @return Response
     */
    public function remove(ManagerRegistry $doctrine, ATDevice $entity): Response
    {
        $this->em($doctrine)->remove($entity);
        $this->em($doctrine)->flush();

        return $this->redirectToRoute('admin_at_device_list');
    }

    /**
     * Handles common actions used to save entity.
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param FormInterface   $form
     * @param ATDevice        $entity
     *
     * @return bool
     * @throws Exception
     */
    private function _save(Request $request, ManagerRegistry $doctrine, FormInterface $form, ATDevice $entity): bool
    {
        /*
         * Skipping if not submitted or invalid form.
         */
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        // Validator
        if (!$this->validator()->isValidString($entity->getName())) {
            throw new ValidationException('Invalid validation.');
        }

        $em = $this->em($doctrine);
        $em->persist($entity);
        $em->flush();

        $isEdit = (bool)$entity->getId();
        if ($isEdit) {
            $this->notifySuccess("The AT Device \"{$entity->getName()}\" has been successfully updated.");
        } else {
            $this->notifySuccess("The AT Device \"{$entity->getName()}\" has been successfully created.");
        }

        return true;
    }
}
