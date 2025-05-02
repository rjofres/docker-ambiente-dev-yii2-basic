# 🛠️ Ambiente Docker Local para APIs Yii2 Basic con Soporte SSL

[![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=flat-square&logo=docker&logoColor=white)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/php-8.4-777BB4.svg?style=flat-square)](https://www.php.net/)
[![Nginx](https://img.shields.io/badge/nginx-1.20-009639.svg?style=flat-square)](https://nginx.org/)
[![MySQL](https://img.shields.io/badge/mysql-5.7-4479A1.svg?style=flat-square)](https://www.mysql.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](https://opensource.org/licenses/MIT)
![Estado: Activo](https://img.shields.io/badge/Estado-Activo-success)

## 🎯 Objetivo
Este proyecto proporciona un entorno de desarrollo local utilizando Docker para alojar APIs creadas en Yii2 Basic.  
La configuración incluye contenedores de Nginx, PHP-FPM 8.4 y MySQL 5.7, trabajando en una red privada con IPs locales fijas para simular entornos de producción de manera realista.

A partir de la versión **v1.1.0**, se incorpora soporte completo para **SSL local con certificados válidos** mediante dominios `.loc`.


## 🆕 Cambios en la versión 1.1.0

- ✅ Conversión de Yii2 Basic a estructura RESTful para APIs
- ✅ Soporte completo para HTTPS local con dominios `.loc`
- ✅ Generación automática de certificados autofirmados válidos en Chrome
- ✅ Reorganización del entorno Docker
- ✅ Validación de respuesta segura con `https://caminodeldev.loc`


## 📁 Estructura del Proyecto
```bash
docker-ambiente-yii2-api/
├── app/                      # Directorio donde se aloja el proyecto Yii2 Basic (API)
└── dev/                      # Configuraciones Docker para levantar el ambiente local
    ├── mysql/                # Directorio para la persistencia de datos de MySQL
    └── nginx/                # Directorio para archivos de configuración de Nginx
        └── nginx-api.conf    # Archivo de configuración principal de Nginx para la API
        ├── certs/            # Certificados SSL generados (key + crt)
    └── docker-compose.yml    # Archivo de configuración principal de Docker Compose.
```

## 📦 Servicios

| Servicio | Imagen           | IP interna | Puerto externo (Localhost) |
|----------|------------------|------------|----------------------------|
| Nginx    | nginx:1.25-alpine | 10.2.0.10  | 29410 (expuesto)           |
| PHP-FPM  | php:8.4-fpm       | 10.2.0.11  | 29420 (expuesto)           |
| MySQL    | mysql:8           | 10.2.0.12  | 29430 (expuesto)           |


## 🌐 Red Privada

Se configura una red `bridge` personalizada con el siguiente rango:

```
10.2.0.0/24
```

Cada contenedor tiene asignada una IP estática, permitiendo control total sobre su acceso y configuración.

## 🔐 Certificados SSL

El entorno genera un certificado autofirmado en `./dev/nginx/certs/` con soporte para navegadores como Chrome y Firefox.

## ⚙️ Variables de Entorno (MySQL)

- `MYSQL_ROOT_PASSWORD=root`
- `MYSQL_DATABASE=caminodeldev`
- `MYSQL_USER=msdev`
- `MYSQL_PASSWORD=devpass123`

## 📋 Pasos para usar

1. Clonar el repositorio:

```bash
git clone https://github.com/tuusuario/docker-ambiente-yii2-api.git
```

2. Entrar en el directorio:

```bash
cd docker-ambiente-yii2-api/dev
```

3. Crear la IP local (solo una vez):

a) macOS:
```bash
sudo ifconfig lo0 alias 10.0.0.2 up
```

b) Linux (Opción recomendada - `ip addr`):
```bash
sudo ip addr add 10.0.0.2/24 dev lo
```

c) Linux (Opción alternativa - `ifconfig`):
```bash
sudo ifconfig lo:0 10.0.0.2 netmask 255.255.255.255 up
```

4. Agregar el dominio local al `/etc/hosts`:

```bash
sudo vim /etc/hosts

# Agregar:
10.0.0.2 caminodeldev.loc
```

5. Construir y levantar los contenedores:

```
docker-compose -f docker-compose.yml up -d --build --remove-orphans
```

## 🔐 Generar certificados SSL locales
Para habilitar HTTPS en tu dominio local (por ejemplo: `caminodeldev.loc`), puedes usar [`mkcert`](https://github.com/FiloSottile/mkcert), una herramienta que crea certificados válidos para uso local, confiables por tu navegador.

### 📦 Instalación de mkcert

**En macOS** (usando Homebrew):
```bash
brew install mkcert
mkcert -install
mkcert --version
```

**En Linux** (Ubuntu/Debian):
```bash
sudo apt-get install libnss3-tools -y
wget https://github.com/FiloSottile/mkcert/releases/download/v1.4.3/mkcert-v1.4.3-linux-amd64
sudo mv mkcert-v1.4.3-linux-amd64 /usr/local/bin/mkcert
sudo chmod +x /usr/local/bin/mkcert
mkcert -install
mkcert --version
```

### 🧾 Generación del certificado

Desde el directorio `dev/`, ejecuta el siguiente comando para crear el certificado para tu dominio local:
```bash
mkcert -key-file ./nginx/certs/ssl.key -cert-file ./nginx/certs/ssl.crt caminodeldev.loc
```

Esto generará dos archivos:
- ./dev/nginx/certs/ssl.key → clave privada
- ./dev/nginx/certs/ssl.crt → certificado público

Estos se usarán en la configuración de Nginx para servir el sitio a través de HTTPS en entornos locales.


## 🔍 Acceso
API (HTTPS): https://caminodeldev.loc:29410

## 📹 Video del tutorial
Puedes seguir un paso a paso completo en el siguiente video:

[![Ver el tutorial en YouTube](https://img.youtube.com/vi/odcWVBGl2rg/hqdefault.jpg)](https://www.youtube.com/watch?v=odcWVBGl2rg)

> 🔗 [https://www.youtube.com/watch?v=odcWVBGl2rg](https://www.youtube.com/watch?v=odcWVBGl2rg)
