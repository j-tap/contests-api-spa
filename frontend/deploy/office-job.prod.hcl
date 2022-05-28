job "adminpanel-front-prod" {
  datacenters = [
    "ya1"
  ]
  type = "service"
  group "adminpanel-front-prod" {
    count = 1
    task "adminpanel-front-prod" {
      driver = "docker"
      config {
        image = "registry.gitlab.com/adscompass/frontend:${DRONE_TAG}"

        port_map {
          http = 2015
        }
        auth {
          username = "${DRONE_REPO_OWNER}"
          password = "${DRONE_REPO_NAME}"
        }
      }

      service {
        name = "adminpanel-front-prod"
        port = "http"
        tags = [
          "traefik.enable=true",
          "traefik.frontend.rule=Host:adsplatform.io,platform.adscompass.ru",
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
