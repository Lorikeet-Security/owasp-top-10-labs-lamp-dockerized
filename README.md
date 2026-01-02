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

<details>
<summary><b>Flag Reference</b> (click to expand)</summary>

| Lab | Root Flag | User Flag |
|-----|-----------|-----------|
| Abby's Lab | `aHR0cHM6Ly93d3cueW91dHViZS5jb20vd2F0Y2g/dj1tc1g0b0FYcHZVRQ==` | `Ik5vIHdheSEgSSdtIGdldHRpbmcgaGFja2VkISIgLSBBYmJ5` |
| Backdrop | `58772425df8d8d2fd039bf9db9822c68ce9c51e7c1336e2738e1bf62ccb3c486` | `736773706ab14f439f63a118380d1390e415146c85b4b54c41e38616158d8d84` |
| Blogger | `01cd7b3d09f84463806ac226099d725745c0b6d1c0fb6da068e484da2a5c2167` | `07c68b84d3f0e7475cbe1b760683f4a9c310592a7154d51e3e740a004a69478a` |
| Cloud Admin | `6e7c0f4538ec50f4ad94b3d6951d89edf17fa0bb64a7c8271e18f8c8f26f7185s` | `c30933d39bab88fe51635d0b9b8af0fa012b3d01ac065fd5d85e248162c7f6ad` |
| Marketer | `13bf27433a57e512f8e3b9122a9065c1477ab508c28abb36e31c931a5e8dce0e` | `2ff1395bb6c74b6c1e00a789277edf69390ec4b5d760c9b6e38d0239d71fb92d` |
| Mr Robot V2 | `f7078b7bde35e8cf24d622aeb3c3081bc0a73f2217d1ebd550c65e36f6c22362` | `01ff0430f950192ac9ff72c348b6ebeba8b62c5a18fed92a04eff05708284f2d` |
| Pet Shop | `25eaff4f14c33c598c8c2397024f6d73263618bda147c15e7c16c3806dbd848b` | `c5f14388a245cab785def0524cf8566e505b73401441fdf6a3970493189c74a5` |
| Shuttle Booking | `401d4db814c5e73c10fc893e00c75c94c009bf72ab6e8209d2f03c12deefb919` | `197a919c1062a25a7fec257e839142bd6a49e6ade7a51790c79ee019a78b42f0` |
| Splinter | `9672a0e42813d0de7de380cc99fdd900e31e39280e0445b2a3e28ffb864ef27d` | `4833141889debce0c37dfb185a6fd7b5e9467a6e86eaf01e17e416e1e2530e6f` |
| Texas Ranger | `f7078b7bde35e8cf24d622aeb3c3082bc0a73f2217d1ebd550c65e36f6c22362` | `01df0430f950192ac9ff72c348b6ebeba8b62c5a18fed92a04eff05708284f2d` |

</details>

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