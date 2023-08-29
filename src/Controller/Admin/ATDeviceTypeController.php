<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Controller\Admin;

use App\Controller\Core\BaseController;
use App\Entity\ATDeviceType;
use App\Form\ATDeviceTypeFormType;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Renders the dashboard page.
 *
 * @Route("/admin/at-device-type")
 */
class ATDeviceTypeController extends BaseController
{
    /**
     * @Route("/", name="admin_at_device_type_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $atDeviceTypes = $this->repository($doctrine, ATDeviceType::class)->findAll();

        return $this->render('/admin/authenticated/at_device_type/list.html.twig', [
            'atDeviceTypes' => $atDeviceTypes,
            'breadcrumb'    => [
                'Dashboard'       => $this->generateUrl('admin_dashboard'),
                'AT Device Types' => $this->generateUrl('admin_at_device_type_list'),
            ]
        ]);
    }

    /**
     * Creates a new at device type entity.
     *
     * @Route("/create", name="admin_at_device_type_create")
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
        $entity = new ATDeviceType();
        $form   = $this->createForm(ATDeviceTypeFormType::class, $entity);
        $saved  = $this->_save($request, $doctrine, $form, $entity);

        if (!$saved) {
            return $this->render('/admin/authenticated/at_device_type/create.html.twig', [
                'entity'     => $entity,
                'form'       => $form->createView(),
                'breadcrumb' => [
                    'Dashboard'             => $this->generateUrl('admin_dashboard'),
                    'AT Device Types'       => $this->generateUrl('admin_at_device_type_list'),
                    'Create AT Device Type' => $this->generateUrl('admin_at_device_type_create'),
                ],
            ]);
        }

        return $this->redirectToRoute('admin_at_device_type_list');
    }

    /**
     * Edits a new at device type entity.
     *
     * @Route("/{id}/edit", name="admin_at_device_type_edit")
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param ATDeviceType    $entity
     *
     * @return Response
     *
     * @throws Exception
     */
    public function edit(Request $request, ManagerRegistry $doctrine, ATDeviceType $entity): Response
    {
        $form     = $this->createForm(ATDeviceTypeFormType::class, $entity);
        $response = $this->redirectToRoute('admin_at_device_type_list');

        if (!$this->_save($request, $doctrine, $form, $entity)) {
            return $this->render('/admin/authenticated/at_device_type/edit.html.twig', [
                'form'       => $form->createView(),
                'entity'     => $entity,
                'breadcrumb' => [
                    'Dashboard'           => $this->generateUrl('admin_dashboard'),
                    'AT Device Types'     => $this->generateUrl('admin_at_device_type_list'),
                    'Edit AT Device Type' => $this->generateUrl('admin_at_device_type_edit', [
                        'id' => $entity->getId()
                    ]),
                ],
            ]);
        }

        return $response;
    }

    /**
     * Removes an at device type entity.
     *
     * @Route("/{id}/remove", name="admin_at_device_type_remove")
     *
     * @param ManagerRegistry $doctrine
     * @param ATDeviceType    $entity
     *
     * @return Response
     */
    public function remove(ManagerRegistry $doctrine, ATDeviceType $entity): Response
    {
        $this->em($doctrine)->remove($entity);
        $this->em($doctrine)->flush();

        return $this->redirectToRoute('admin_at_device_type_list');
    }

    /**
     * Handles common actions used to save an at device type.
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param FormInterface   $form
     * @param ATDeviceType    $entity
     *
     * @return bool
     * @throws Exception
     */
    private function _save(Request $request, ManagerRegistry $doctrine, FormInterface $form, ATDeviceType $entity): bool
    {        /*
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
            throw new Exception('Invalid validation.');
        }

        $em = $this->em($doctrine);
        $em->persist($entity);
        $em->flush();

        $isEdit = (bool)$entity->getId();
        if ($isEdit) {
            $this->notifySuccess("The AT Device Type \"{$entity->getName()}\" has been successfully updated.");
        } else {
            $this->notifySuccess("The AT Device Type \"{$entity->getName()}\" has been successfully created.");
        }

        return true;
    }
}
