<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Controller\Admin;

use App\Controller\Core\BaseController;
use App\Entity\ATDevice;
use App\Entity\ATDeviceType;
use App\Entity\ATPlatform;
use App\Entity\Client;
use App\Entity\Disability;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Renders the dashboard page.
 *
 * @Route("/admin")
 */
class DashboardController extends BaseController
{
    /**
     * @Route("/", name="admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('/admin/authenticated/dashboard/dashboard.html.twig');
    }

    /**
     * @Route("/setup", name="admin_dashboard_setup")
     */
    public function setup(ManagerRegistry $doctrine): Response
    {
        $em = $this->em($doctrine);

        $this->_clearDb($doctrine);

        // DEVICE TYPES
        $reader = new ATDeviceType();
        $reader->setName('Screen readers');
        $reader->setDescription('A screen reader is an assistive technology, primarily used by people with vision impairments.');
        $em->persist($reader);

        $magnifiers = new ATDeviceType();
        $magnifiers->setName('Screen magnifiers');
        $magnifiers->setDescription('A screen reader is an assistive technology, primarily used by people with vision impairments.');
        $em->persist($magnifiers);

        $em->flush();

        // PLATFORMS
        $windows = new ATPlatform();
        $windows->setName('Windows');
        $windows->setDescription('Microsoft Windows is a group of several proprietary graphical operating system families developed and marketed by Microsoft. Each family caters to a certain sector of the computing industry. ');
        $em->persist($windows);

        $macOs = new ATPlatform();
        $macOs->setName('Mac OS X');
        $macOs->setDescription('macOS, previously OS X and originally Mac OS X) is an operating system developed and marketed by Apple Inc. since 2001.');
        $em->persist($macOs);

        $linux = new ATPlatform();
        $linux->setName('Linux');
        $linux->setDescription('GNU/Linux.');
        $em->persist($linux);

        $em->flush();

        // DEVICES
        $NVDA = new ATDevice();
        $NVDA->setName('NVDA');
        $NVDA->setAtPlatform($windows);
        $NVDA->setAtDeviceType($reader);
        $em->persist($NVDA);

        $JAWS = new ATDevice();
        $JAWS->setName('JAWS');
        $JAWS->setAtPlatform($windows);
        $JAWS->setAtDeviceType($reader);
        $em->persist($JAWS);

        $Voiceover = new ATDevice();
        $Voiceover->setName('Voiceover');
        $Voiceover->setAtPlatform($macOs);
        $Voiceover->setAtDeviceType($reader);
        $em->persist($Voiceover);

        $ZoomText = new ATDevice();
        $ZoomText->setName('ZoomText');
        $ZoomText->setAtPlatform($linux);
        $ZoomText->setAtDeviceType($magnifiers);
        $em->persist($ZoomText);

        // DISABILITIES
        $blindness = new Disability();
        $blindness->setName('Blindness');
        $blindness->setDescription('Complete loss of vision or inability to see anything.');
        $em->persist($blindness);

        $lowVision = new Disability();
        $lowVision->setName('Low Vision');
        $lowVision->setDescription('Severe visual impairment that cannot be fully corrected with eyeglasses or contact lenses.');
        $em->persist($lowVision);

        $LegalBlindness = new Disability();
        $LegalBlindness->setName('Legal Blindness');
        $LegalBlindness->setDescription('A legal definition that varies by country but is generally defined as having visual acuity of 20/200.');
        $em->persist($LegalBlindness);

        $macular = new Disability();
        $macular->setName('Macular Degeneration');
        $macular->setDescription('A progressive disease that affects the macula, leading to central vision loss while peripheral vision remains intact.');
        $em->persist($macular);

        // CLIENT
        $client1 = new Client();
        $client1->setName('Peter');
        $client1->setLastname('Smith');
        $client1->setAge(40);
        $client1->getDisability()->add($blindness);
        $em->persist($client1);

        $client2 = new Client();
        $client2->setName('Jon');
        $client2->setLastname('Harper');
        $client2->setAge(36);
        $client2->getDisability()->add($lowVision);
        $em->persist($client2);

        $client3 = new Client();
        $client3->setName('Nick');
        $client3->setLastname('Lorenzen');
        $client3->setAge(27);
        $client3->getDisability()->add($LegalBlindness);
        $em->persist($client3);

        $em->flush();

        return $this->redirectToRoute('admin_client_list');
    }

    /**
     * Helper function to clear the db.
     *
     * @param ManagerRegistry $doctrine
     *
     * @return void
     */
    private function _clearDb(ManagerRegistry $doctrine): void
    {
        $em = $this->em($doctrine);

        $clients      = $em->getRepository(Client::class)->findAll();
        $disabilities = $em->getRepository(Disability::class)->findAll();
        $devices      = $em->getRepository(ATDevice::class)->findAll();
        $platforms    = $em->getRepository(ATPlatform::class)->findAll();
        $deviceTypes  = $em->getRepository(ATDeviceType::class)->findAll();

        $this->_removeItemsFromDb($clients, $em);
        $this->_removeItemsFromDb($disabilities, $em);
        $this->_removeItemsFromDb($devices, $em);
        $this->_removeItemsFromDb($platforms, $em);
        $this->_removeItemsFromDb($deviceTypes, $em);

        $em->flush();
    }

    /**
     * Helper function to remove a family of items from db.
     *
     * @param array         $items
     * @param ObjectManager $em
     *
     * @return void
     */
    private function _removeItemsFromDb(array $items, ObjectManager $em): void
    {
        foreach ($items as $item) {
            $em->remove($item);
        }
    }
}
