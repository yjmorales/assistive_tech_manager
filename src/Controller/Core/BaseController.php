<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */


namespace App\Controller\Core;

use Common\DataManagement\Validator\DataValidator;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    /**
     * Helper function to build the dir where are saved the qr images.
     *
     * @param bool $excludePublicDirectory Indicator of whether is used the `public` directory on the path or not.
     *
     * @return string
     */
    protected function getDirectoryTeamMemberPicture(bool $excludePublicDirectory = true): string
    {
        $directory = $this->getParameter('directory.team_member_picture');
        if (!$excludePublicDirectory) {
            $directory = "{$this->getParameter('kernel.project_dir')}/public/$directory";
        }

        return $directory;
    }

    /**
     * Returns the public path for a relative path. It returns `public/$path`
     *
     * @param string $path
     *
     * @return string
     */
    protected function getPublicDirPath(string $path): string
    {
        return "{$this->getParameter('kernel.project_dir')}/public/$path";
    }

    /**
     * Helper function to create a directory.
     *
     * @param string $path Path of the dir to be created.
     *
     * @return void
     *
     * @throws Exception
     */
    protected function createDir(string $path): void
    {
        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true)) {
                throw new Exception('Unable to create team member directory');
            }
        }
    }


    /**
     * Uploads a given file into a given directory.
     *
     * @param UploadedFile|null $file    File to upload. If null then the function returns null.
     * @param SluggerInterface  $slugger Adds security.
     * @param string            $path    Directory to save the file.
     *
     * @return string|null Returns the relative path of the saved file. If the file is not given then returns null.
     *
     * @throws Exception
     */
    protected function uploadFile(?UploadedFile $file, SluggerInterface $slugger, string $path): ?string
    {
        if (!$file) {
            return null;
        }

        if (!file_exists($path)) {
            mkdir($path);
        }

        try {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename     = $slugger->slug($originalFilename);
            $uniqueId         = uniqid();
            $newFilename      = "$safeFilename-$uniqueId.{$file->guessExtension()}";
            $file->move($path, $newFilename);

            return $newFilename;
        } catch (FileException $e) {
            throw new Exception("Error uploading a file into $path", 0, $e);
        }
    }
}