<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Renders the dashboard page.
 *
 * @Route("/admin")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('/admin/authenticated/dashboard/dashboard.html.twig');
    }
}
