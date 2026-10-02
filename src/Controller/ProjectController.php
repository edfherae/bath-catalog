<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// use App\Repository\ProjectRepository;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Sy

class ProjectController extends AbstractController {
    #[Route('/', name: 'app_home')]
    public function home(): Response {
        return $this->redirectToRoute('app_projects');
    }
    #[Route('/projects', 'app_projects')]
    public function index(ProjectRepository $repository) : Response {
        $projects = $repository->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects
        ]);
    }
}