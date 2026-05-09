# ============================================================
# COPYRIGHT NOTICE
# This code is proprietary and the sole property of Arjunanda.
# Unauthorized use, copying, or distribution is strictly prohibited 
# without explicit written permission from the owner.
# Copyright (c) 2026 Arjunanda.
# ============================================================

.PHONY: help build up down restart logs shell artisan

# Default target
help:
	@echo ""
	@echo "  ██╗   ██╗███████╗███╗   ██╗████████╗██╗   ██╗███████╗"
	@echo "  ██║   ██║██╔════╝████╗  ██║╚══██╔══╝██║   ██║╚══███╔╝"
	@echo "  ██║   ██║█████╗  ██╔██╗ ██║   ██║   ██║   ██║  ███╔╝ "
	@echo "  ╚██╗ ██╔╝██╔══╝  ██║╚██╗██║   ██║   ██║   ██║ ███╔╝  "
	@echo "   ╚████╔╝ ███████╗██║ ╚████║   ██║   ╚██████╔╝███████╗"
	@echo "    ╚═══╝  ╚══════╝╚═╝  ╚═══╝   ╚═╝    ╚═════╝ ╚══════╝"
	@echo ""
	@echo "  Available commands:"
	@echo ""
	@echo "  make pull       - Pull latest changes from git"
	@echo "  make build      - Build Docker images"
	@echo "  make deploy     - Full deployment (pull + build + up)"
	@echo "  make update     - Update and restart (pull + build + restart)"
	@echo "  make up         - Start all containers (detached)"
	@echo "  make down       - Stop and remove containers"
	@echo "  make restart    - Restart all containers"
	@echo "  make logs       - Follow logs from app container"
	@echo "  make shell      - Open shell inside app container"
	@echo "  make artisan    - Run artisan command (e.g: make artisan CMD='migrate')"
	@echo "  make fresh      - Fresh migrate with seeders"
	@echo "  make cache      - Clear and re-warm all caches"
	@echo "  make octane     - Reload Octane workers (zero-downtime)"
	@echo "  make sync       - Sync code changes WITHOUT rebuilding (PHP/Blade/config)"
	@echo "  make env        - Update .env inside container only (no rebuild)"
	@echo ""

# ── Git ──────────────────────────────────────────────────────
pull:
	@echo "📥 Pulling latest changes from git..."
	git pull origin main

# ── Build ────────────────────────────────────────────────────
build:
	@echo "🔨 Building Docker image..."
	cp .env.docker .env
	docker compose build --no-cache

# ── Start ────────────────────────────────────────────────────
up:
	@echo "🚀 Starting Vincere Store containers..."
	docker compose up -d
	@echo "✅ Running at http://localhost:8000"
	@echo "📡 Reverb WebSocket at ws://localhost:8080"

# ── Stop ─────────────────────────────────────────────────────
down:
	@echo "🛑 Stopping containers..."
	docker compose down

# ── Restart ──────────────────────────────────────────────────
restart:
	docker compose restart app

# ── Logs ─────────────────────────────────────────────────────
logs:
	docker compose logs -f app

logs-redis:
	docker compose logs -f redis

# ── Shell ────────────────────────────────────────────────────
shell:
	docker compose exec -it app bash

# ── Artisan ──────────────────────────────────────────────────
artisan:
	docker compose exec app php artisan $(CMD)

# ── Database ─────────────────────────────────────────────────
fresh:
	docker compose exec app php artisan migrate:fresh --seed --force

migrate:
	docker compose exec app php artisan migrate --force

seed:
	docker compose exec app php artisan db:seed --force


# ── Cache ────────────────────────────────────────────────────
cache:
	docker compose exec app php artisan optimize:clear
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache
	docker compose exec app php artisan event:cache
	@echo "✅ All caches refreshed!"

# ── Octane: Zero-downtime reload ─────────────────────────────
octane:
	docker compose exec app php artisan octane:reload
	@echo "⚡ Octane workers reloaded!"

# ── Deploy (pull + build + up) ───────────────────────────────
deploy:
	@echo "🚢 Deploying latest version..."
	make pull
	make build
	make up
	@echo "🎉 Deployment complete!"

# ── Update (pull + restart) ──────────────────────────────────
update:
	make pull
	make build
	make restart
	@echo "🔄 Application updated to latest version!"

# ── Sync: Push code changes WITHOUT rebuilding image ─────────
# Use this for quick PHP/Blade/config changes.
# Does NOT apply dependency or Dockerfile changes.
sync:
	@echo "⚡ Syncing code changes to running container..."
	make pull
	docker cp app/. ventuz_app:/var/www/html/app/
	docker cp resources/. ventuz_app:/var/www/html/resources/
	docker cp routes/. ventuz_app:/var/www/html/routes/
	docker cp config/. ventuz_app:/var/www/html/config/
	docker cp database/. ventuz_app:/var/www/html/database/
	docker compose exec app php artisan optimize:clear
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache
	docker compose exec app php artisan octane:reload
	@echo "✅ Sync complete! No rebuild needed."

# ── Env: Update .env inside running container only ───────────
# Use this when you only changed .env.docker values.
env:
	@echo "🔧 Updating .env inside container..."
	cp .env.docker .env
	docker cp .env ventuz_app:/var/www/html/.env
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan octane:reload
	@echo "✅ Environment updated without rebuild!"
