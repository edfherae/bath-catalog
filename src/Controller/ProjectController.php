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
    #[Route('projects', 'app_projects')]
    public function index(ProjectRepository $repository) : Response {
        $projects = $repository->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects
        ]);
    }
}