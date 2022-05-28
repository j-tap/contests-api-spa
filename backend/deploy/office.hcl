job "contests-api-backend" {
    datacenters = [
        "office"
    ]
    type = "service"
    group "contests-api-backend" {
        count = 1


        task "contests-api-backend-php" {
            driver = "docker"
            config {
                image = "cr.yandex/crp33bi1nl24avunj74l/contests-api-backend-php:[[.tag]]"
                force_pull = true
                volumes = [
                    "local/docker.conf:/usr/local/etc/php-fpm.d/zzz-docker.conf",
                    "/opt/telegram_contest:/var/www/html/storage/madeline"
                ]
                port_map {
                    httpadmin = 9000
                }
                entrypoint = [
                    "sh","-c",
                    "php artisan migrate --force && php-fpm",
                ]
                logging {
                    driver = "journald"
                    config {
                        tag = "new_admin"
                    }
                }
            }
            env {

                DB_PASSWORD = "secret",
                DB_HOST = "192.168.1.200",
                DB_PORT = "5433",
                DB_USERNAME = "postgres",
                DB_DATABASE = "contests-api",
                DB_CONNECTION = "pgsql",

                APP_ENV = "production",
                BROADCAST_DRIVER = "log",
                USER_ROOT_PASSWORD = "secret",
                APP_DEBUG = "0",
                VERSION = "0.0.1",
                SESSION_DRIVER = "file",
                APP_NAME = "contests-api",
                QUEUE_CONNECTION = "sync",
                LOG_CHANNEL = "stack",
                APP_KEY = "base64:MujYlyGDkcwVAd22rKzCQlOTpHV3NUyhd2J1kktOeto=",
                APP_URL = "http://devcontestsapi.adscompass.ru",
                CLIENT_DOMAIN = "devcontests.adscompass.ru",
                DEFAULT_NETWORK_NAME = "contests-api",

                ADMIN_EMAIL="super@admin.com"
                ADMIN_PASSWORD="i9Gh6D4#20dfM)"

                RECAPTCHA_SITE_KEY="6LfBxAgcAAAAAHb0cot_cDx65SAOyatw9IAaIY83"
                RECAPTCHA_SECRET_KEY="6LfBxAgcAAAAAH9F_QM07HgtUly-4UT8q9NEPUKZ"

                TIMEDEPLOY = "[[ timeNow ]]"


            }

            template {
                data = <<EOH

{{with secret "kv/contests"}}
TELEGRAM_PHONE={{ .Data.TELEGRAM_PHONE }}
TELEGRAM_API_ID={{ .Data.TELEGRAM_API_ID }}
TELEGRAM_API_HASH={{ .Data.TELEGRAM_API_HASH }}
{{end}}

                EOH
                destination = "secrets/file.env"
                env = true
            }
            template {
                data = <<EOH
[global]
error_log = /proc/self/fd/2
log_limit = 1024
[www]
listen = {{ env "NOMAD_ALLOC_DIR" }}/php-fpm.sock
listen.mode = 0666
access.log = /dev/null
clear_env = no
catch_workers_output = yes
decorate_workers_output = no
pm = dynamic
pm.max_children = 20
pm.start_servers = 10
pm.min_spare_servers = 2
pm.max_spare_servers = 15
pm.max_requests = 3000
php_admin_value[memory_limit] = 1024M

                EOH
                destination = "local/docker.conf"
            }

            resources {
                network {
                    mbits = 10
                    port "httpadmin" {}
                }
            }
        }

        task "contests-api-backend-prod" {
            driver = "docker"
            config {
                image = "nginx:latest"
                volumes = [
                    "local/newadminnginx/nginx.conf:/etc/nginx/nginx.conf",
                    "local/newadminnginx/default.conf:/etc/nginx/conf.d/default.conf",
                ]
                port_map {
                    http = 8082
                }
                logging {
                    driver = "journald"
                    config {
                        tag = "new_admin-nginx"
                    }
                }

            } # docker config
            service {
                name = "contests-prod"
                port = "http"
                tags = [
                    "traefik.tags=service",
                    "traefik.enable=true",
                    "traefik.http.routers.contests-prod.rule=Host(`devcontestsapi.adscompass.ru`)",
                    "traefik.http.routers.contests-prod.middlewares=http-to-https@file",
                    "traefik.http.routers.contests-prod.tls=true",
                    "traefik.http.routers.contests-prod.tls.certresolver=default"
                ]
            }

            env {
                TIMEDEPLOY = "[[ timeNow ]]"

            } # env
            template {
                data = <<EOH
                user  nginx;
                worker_processes  2;
                error_log   /var/log/nginx/error.log;
                pid         /var/run/nginx.pid;
                events {
                    worker_connections  1024;
                }
                http {
                    client_max_body_size    5m;
                    include       /etc/nginx/mime.types;
                    default_type  application/octet-stream;
                    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                                      '$status $body_bytes_sent "$http_referer" '
                                      '"$http_user_agent" "$http_x_forwarded_for" ($request_time)';
                    access_log  /var/log/nginx/access.log  main;
                    # access_log      off;
                    sendfile        on;
                    #tcp_nopush     on;
                    keepalive_timeout  65;
                    #gzip  on;
                    add_header X-Frame-Options SAMEORIGIN;
                    add_header X-Content-Type-Options nosniff;
                    add_header X-XSS-Protection "1; mode=block";
                    include /etc/nginx/conf.d/*.conf;
                }
                EOH
                destination = "local/newadminnginx/nginx.conf"
            }
            template {
                data = <<EOH
                server {
                    listen 8082;
                    server_name _;
                    root /var/www/html/public;
                    index index.php;
                    location / {
                        try_files $uri $uri/ /index.php?$query_string;
                    }
                    location ~ \.php$ {
                        fastcgi_split_path_info ^(.+\.php)(/.+)$;
                        fastcgi_pass unix:{{ env "NOMAD_ALLOC_DIR" }}/php-fpm.sock;
                        fastcgi_index index.php;
                        include fastcgi_params;
                        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                        fastcgi_intercept_errors off;
                        fastcgi_buffer_size 10240k;
                        fastcgi_buffers 4 10240k;
                        fastcgi_connect_timeout 300;
                        fastcgi_send_timeout 300;
                        fastcgi_read_timeout 300;
                    }
                }
                EOH
                destination = "local/newadminnginx/default.conf"
            }
            resources {
                cpu    = 200 # MHz
                memory = 200 # MB
                network {
                    // mbits = 100
                    port "http" {}
                }
            } #resources
        }
    }
}
