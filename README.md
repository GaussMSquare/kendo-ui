# Symfony Kendo UI Project

This project is a Symfony application with Kendo UI integration, running in Docker containers.

## Prerequisites

- Docker
- Docker Compose
- Make (optional, but recommended)

## Quick Start

1. Clone the repository:
```bash
git clone <repository-url>
cd <project-directory>
```

2. Initialize and run the project (using Make):
```bash
make init
```

This will:
- Build Docker containers
- Install Symfony and its dependencies
- Set up the database
- Install frontend dependencies

3. Start the project:
```bash
make start
```

The application will be available at: http://localhost:8080

## Available Make Commands

- `make init`: Initial project setup
- `make up`: Start Docker containers
- `make stop`: Stop Docker containers
- `make db-migrate`: Run database migrations
- `make test-unit`: Run unit tests

## Manual Installation (without Make)

If you don't have Make installed, you can run the commands manually:

```bash
docker-compose build
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php php bin/console doctrine:migrations:migrate
```

## Project Structure

- `docker/`: Docker configuration files
- `src/`: Symfony application source code
- `templates/`: Twig templates
- `tests/`: Test files
- `public/`: Public assets and entry point

## Testing

Run the test suite:
```bash
make test
```

## Contributing

1. Create a feature branch
2. Commit your changes
3. Push to the branch
4. Create a Pull Request

## License

This project is licensed under the MIT License.