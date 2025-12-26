# OWASP Top 10 Labs - LAMP Dockerized

A collection of 10 vulnerable LAMP stack lab environments for practicing web application security testing. Each lab is containerized with Docker for easy deployment and isolation.

## Labs Included

| Lab | Description |
|-----|-------------|
| abbys-lab | — |
| blogger | — |
| dentist-office | — |
| file-ception | — |
| mr-robot | — |
| pet-shop | — |
| shuttle-booking | — |
| splinter | — |
| texas-ranger | — |

## Requirements

- Docker
- Docker Compose

## Quick Start

```bash
# Start a specific lab
cd <lab-name>
docker-compose up -d
```

## Lab Structure

```
lab-name/
├── docker-compose.yml
├── Dockerfile
└── src/
    └── (application source code)
```

## Disclaimer

These labs contain intentionally vulnerable applications for educational purposes only. Do not deploy on production systems or publicly accessible networks.

## License

**Proprietary - All Rights Reserved**

This repository and its contents are the intellectual property of Parrot Pentest LLC (dba Parrot CTFs). Unauthorized copying, distribution, or use of this software is strictly prohibited.

---

© Parrot CTFs | [parrot-ctfs.com](https://parrot-ctfs.com)

