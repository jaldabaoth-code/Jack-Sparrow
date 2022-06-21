<?php

namespace App\Service;

use App\Entity\Boat;
use App\Entity\Tile;
use App\Repository\TileRepository;
use Doctrine\ORM\EntityManagerInterface;

class MapManager
{
    private TileRepository $tileRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(TileRepository $tileRepository, EntityManagerInterface $entityManager)
    {
        $this->tileRepository = $tileRepository;
        $this->entityManager = $entityManager;
    }

    public function tileExists(int $x, int $y): bool
    {
        if($this->tileRepository->findOneBy(['coordX' => $x, 'coordY' => $y])) {
            return true;
        }
        return false;
    }

    public function getRandomIsland(): Tile
    {
        $tiles = $this->tileRepository->findByType('island');
        $island = $tiles[array_rand($tiles)];
        return $island;
    }

    public function resetPositionTreasure(): void
    {
        $tiles = $this->tileRepository->findAll();
        foreach ($tiles as $tile) {
            $tile->setHasTreasure(false);
            $this->entityManager->flush();
        }
    }

    public function checkTreasure(Boat $boat): bool
    {
        $tileTreasure = $this->tileRepository->findOneBy(['hasTreasure' => true]);
        if (($boat->getCoordX() == $tileTreasure->getCoordX()) && ($boat->getCoordY() == $tileTreasure->getCoordY())) {
            return true;
        }
        return false;
    }
}
