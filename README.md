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
| ticket | — |

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

**Confidential & Proprietary - All Rights Reserved**

This repository contains proprietary software owned by Parrot Pentest LLC (dba Parrot CTFs). All rights reserved. Any unauthorized use, reproduction, modification, or distribution is strictly forbidden without express written consent.

Licensed usage is available through formal Statement of Work (SOW) agreements only.

---

© Parrot CTFs 2026 | [parrot-ctfs.com](https://parrot-ctfs.com)

