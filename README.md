# OWASP Top 10 Labs - LAMP Dockerized

<p align="center">
  <img src="https://s3.parrot-ctfs.com/687f184745abe6.68974060.png" alt="Parrot CTFs Logo" width="200"/>
</p>

[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)](https://docker.com)
[![License](https://img.shields.io/badge/License-MIT-00e5a0)](LICENSE)
[![Labs](https://img.shields.io/badge/Labs-10-green)](https://parrot-ctfs.com)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-e8526a)](CONTRIBUTING.md)

> A collection of 10 vulnerable LAMP stack lab environments for practicing web application security testing. Each lab is containerized with Docker for easy deployment and isolation.

**These labs are open source and free to use.** No account, no paywall, no lab time credits. Clone the repo, start a container, and get to work.

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

New to this? Start with **Texas Ranger**, **Pet Shop**, or **Backdrop**, then work up to **Abby's Lab**.

---

## Requirements

- Docker
- Docker Compose

## Quick Start

```bash
git clone https://github.com/Lorikeet-Security/owasp-top-10-labs-lamp-dockerized.git
cd owasp-top-10-labs-lamp-dockerized

# Start a specific lab
cd <lab-name>
docker-compose up -d
```

Tear a lab down when you are finished with it:

```bash
docker-compose down -v
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

---

## Safe Use

These labs contain **intentionally vulnerable applications**. They are built to be broken.

- Run them on an isolated host or a local VM, never on a production system
- Do not expose them to the public internet or to any network you do not control
- Bring them down when you are done rather than leaving them running
- Anything you learn here applies only to systems you own or have written authorization to test

## Contributing

Pull requests are welcome. Useful contributions include:

- Fixes to broken builds, images, or dependencies
- New labs that follow the existing structure
- Walkthroughs and writeups
- Improvements to setup, documentation, or container hygiene

Please do not commit real credentials, customer data, or anything that came out of a live engagement.

## Community

Hosted versions of these labs, leaderboards, and live CTF events run at [parrot-ctfs.com](https://parrot-ctfs.com). If your team wants a private CTF or a scored event, get in touch through [lorikeetsecurity.com](https://lorikeetsecurity.com).

## License

Released under the [MIT License](LICENSE).

You are free to use, modify, and redistribute these labs, including commercially, for training, coursework, internal enablement, or your own CTF events. Attribution is appreciated but the only requirement is keeping the license and copyright notice intact.

---
<br>
<p align="center">
  <img src="https://s3.parrot-ctfs.com/687f184745abe6.68974060.png" alt="Parrot CTFs" width="100"/>
  <br>
  © 2026 Lorikeet Corp | Parrot CTFs is a brand of Lorikeet Security
  <br>
  <a href="https://parrot-ctfs.com">parrot-ctfs.com</a> | <a href="https://lorikeetsecurity.com">lorikeetsecurity.com</a>
</p>
