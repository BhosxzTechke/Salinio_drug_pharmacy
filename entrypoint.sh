#!/bin/bash
# Make Apache listen on Railway's dynamic PORT
echo "Listen ${PORT:-80}" > /etc/apache2/ports.conf

# Ensure document root is public/
sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Start Apache
apache2-foreground
