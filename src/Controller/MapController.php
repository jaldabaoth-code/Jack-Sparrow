<?php

namespace App\Controller;

use App\Entity\Tile;
use App\Service\MapManager;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     */
    public function displayMap(BoatRepository $boatRepository, MapManager $mapManager): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tiles = $entityManager->getRepository(Tile::class)->findAll();
        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }
        $boat = $boatRepository->findOneBy([]);
        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'boat' => $boat,
        ]);
    }

    /**
     * @Route("/start", name="start")
     */
    public function start(BoatRepository $boatRepository, EntityManagerInterface $entityManager, MapManager $mapManager): Response
    {   
        $mapManager->resetPositionTreasure();
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX(0);
        $boat->setCoordY(0);
        $randomIsland = $mapManager->getRandomIsland();
        $randomIsland->setHastreasure(true);
        $entityManager->flush();
        return $this->redirectToRoute('map');
    }
}
