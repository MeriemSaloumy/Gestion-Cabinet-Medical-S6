# 🏥 Gestion de Cabinet Médical - Laravel

Projet universitaire de gestion de consultations et rendez-vous médicaux.

## 🛠️ État Actuel du Projet (Backend & Sécurité)
J'ai mis en place l'architecture de base du projet :
- **Authentification Rôles** : Système intégré pour différencier Admin, Médecin, Secrétaire et Patient.
- **Middleware de Sécurité** : Protection des accès via `RoleManager`. Un utilisateur ne peut accéder qu'aux pages de son rôle.
- **Redirection Dynamique** : Aiguillage automatique après connexion vers le dashboard spécifique.

## 🚀 Installation (Pour l'équipe)
1. `git clone [URL_DU_REPO]`
2. `composer install` && `npm install`
3. Configurer le `.env` (Base de données : `cabinet_medical`)
4. `php artisan migrate --seed`
5. `php artisan serve`

## 👥 Comptes de test par défaut
- **Admin** : admin@test.com / password
- **Médecin** : doctor@test.com / password
