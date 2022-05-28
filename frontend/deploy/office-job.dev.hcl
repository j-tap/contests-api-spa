job "adminpanel-front-dev" {
  datacenters = [
    "office"
  ]
  type = "service"
  group "adminpanel-front-dev" {
    count = 1
    task "adminpanel-front-dev" {
      driver = "docker"
      config {
        image = "registry.gitlab.com/adscompass/frontend:${DRONE_COMMIT_SHA}"

        port_map {
          http = 2015
        }
        auth {
          username = "${DRONE_REPO_OWNER}"
          password = "${DRONE_REPO_NAME}"
        }
      }

      service {
        name = "adminpanel-front-dev"
        port = "http"
        tags = [
          "traefik.enable=true",
          "traefik.frontend.rule=Host:admin.adscompass.ru",
        ]
      }

      resources {
        network {
          mbits = 1
          port "http" {}
        }
      }

    }
  }
}
