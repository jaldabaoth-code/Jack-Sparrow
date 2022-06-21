<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Service\MapManager;
use App\Repository\BoatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/boat")
 */
class BoatController extends AbstractController
{
    /**
     * Move the boat to coord x,y
     * @Route("/move/{x}/{y}", name="moveBoat", requirements={"x"="\d+", "y"="\d+"}))
     */
    public function moveBoat(int $x, int $y, BoatRepository $boatRepository, EntityManagerInterface $entityManager): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX($x);
        $boat->setCoordY($y);
        $entityManager->flush();
        return $this->redirectToRoute('map');
    }

    /**
     * Move the boat to N, S, E, W
     * @Route("/direction/{direction}", name="moveDirection", requirements={"direction"="[NSEW]"})
     */
    public function moveDirection(string $direction, BoatRepository $boatRepository, EntityManagerInterface $entityManager, MapManager $mapManager): Response {
        $boat = $boatRepository->findOneBy([]);
        switch ($direction) {
            case 'N':
                $y = $boat->getCoordY() - 1;
                $boat->setCoordY($y);
                break;
            case 'S':
                $y = $boat->getCoordY() + 1;
                $boat->setCoordY($y);
                break;
            case 'E':
                $x = $boat->getCoordX() + 1;
                $boat->setCoordX($x);
                break;
            case 'W':
                $x = $boat->getCoordX() - 1;
                $boat->setCoordX($x);
                break;
        }
        if ($mapManager->tileExists($boat->getCoordX(), $boat->getCoordY())) {
            $hasTreasure = $mapManager->checkTreasure($boat);
            if($hasTreasure) {
                $this->addFlash('info', 'You find treasure');
            }
            $entityManager->flush();
        } else {
            $this->addFlash('danger', 'You cant move there');
        }
        return $this->redirectToRoute('map');
    }
}
