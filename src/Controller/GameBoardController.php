<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameBoardController
{
    #[Route('/board', name: 'app_game_board')]
    public function index(): Response
    {
        // TODO change to name from request
        $name = $this->randomName();

        // TODO
        return new Response();
    }

    private function randomName():string {
        $names = [
            'Abbott', 'Abernathy', 'Abshire', 'Adams', 'Altenwerth', 'Anderson',
            'Bahringer', 'Bailey', 'Balistreri', 'Barrows', 'Bartell', 'Bartoletti', 'Barton',
            'Carroll', 'Carter', 'Cartwright', 'Casper', 'Cassin', 'Champlin', 'Christiansen', 'Cole',
            'Jacobi', 'Jacobs', 'Jacobson', 'Jakubowski', 'Jaskolski',
            'Rath', 'Ratke', 'Rau', 'Raynor',
            'Sanford', 'Satterfield', 'Sauer',
            'Vandervort', 'Veum', 'Volkman',
            'Waelchi', 'Walker', 'Walsh', 'Walter', 'Ward', 'Waters',
        ];
        return $names[array_rand($names)];
    }
}
