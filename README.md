Voici un modèle de README pour votre projet de gestion de tâches, avec des sections adaptées aux exercices pratiques et à la structure de votre projet. Vous pouvez ajouter les captures d'écran à l'endroit approprié pour compléter la documentation.

---

# TaskManagerTest

## Description

Ce projet est une application web de gestion de tâches, permettant de réaliser différentes opérations comme l'ajout, la suppression et l'affichage des tâches. Le projet inclut également des tests fonctionnels et des tests de performance pour garantir son bon fonctionnement et ses performances sous charge.

## Structure du projet

Le projet se compose de plusieurs répertoires et fichiers principaux :

```
TaskManagerTest/
├── class/
│   └── TaskManager.php          # Classe principale de gestion des tâches
├── docker/
│   ├── k6/                      # Configuration pour les tests de charge avec k6
│   └── php/                     # Configuration Docker pour l'environnement PHP
├── results/                     # Résultats des tests
├── tests/
│   └── TaskManagerTest.php      # Tests fonctionnels de l'application
├── .gitignore                   # Fichier de configuration Git pour ignorer certains fichiers
├── composer.json                # Gestionnaire de dépendances pour le projet PHP
├── composer.lock                # Fichier de verrouillage des versions des dépendances
└── index.html                   # Page d'accueil de l'application
```

### Fichiers clés :

- **TaskManager.php** : Fichier principal qui contient la logique de gestion des tâches (ajout, suppression, récupération des tâches).
- **TaskManagerTest.php** : Tests unitaires et fonctionnels pour l'application.
- **Dockerfile** dans les répertoires `docker/php` et `docker/k6` : Configuration Docker pour l'environnement PHP et pour effectuer des tests de charge.
- **.gitignore** : Liste des fichiers et répertoires à ignorer par Git.

## Fonctionnalités principales

L'application permet de gérer des tâches avec les fonctionnalités suivantes :

- **Ajouter une tâche** : Ajouter une tâche à la liste des tâches.
- **Supprimer une tâche** : Supprimer une tâche existante.
- **Afficher toutes les tâches** : Récupérer et afficher toutes les tâches existantes.
- **Récupérer une tâche spécifique** : Afficher une tâche spécifique par son identifiant.
- **Gestion des erreurs** : Gestion des erreurs liées à des index invalides pour la suppression et la récupération des tâches.

## Scénarios de test

### Tests à effectuer

1. **testAddTask** : Vérifier que l'ajout d'une tâche fonctionne correctement.
2. **testRemoveTask** : Vérifier que la suppression d'une tâche fonctionne correctement.
3. **testGetTasks** : Vérifier que l'affichage de toutes les tâches est correct.
4. **testGetTask** : Vérifier que la récupération d'une tâche spécifique fonctionne.
5. **testRemoveInvalidIndexThrowsException** : Vérifier que la suppression d'une tâche avec un index invalide génère une exception.
6. **testGetInvalidIndexThrowsException** : Vérifier que la récupération d'une tâche avec un index invalide génère une exception.
7. **testTaskOrderAfterRemoval** : Vérifier que l'ordre des tâches est maintenu après la suppression d'une tâche.

### Tests E2E avec Cypress ou Selenium

Automatisez le scénario suivant sur l'application de gestion de tâches :

1. Connexion à l'application.
2. Ajout d'une nouvelle tâche.
3. Vérification de son affichage dans la liste.
4. Suppression de la tâche et vérification de sa disparition.

### Test de non-régression

Après l'ajout d'une nouvelle fonctionnalité (par exemple : ajout d'une échéance aux tâches), exécutez une suite de tests automatisés pour vérifier que les fonctionnalités existantes ne sont pas impactées.

### Analyse des performances

**k6** pour effectuer des tests de performance. Par exemple :

1. Simulez plusieurs utilisateurs interagissant avec l'application (exemple : 50 utilisateurs ajoutant des tâches simultanément).
2. Analysez les temps de réponse du serveur et identifiez les goulots d'étranglement.

## Mise en place de l'environnement

### Prérequis

- Docker et Docker Compose pour configurer l'environnement
- Selenium pour les tests E2E

### Installation

1. Clonez ce repository sur votre machine locale :

   ```bash
   git clone https://github.com/Enstso/TaskManagerTest.git
   ```

2. Build l'image du Dockerfile php :

```bash
docker build -f .\docker\php\Dockerfile -t mon-apache-php .
```

3. Lancez le container du php:
   Sur windows:

```bash
 docker run --rm -it -v ${PWD}:/var/www -w /var/www mon-apache-php bash
```

4. Dans le container:

```bash
    composer install
```

5. Lancer les tests:

```bash
composer tests ou ./vendor/bin/phpunit tests (composer)
```

### Tests E2E

Pour l'exercice 2:

1. renommer index_ex2.html en index.html.

2. Lancer un serveur web python en localhost:

```bash
    python -m http.server 8000 --bind 127.0.0.1
```

3. L'application sera accessible à l'adresse suivante :  
   `http://127.0.0.1:8080`

4. On effectue les tests suivants avec selenium:

- Ajout d'une nouvelle tâche
- Vérification de son affichage dans la liste
- Suppression de la tâche et vérification de sa disparition

Pour l'exercice 3:

1. renommer index_ex3.html en index.html.

2. Lancer un serveur web python en localhost:

```bash
    python -m http.server 8000 --bind 127.0.0.1
```

3. L'application sera accessible à l'adresse suivante :  
   `http://127.0.0.1:8080`

4. On effectue les tests suivants avec selenium:

Un localstorage a été mis en place, cela fais que après un rafraichissement de la page, la tâche sera toujours présent, vu que cette nouvelle fonctionnalité a été ajouter, nous voir si les ancciennes fonctionnalités sont toujours fonctionnels(Test de régression).

- Ajout d'une nouvelle tâche (après l'action rafraichir).
- Vérification de son affichage dans la liste
- Suppression de la tâche et vérification de sa disparition (après l'action rafraichir).

### nalyse des performances avec k6

### Lancer les tests de performance

1. Build l'image du Dockerfile k6 :

```bash
docker build -f .\docker\k6\Dockerfile -t dock-k6 .
```

2. Lancez le container du k6:

Sur windows:

```bash
docker run --rm -v ${PWD}\results:/usr/src/app/results -p 8080:8080 dock-k6
```

Nous pouvons apercevoir, que le serveur renvoie un timeout, due au nombreuse requête:

Les contre-mesures face à cela sont de limiter un trop grand nombre de requêtes simultanés, il sera nécessaire de mettre en place cela en prenant ern compte les ressources du serveur hébergeant le service requété.


