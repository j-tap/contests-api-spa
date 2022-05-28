job "new_admin-front-prod" {
  datacenters = [
    "ya1"
  ]
  type = "service"
  group "new_admin-front-prod" {
    count = 1

    constraint {
      attribute = "${meta.node}"
      operator = "="
      value = "new-admin"
    }
    update {
        canary           = 1
        // health_check     = "checks"
        min_healthy_time = "20s"
        // healthy_deadline = "2m"
        // progress_deadline = "3m"
        auto_revert      = false
        auto_promote     = true
    }

    task "new_admin-front-prod" {
      driver = "docker"
      config {
        image = "cr.yandex/crp33bi1nl24avunj74l/frontend:[[.tag]]"
        volumes = [
          "local/adminpanel_nginx/nginx.conf:/etc/nginx/nginx.conf",
          "local/adminpanel_nginx/default.conf:/etc/nginx/conf.d/default.conf",
          "local/get_backend.js:/var/www/html/get_backend.js",
        ]
        port_map {
          http = 8081
        }

        force_pull = true

      }
      env {
        API_PATH = "/api/v1"
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
                    error_page  405     =200 $uri;
                    location / {
                        root /var/www/html;
                    }
                    location /get_backend.js {
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
        name = "newadmin-front-prod"
        port = "http"
        tags = [
          "newadmin_traefik.tags=service",
          "newadmin_traefik.enable=true",
          "newadmin_traefik.http.routers.adminbackfront-prod.rule=Method(`GET`, `POST`, `PUT`, `DELETE`, `PATCH`, `OPTIONS`)",
          "newadmin_traefik.http.routers.adminbackfront-prod.entrypoints=front, http",
          "newadmin_traefik.http.routers.adminbacknfront-prod.tls=false",
        ]
      }
      resources {
        cpu    = 100 # MHz
        memory = 301 # MB
        network {
          mbits = 1
          port "http" {}
        }
      }
    }
  }
}
