# QualitEau 💧

**Qualité de l'Eau Potable**

> Exploiter une API gouvernementale open data pour visualiser la qualité de l'eau.

Ce projet a été réalisé dans le cadre du [DevChallenges Week 50](https://devchallenges.yoandev.co/challenge/week-50/).

## 👨‍💻 Auteur

**Jatniel Guzmán**

-   🌐 [Website](https://jatniel.dev/)
-   🐙 [GitHub](https://github.com/jatniel)
-   🐦 [X / Twitter](https://x.com/jatnieldev)

## 🚀 Pré-requis

Pour une expérience de développement optimale, je recommande l'utilisation de :

-   **[Bun](https://bun.sh/)** : Pour une gestion ultra-rapide des dépendances et du build frontend.
-   **[Redis](https://redis.io/)** : Pour gérer efficacement le cache et les files d'attente.

## 🛠 Installation

Suivez ces instructions pour mettre en place le projet sur votre machine locale.

### 1. Cloner le repository

```bash
git clone https://github.com/jatniel/QualitEau.git
cd QualitEau
```

### 2. Installer les dépendances

**Back-end (PHP/Composer)**

```bash
composer install
```

**Front-end (Bun)**

```bash
bun install
```

### 3. Configuration de l'environnement

Dupliquez le fichier d'exemple et générez la clé d'application.

```bash
cp .env.example .env
php artisan key:generate
```

> **Note :** Assurez-vous de configurer votre connexion à la base de données et à Redis dans le fichier `.env`.

### 4. Base de données

Exécutez les migrations pour configurer la structure de la base de données.

```bash
php artisan migrate
```

### 5. Lancer le projet

Vous aurez besoin de deux terminaux :

**Terminal 1 : Serveur Laravel**

```bash
php artisan serve
```

**Terminal 2 : Compilation des assets (Vite)**

```bash
bun dev
```

Rendez-vous sur [`http://127.0.0.1:8000`](http://127.0.0.1:8000) pour voir l'application.

## 🏗 Stack Technique

-   **Laravel** (Backend framework)
-   **Livewire** (Dynamic frontend)
-   **Tailwind CSS** (Styling)
-   **Redis** (Cache & Queues)
-   **Bun** (JS Runtime & Package Manager)

## 📄 Licence

Ce projet est sous licence [MIT](https://opensource.org/licenses/MIT).

---

_Développé avec ❤️ par Jatniel Guzmán_
