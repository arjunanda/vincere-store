#!/bin/bash
# Vincere Store - Connection Diagnostic Script
# Run this on the VPS server as root

echo "=========================================="
echo "1. PostgreSQL Listening Address"
echo "=========================================="
sudo -u postgres psql -c "SHOW listen_addresses;" 2>/dev/null || ss -tlnp | grep 5432

echo ""
echo "=========================================="
echo "2. Docker Network Gateway IP"
echo "=========================================="
docker network inspect ventuz-store_ventuz_network 2>/dev/null | grep -E '"Gateway"|"Subnet"' \
  || docker network ls

echo ""
echo "=========================================="
echo "3. Resolve host.docker.internal inside container"
echo "=========================================="
docker exec ventuz_app getent hosts host.docker.internal 2>/dev/null \
  || echo "Container not running or name different"

echo ""
echo "=========================================="
echo "4. Test pgsql connection from inside container"
echo "=========================================="
docker exec ventuz_app php -r "
try {
    \$pdo = new PDO('pgsql:host=host.docker.internal;port=5432;dbname=ventuz_store', 'junastack', 'Junedi12345**##');
    echo 'SUCCESS: Connected to PostgreSQL!' . PHP_EOL;
} catch (Exception \$e) {
    echo 'FAILED: ' . \$e->getMessage() . PHP_EOL;
}
" 2>/dev/null || echo "Container not running"

echo ""
echo "=========================================="
echo "5. pg_hba.conf - check allowed hosts"
echo "=========================================="
sudo find / -name pg_hba.conf 2>/dev/null | head -1 | xargs sudo cat 2>/dev/null \
  || echo "Could not read pg_hba.conf"
