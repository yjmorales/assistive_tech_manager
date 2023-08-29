<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */


namespace App\Controller\Core;

use Common\DataManagement\Validator\DataValidator;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller abstraction to be used by all controller classes.
 */
class BaseController extends AbstractController
{
    /**
     * Responsible to validate user input.
     *
     * @var DataValidator|null
     */
    private ?DataValidator $dataValidator = null;

    /**
     * Returns the corresponding repository
     *
     * @param ManagerRegistry $registry  Used to retrieve the data.
     * @param string          $className Class name of the requested repository.
     * @param string|null     $em        Entity Manager name.
     *
     * @return ObjectRepository
     */
    protected function repository(ManagerRegistry $registry, string $className, string $em = null): ObjectRepository
    {
        return $this->em($registry, $em)->getRepository($className);
    }

    /**
     * Returns an Entity Manager
     *
     * @param ManagerRegistry $registry
     * @param string|null     $em
     *
     * @return ObjectManager
     */
    protected function em(ManagerRegistry $registry, string $em = null): ObjectManager
    {
        return $registry->getManager($em);
    }

    /**
     * Use this function to notify a success user event.
     *
     * @param string|null $message Message to be added within the notification.
     *
     * @return void
     */
    protected function notifySuccess(string $message = null): void
    {
        $this->addFlash('success', $message ?? 'Action performed successfully.');
    }

    /**
     * Use this function to notify an error user event.
     *
     * @param string|null $message
     *
     * @return void
     */
    protected function notifyError(string $message = null): void
    {
        $this->addFlash('error', $message ?? 'An error occur.');
    }

    /**
     * Use this function to notify an error user event.
     *
     * @param string|null $message
     *
     * @return void
     */
    protected function notifyWarning(string $message = null): void
    {
        $this->addFlash('warning', $message ?? 'You should check the performed action.');
    }

    /**
     * Responsible to returns a single instance of data validator.
     *
     * @return DataValidator
     */
    protected function validator(): DataValidator
    {
        if (!$this->dataValidator) {
            $this->dataValidator = new DataValidator();
        }

        return $this->dataValidator;
    }
}