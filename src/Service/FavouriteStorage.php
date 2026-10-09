<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavouriteStorage {
    private const SESSION_KEY = "favourite";

    public function __construct(
        private readonly RequestStack $requestStack
    ) {}

    public function getAll(): array {
        return $this->getSession()->get(self::SESSION_KEY, []);
    }
    public function count(): int {
        return count($this->getAll());
    }
    public function has(int $projectId): bool {
        return in_array($projectId, $this->getAll(), true);
    }
    // true - теперь в избранном, false - удален из избранного 
    public function toggle(int $projectId): bool {
        $favourites = $this->getAll();
        $key = array_search($projectId, $favourites, true);
        if($key !== false) {
            unset($favourites[$key]);
            $isFavourite = false;
        } else {
            $isFavourite = true; 
            array_push($favourites, $projectId);
        }

        $this->getSession()->set(self::SESSION_KEY, array_values($favourites));

        return $isFavourite;       
    }
    public function clear(): void {
        $this->requestStack->getSession()->remove(self::SESSION_KEY);
    }
    private function getSession(): SessionInterface {
        return $this->requestStack->getSession();
    }
}