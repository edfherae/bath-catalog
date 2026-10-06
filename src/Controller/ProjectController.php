<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\DTO\ProjectFilter;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends AbstractController {
    #[Route('/', name: 'app_home')]
    public function home(): Response {
        return $this->redirectToRoute('app_projects');
    }
    #[Route('/projects', 'app_projects')]
    public function index(Request $request, ProjectRepository $repository) : Response {
        $filter = new ProjectFilter(
            $request->query->getInt('area_min') ?: null,
            $request->query->getInt('area_max') ?: null,
            array_map('intval', $request->query->all('floors')),
            $request->query->has('has_pool') ? $request->query->getBoolean('has_pool') : null
        );
        
        $page = max(1, $request->query->getInt('page', 1));
        $perPage = 6;

        $result = $repository->findFiltered($filter, $page, $perPage);
        $totalPages = (int) ceil($result['total'] / $perPage);

        return $this->render('project/index.html.twig', [
            'projects' => $result['items'],
            'filter' => $filter,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $result['total']
        ]);
    }
}