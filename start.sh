#!/bin/bash
echo "=== Running migrations ==="
echo "yes" | php artisan migrate --force
echo "=== Storage link ==="
php artisan storage:link 2>/dev/null || true
echo "=== Config cache ==="
php artisan config:cache
echo "=== Starting server ==="
php artisan serve --host=0.0.0.0 --port=$PORT