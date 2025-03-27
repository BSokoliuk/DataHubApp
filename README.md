# DataHubApp

## Prerequisites (which I used and project works)
- **Node.js**: `v22.14.0`
- **npm**: `10.9.2`
- **Composer**: `2.8.6`
- **PHP**: `8.2.4`
- **Symfony CLI**: Installed globally
- **Quasar CLI**: `2.5.0`

## Tech Stack
### Frontend
- Vue Composition API
- Pinia
- Quasar Framework
- TypeScript
- Axios
- UUID

### Backend
- Symfony (using `validator`, `orm-pack`, `maker-bundle`)
- SQLite
---

## Installation and Setup

### Frontend
1. Navigate to the frontend directory (if applicable).
2. Install dependencies:
   ```bash
   npm install
3. Start the development server:
   ```bash
   quasar dev
### Backend
1. Navigate to the backend directory (if applicable).
2. Install dependencies:
   ```bash
   composer install
3. Run database migrations:
   ```bash
   php bin/console doctrine:migrations:migrate
4. Start the Symfony server:
   ```bash
    symfony serve