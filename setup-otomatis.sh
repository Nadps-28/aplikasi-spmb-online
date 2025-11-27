#!/bin/bash

# Setup Notifikasi Otomatis SPMB

echo "🚀 Setting up automatic notifications..."

# 1. Setup Laravel Scheduler (Cron Job)
echo "📅 Setting up cron job..."
(crontab -l 2>/dev/null; echo "* * * * * cd /Users/labsa.smkbn666.pk17/spmb-app && php artisan schedule:run >> /dev/null 2>&1") | crontab -

# 2. Install Supervisor (untuk queue worker)
echo "⚡ Installing supervisor..."
brew install supervisor 2>/dev/null || echo "Supervisor already installed or install manually"

# 3. Create supervisor config
echo "📝 Creating supervisor config..."
sudo tee /usr/local/etc/supervisor.d/spmb-queue.conf > /dev/null <<EOF
[program:spmb-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /Users/labsa.smkbn666.pk17/spmb-app/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=$(whoami)
numprocs=1
redirect_stderr=true
stdout_logfile=/Users/labsa.smkbn666.pk17/spmb-app/storage/logs/queue.log
stopwaitsecs=3600
EOF

# 4. Start supervisor
echo "🔄 Starting supervisor..."
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start spmb-queue:*

echo "✅ Setup complete! Notifications will now run automatically."
echo ""
echo "📋 Status check commands:"
echo "  - Check cron: crontab -l"
echo "  - Check queue: sudo supervisorctl status spmb-queue:*"
echo "  - View logs: tail -f storage/logs/queue.log"