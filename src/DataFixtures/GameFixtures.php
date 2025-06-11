<?php

namespace App\DataFixtures;

use App\Entity\Weapon;
use App\Entity\ItemDefinition;
use App\Entity\Spaceship;
use App\Entity\EnemyType;
use App\Entity\ObstacleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ----- Weapons -----
        $laser = (new Weapon())
            ->setName('Laser vert')
            ->setDamage(10)
            ->setCooldown(0.3)
            ->setType('laser')
            ->setLevelRequired(0)
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($laser);

        $laserBlue = (new Weapon())
            ->setName('Laser bleu')
            ->setDamage(20)
            ->setCooldown(0.25)
            ->setType('laser')
            ->setLevelRequired(1)
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($laserBlue);

        $laserRed = (new Weapon())
            ->setName('Laser rouge')
            ->setDamage(40)
            ->setCooldown(0.20)
            ->setType('laser')
            ->setLevelRequired(2)
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($laserRed);

        $bomb = (new Weapon())
            ->setName('Bombe')
            ->setDamage(100)
            ->setCooldown(2.0)
            ->setType('bomb')
            ->setLevelRequired(0)
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($bomb);

        // ----- Items -----
        $silver = (new ItemDefinition())
            ->setItemKey('silver')
            ->setName('Anneau d\'argent')
            ->setEffectType('heal')
            ->setEffectValue(25)
            ->setIconPath('/icons/silver.png')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($silver);

        $gold = (new ItemDefinition())
            ->setItemKey('gold')
            ->setName('Anneau d\'or')
            ->setEffectType('heal')
            ->setEffectValue(100)
            ->setIconPath('/icons/gold.png')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($gold);

        $laserBlueItem = (new ItemDefinition())
            ->setItemKey('laser_blue')
            ->setName('Module laser bleu')
            ->setEffectType('upgrade_weapon')
            ->setEffectValue(1)
            ->setIconPath('/icons/laser_blue.png')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($laserBlueItem);

        $laserRedItem = (new ItemDefinition())
            ->setItemKey('laser_red')
            ->setName('Module laser rouge')
            ->setEffectType('upgrade_weapon')
            ->setEffectValue(2)
            ->setIconPath('/icons/laser_red.png')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($laserRedItem);

        $bombItem = (new ItemDefinition())
            ->setItemKey('bomb')
            ->setName('Bonus bombe')
            ->setEffectType('add_bomb')
            ->setEffectValue(1)
            ->setIconPath('/icons/bomb.png')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($bombItem);

        // ----- Spaceships -----
        $fox = (new Spaceship())
            ->setName('Starfox')
            ->setHealth(100)
            ->setSpeed(7.5)
            ->setMaxBombs(3)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($fox);

        // ----- Enemies -----
        $drone = (new EnemyType())
            ->setName('Drone')
            ->setHp(20)
            ->setSpeed(6.0)
            ->setPattern('{"vx":6,"rangeX":12}')
            ->setFireInterval(2.0)
            ->setModelPath('/models/drone.glb')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($drone);

        $turret = (new EnemyType())
            ->setName('Tourelle')
            ->setHp(40)
            ->setSpeed(0.0)
            ->setPattern('{"vx":0,"rangeX":0}')
            ->setFireInterval(1.2)
            ->setModelPath('/models/turret.glb')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($turret);

        // ----- Obstacles -----
        $arch = (new ObstacleType())
            ->setName('Arche')
            ->setShape('mesh')
            ->setDimensions([
                'width' => 6,
                'height' => 8,
                'depth' => 2
            ])
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($arch);

        $building = (new ObstacleType())
            ->setName('Bâtiment')
            ->setShape('box')
            ->setDimensions([
                    'width' => 4,
                    'height' => 10,
                    'depth' => 4
                ])
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($building);

        // ----- Commit all -----
        $manager->flush();
    }
}