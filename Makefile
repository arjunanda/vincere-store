# ============================================================
# Ventuz Store - Docker Makefile
# Usage: make <command>
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
	@echo "  make build      - Build Docker image"
	@echo "  make up         - Start all containers (detached)"
	@echo "  make down       - Stop and remove containers"
	@echo "  make restart    - Restart all containers"
	@echo "  make logs       - Follow logs from app container"
	@echo "  make shell      - Open shell inside app container"
	@echo "  make artisan    - Run artisan command (e.g: make artisan CMD='migrate')"
	@echo "  make fresh      - Fresh migrate with seeders"
	@echo "  make cache      - Clear and re-warm all caches"
	@echo "  make octane     - Reload Octane workers (zero-downtime)"
	@echo ""

# ── Build ────────────────────────────────────────────────────
build:
	@echo "🔨 Building Docker image..."
	cp .env.docker .env
	docker compose build --no-cache

# ── Start ────────────────────────────────────────────────────
up:
	@echo "🚀 Starting Ventuz Store containers..."
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

# ── Deploy (build + up) ──────────────────────────────────────
deploy:
	@echo "🚢 Deploying Ventuz Store..."
	make build
	make up
	@echo "🎉 Deployment complete!"
