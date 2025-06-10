
#  Starfox Rail Shooter — Backend API Symfony

Ce projet constitue le **backend complet** d’un jeu vidéo type rail shooter, réalisé en Symfony, inspiré de Starfox.  
Il expose toutes les ressources nécessaires au jeu (armes, vaisseaux, ennemis, niveaux, obstacles…) via une API REST structurée, et gère la persistance des scores et des sessions de jeu.

---

##  Stack technique

- **Symfony  / PHP **
- **Doctrine ORM / MySQL**
- **Fixtures** pour l’initialisation de la base
- **NelmioCorsBundle** (CORS)
- **API REST** 

---

##  Installation & démarrage rapide

1. **Clonez ce repo**
   ```bash
   git clone https://github.com/TON-GITHUB/starfox-backend.git
   cd starfox-backend
   ```

2. **Installez les dépendances**
   ```bash
   composer install
   ```

3. **Configurez la base de données**
   - Modifiez `.env` avec vos identifiants MySQL :
     ```
     DATABASE_URL="mysql://username:@127.0.0.1:8000/dbname?serverVersion=8.0"
     ```

4. **Créez la base et appliquez les migrations**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Chargez les données de démo (fixtures)**
   ```bash
   php bin/console doctrine:fixtures:load
   ```

6. **Lancez le serveur**
   ```bash
   symfony serve
   ```
   ou
   ```bash
   php -S 127.0.0.1:8000 -t public
   ```

---

##  Routes API principales 

| Méthode | URL                   | Description                                      |
|---------|-----------------------|--------------------------------------------------|
| GET     | `/api/weapons`        | Liste toutes les armes du jeu                    |
| GET     | `/api/items`          | Liste tous les items (bonus, power-ups)          |
| GET     | `/api/spaceships`     | Liste tous les vaisseaux jouables                |
| GET     | `/api/enemies`        | Liste tous les types d’ennemis                   |
| GET     | `/api/obstacles`      | Liste tous les types d’obstacles                 |
| GET     | `/api/levels`         | Liste tous les niveaux du jeu                    |
| GET     | `/api/levels/{id}`    | Détail d’un niveau (avec JSON)                   |
| GET     | `/api/scores`         | Classement (scores enregistrés)                  |
| POST    | `/api/scores`         | Enregistre une session de jeu (voir payload)     |

---

##  Schéma de la base de données 

- **Player** : id, username, createdAt
- **GameSession** : id, player (FK), score, level, startedAt, endedAt
- **Level** : id, name, jsonData, createdAt
- **LevelEvent** : id, level (FK), triggerZ, eventType, params, sequenceOrder, createdAt
- **Weapon** : id, name, damage, cooldown, type, levelRequired, createdAt
- **ItemDefinition** : id, itemKey, name, effectType, effectValue, iconPath, createdAt
- **Spaceship** : id, name, baseHp, baseSpeed, maxBombs, createdAt, updatedAt
- **EnemyType** : id, name, hp, speed, pattern, fireInterval, modelPath, createdAt
- **ObstacleType** : id, name, shape, dimensions, createdAt


---

##  Test et intégration

- **Toutes les routes API ont été testées** et sont fonctionnelles.
- **Connexion front** : Le front  Vite peut faire des fetch sur toutes ces routes. CORS est déjà configuré pour le développement.

---

##  Fiche technique 

- **Projet 100 % API REST**, indépendant du frontend
- **Entities Doctrine structurées** selon les besoins d’un jeu Starfox-like
- **Gestion complète du cycle de vie** : création BDD, migration, données de test (fixtures), routes API, CORS


---


## 📚 Documentation & outils utiles

- [Documentation Symfony](https://symfony.com/doc/current/index.html)
- [Documentation NelmioCorsBundle (CORS)](https://symfony.com/doc/current/bundles/NelmioCorsBundle/index.html)
- [Tester l’API avec Postman](https://learning.postman.com/docs/getting-started/introduction/)

---

## 🔥 CRUD complet sur toutes les entités du jeu

Chaque ressource du jeu dispose désormais d’un CRUD complet (API REST) :

- **GET** (liste et détail), **POST** (création), **PUT** (modification), **DELETE** (suppression)
- Entités concernées : **Weapons, Spaceships, Levels, EnemyTypes, ObstacleTypes, ItemDefinitions**

---


##  Conseils à mes camarades

- **Pour voir la structure** : ouvrez les entités dans `/src/Entity`
- **Pour tester** : lancez le serveur, faites vos requêtes HTTP sur `http://127.0.0.1:8000/api/...`
- **Pour peupler la base** : relancez les fixtures autant de fois que nécessaire
- **Pour adapter** : ajoutez/éditez les fixtures dans `/src/DataFixtures/GameFixtures.php`  
- **Pour étendre** : créez d’autres endpoints (GET/POST/PUT) 

---

##  Projet scolaire 


