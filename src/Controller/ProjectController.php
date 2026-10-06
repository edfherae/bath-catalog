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
    #[Route('/projects', name: 'app_projects')]
    public function index(Request $request, ProjectRepository $repository) : Response {
        $filter = new ProjectFilter(
            filter_var($request->query->get('area_min'), FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE),
            filter_var($request->query->get('area_max'), FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE),
            array_map('intval', $request->query->all('floors')),
            $request->query->has('has_pool') ? $request->query->getBoolean('has_pool') : null
        );
        
        $page = max(1, $request->query->getInt('page', 1));
        $perPage = 6;

        $result = $repository->findFiltered($filter, $page, $perPage);
        $totalPages = (int) ceil($result['total'] / $perPage);

        $queryParams = [];
        if ($filter->areaMin !== null) {
            $queryParams['area_min'] = $filter->areaMin;
        }
        if ($filter->areaMax !== null) {
            $queryParams['area_max'] = $filter->areaMax;
        }
        if (!empty($filter->floors)) {
            $queryParams['floors'] = $filter->floors;
        }
        if ($filter->hasPool !== null) {
            $queryParams['has_pool'] = $filter->hasPool ? 1 : 0;
        }

        return $this->render('project/index.html.twig', [
            'projects' => $result['items'],
            'filter' => $filter,
            'queryParams' => $queryParams,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $result['total']
        ]);
    }
}