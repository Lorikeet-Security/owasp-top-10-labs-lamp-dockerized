# OWASP Top 10 Labs - LAMP Dockerized

<p align="center">
  <img src="https://s3.parrot-ctfs.com/687f184745abe6.68974060.png" alt="Parrot CTFs Logo" width="200"/>
</p>

[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)](https://docker.com)
[![License](https://img.shields.io/badge/License-Proprietary-red)](LICENSE)
[![Labs](https://img.shields.io/badge/Labs-10-green)](https://parrot-ctfs.com)

> A collection of 10 vulnerable LAMP stack lab environments for practicing web application security testing. Each lab is containerized with Docker for easy deployment and isolation.

---

## Labs Included

| Lab | Preview | Description | Difficulty |
|-----|---------|-------------|:----------:|
| **Abby's Lab** | <img src="https://s3.parrot-ctfs.com/hacking/machines/abby_lab_capture_the_flag.png" width="80"/> | Break through Abby's IPS to breach her system. | Hard |
| **Backdrop** | <img src="https://s3.parrot-ctfs.com/669af11cc9b6c8.16540122.png" width="80"/> | Dive into the Backdrop CMS challenge! Unravel hidden secrets and master this unique CMS. | Easy |
| **Blogger** | <img src="https://s3.parrot-ctfs.com/hacking/machines/blogger_hacking_labs_capture_the_flag.png" width="80"/> | Perform a penetration test against this blog. | Medium |
| **Cloud Admin** | <img src="https://s3.parrot-ctfs.com/66ae0cca784ba1.74791678.png" width="80"/> | Dive into cloud security and uncover vulnerabilities in cloud and server environments. | Medium |
| **Marketer** | <img src="https://s3.parrot-ctfs.com/6672046276f907.04566630.png" width="80"/> | Attack this marketing provider using your file upload and cryptography skills. | Medium |
| **Mr Robot V2** | <img src="https://s3.parrot-ctfs.com/hacking/machines/mr_robot_hacking_capture_the_flag.png" width="80"/> | FSociety's task: Hack Ecorp and their employees. | Medium |
| **Pet Shop** | <img src="https://s3.parrot-ctfs.com/hacking/machines/pet_shop_hacking_labs_capture_the_flags.png" width="80"/> | Find your way into this old, unfinished website. | Easy |
| **Shuttle Booking** | <img src="https://s3.parrot-ctfs.com/6719cd957e7d64.07939587.png" width="80"/> | Unleash the full power of XSS. | Medium |
| **Splinter** | <img src="https://s3.parrot-ctfs.com/66eda74b8d0479.56629970.png" width="80"/> | Exploit SSTI vulnerabilities at Unemployable INC. | Easy |
| **Texas Ranger** | <img src="https://s3.parrot-ctfs.com/hacking/machines/walker_texas_ranger_beginner_ctfs.png" width="80"/> | Yee haw! Show the Texas Rangers who's boss. | Easy |


---

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

```
Note: Shuttle Booking may require you to set an /etc/hosts config due to a DNS redirect on the lab machine to shuttlebooking.pctfs. 
```


## Disclaimer

These labs contain intentionally vulnerable applications for educational purposes only. Do not deploy on production systems or publicly accessible networks.

## License

**Confidential & Proprietary - All Rights Reserved**

This repository contains proprietary software owned by Parrot Pentest LLC (dba Parrot CTFs). All rights reserved. Any unauthorized use, reproduction, modification, or distribution is strictly forbidden without express written consent.

Licensed usage is available through formal Statement of Work (SOW) agreements only.

---
<br>
<p align="center">
  <img src="https://s3.parrot-ctfs.com/687f184745abe6.68974060.png" alt="Parrot CTFs" width="100"/>
  <br>
  © Parrot CTFs 2026 | <a href="https://parrot-ctfs.com">parrot-ctfs.com</a>
</p>
