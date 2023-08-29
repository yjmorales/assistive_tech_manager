<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Controller\Admin;

use App\Controller\Core\BaseController;
use App\Controller\Core\Exception\ValidationException;
use App\Entity\Client;
use App\Form\ClientFormType;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Manages a client.
 *
 * @Route("/admin/client")
 */
class ClientController extends BaseController
{
    /**
     * Lists the clients.
     *
     * @Route("/", name="admin_client_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $clients = $this->repository($doctrine, Client::class)->findAll();

        return $this->render('/admin/authenticated/client/list.html.twig', [
            'clients'    => $clients,
            'breadcrumb' => [
                'Dashboard' => $this->generateUrl('admin_dashboard'),
                'Clients'   => $this->generateUrl('admin_client_list'),
            ]
        ]);
    }

    /**
     * Creates a new client entity.
     *
     * @Route("/create", name="admin_client_create")
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
        $entity   = new Client();
        $form     = $this->createForm(ClientFormType::class, $entity);
        $response = $this->render('/admin/authenticated/client/create.html.twig', [
            'entity'     => $entity,
            'form'       => $form->createView(),
            'breadcrumb' => [
                'Dashboard'     => $this->generateUrl('admin_dashboard'),
                'Clients'       => $this->generateUrl('admin_client_list'),
                'Create client' => $this->generateUrl('admin_client_create'),
            ],
        ]);

        try {
            if (!$this->_save($request, $doctrine, $form, $entity)) {
                return $response;
            }
        } catch (ValidationException $e) {
            $this->notifyError('The data you provided are not secure data inputs.');

            return $response;
        }

        return $this->redirectToRoute('admin_client_list');
    }

    /**
     * Edits a new client entity.
     *
     * @Route("/{id}/edit", name="admin_client_edit")
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param Client          $entity
     *
     * @return Response
     *
     * @throws Exception
     */
    public function edit(Request $request, ManagerRegistry $doctrine, Client $entity): Response
    {
        $form            = $this->createForm(ClientFormType::class, $entity);
        $successResponse = $this->redirectToRoute('admin_client_list');

        $failureResponse = $this->render('/admin/authenticated/client/edit.html.twig', [
            'form'       => $form->createView(),
            'entity'     => $entity,
            'breadcrumb' => [
                'Dashboard'     => $this->generateUrl('admin_dashboard'),
                'Clients'       => $this->generateUrl('admin_client_list'),
                'Edit Platform' => $this->generateUrl('admin_client_edit', [
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
     * Removes a client entity.
     *
     * @Route("/{id}/remove", name="admin_client_remove")
     *
     * @param ManagerRegistry $doctrine
     * @param client          $entity
     *
     * @return Response
     */
    public function remove(ManagerRegistry $doctrine, client $entity): Response
    {
        $this->em($doctrine)->remove($entity);
        $this->em($doctrine)->flush();

        return $this->redirectToRoute('admin_client_list');
    }

    /**
     * Handles common actions used to save a client.
     *
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param FormInterface   $form
     * @param client          $entity
     *
     * @return bool
     * @throws Exception
     */
    private function _save(Request $request, ManagerRegistry $doctrine, FormInterface $form, client $entity): bool
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

        if (!$isValid) {
            throw new ValidationException('Invalid validation.');
        }

        $em = $this->em($doctrine);
        $em->persist($entity);
        $em->flush();

        $isEdit = (bool)$entity->getId();
        if ($isEdit) {
            $this->notifySuccess("The client \"{$entity->getName()}\" has been successfully updated.");
        } else {
            $this->notifySuccess("The client \"{$entity->getName()}\" has been successfully created.");
        }

        return true;
    }
}
