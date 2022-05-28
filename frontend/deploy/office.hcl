job "contests-api-frontend" {
  datacenters = [
    "office"
  ]
  type = "service"
  group "contests-api-frontend" {
    count = 1
    task "contests-api-frontend" {
      driver = "docker"
      config {
        image = "cr.yandex/crp33bi1nl24avunj74l/contests-api-frontend:[[.tag]]"
        volumes = [
          "local/adminpanel_nginx/nginx.conf:/etc/nginx/nginx.conf",
          "local/adminpanel_nginx/default.conf:/etc/nginx/conf.d/default.conf",
          "local/get_backend.js:/var/www/html/get_backend.js",
        ]
        port_map {
          http = 8081
        }

        force_pull = true
        // network_mode = "host"
      }

      env {
        TIMEDEPLOY = "[[ timeNow ]]"
        API_PATH = "/api/v1"
      } # env
      template {
        data = <<EOH
                user  nginx;
                worker_processes  1;
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
                                      '"$http_user_agent" "$http_x_forwarded_for"';
                    # access_log  /var/log/nginx/access.log  main;
                    access_log      off;
                    sendfile        on;
                    #tcp_nopush     on;
                    keepalive_timeout  65;
                    gzip  on;
                    add_header X-Frame-Options SAMEORIGIN;
                    add_header X-Content-Type-Options nosniff;
                    add_header X-XSS-Protection "1; mode=block";
                    include /etc/nginx/conf.d/*.conf;
                }
                EOH
        destination = "local/adminpanel_nginx/nginx.conf"
      }
      template {
        data = <<EOH
        domain
        EOH
        destination = "local/get_backend.js"
      }
      template {
        data = <<EOH
                map $host $backend_domain {
                  "platform.adscompass.ru"   "https://backden1.com";
                  "admin.adc.realpush.net"   "https://backden2.com";
                  "dev.adscompass.ru"   "https://backden3.com";
                  default    "https://backden_default.com";
                }
                server {
                    listen 8081;
                    server_name _;
                    root /var/www/html;
                    index index.html;
                    location / {
                        root /var/www/html;
                    }
                    location = /get_backend.js {
                      set $domain $backend_domain;
                      sub_filter_last_modified on;
                      sub_filter "domain" $domain;
                      sub_filter_types "*";

                      try_files $uri $uri/;
                    }
                    location ~ ^/(?!(/assets|/_nuxt))(\w+) {
                        try_files $uri /index.html;
                    }
                }
                EOH
        destination = "local/adminpanel_nginx/default.conf"
      }
      service {
        name = "contests-api-frontend"
        port = "http"
        tags = [
          "traefik.enable=true",
          "traefik.tags=service",
          "traefik.http.routers.contestsfrontend.rule=Host(`devcontests.adscompass.ru`)",
          "traefik.http.routers.contestsfrontend.middlewares=http-to-https@file",
          "traefik.http.routers.contestsfrontend.tls=true",
          "traefik.http.routers.contestsfrontend.tls.certresolver=default",
        ]
      }
      resources {
        network {
          mbits = 2
          port "http" {
          }
        }
      }
    }
  }
}
