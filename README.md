<p align="center">
  <a href="https://lorikeetsecurity.com">
    <img src="https://lorikeetsecurity.com/images/lorikeet-logo-banner.png" alt="Lorikeet Security Logo" width="280"/>
  </a>
</p>

<h1 align="center">
  OWASP Top 10 Labs — LAMP Dockerized
</h1>

<p align="center">
  <b>Maintained by <a href="https://lorikeetsecurity.com">Lorikeet Security</a></b>
</p>

<p align="center">
  <a href="https://docker.com"><img src="https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white" alt="Docker Ready"/></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-00e5a0" alt="License"/></a>
  <a href="https://lorikeetsecurity.com"><img src="https://img.shields.io/badge/Labs-10-green" alt="10 Labs"/></a>
  <a href="CONTRIBUTING.md"><img src="https://img.shields.io/badge/PRs-welcome-e8526a" alt="PRs Welcome"/></a>
</p>

> A collection of 10 intentionally vulnerable LAMP stack lab environments for practicing web application security testing and offensive engineering. Each lab is containerized with Docker for rapid local deployment and isolation.

**These labs are 100% open source and free to use.** No account, no paywall, and no lab time credits required. Clone the repository, spin up a container, and get to work.

---

## Labs Included

| Lab | Primary Focus | Description | Difficulty | 
| :--- | :--- | :--- | :---: | 
| **Abby's Lab** | IPS Bypass & Exploitation | Break through Abby's intrusion prevention rules to breach the underlying system. | 🔴 Hard | 
| **Backdrop** | CMS Vulnerability Chaining | Dive into the Backdrop CMS challenge, unravel hidden secrets, and compromise the instance. | 🟢 Easy | 
| **Blogger** | Web App Recon & Auth Bypass | Perform an end-to-end penetration test against a vulnerable blogging platform. | 🟡 Medium | 
| **Cloud Admin** | Cloud & Server Misconfigurations | Uncover misconfigurations and privilege escalation paths in cloud and server environments. | 🟡 Medium | 
| **Marketer** | Unrestricted File Upload & Crypto | Attack a marketing portal using malicious file uploads and cryptographic weaknesses. | 🟡 Medium | 
| **Mr Robot V2** | Multi-Stage Web Compromise | FSociety's task: Enumerate and exploit Ecorp and its employee portal. | 🟡 Medium | 
| **Pet Shop** | Legacy Web Flaws & Injection | Find your way into an old, unfinished e-commerce website. | 🟢 Easy | 
| **Shuttle Booking** | Cross-Site Scripting (XSS) | Unleash the full power of client-side and stored XSS payloads. | 🟡 Medium | 
| **Splinter** | Server-Side Template Injection (SSTI) | Identify and exploit SSTI vulnerabilities at Unemployable INC. | 🟢 Easy | 
| **Texas Ranger** | Beginner Web Enumeration | Yee haw! A foundational web exploitation lab to test your core recon skills. | 🟢 Easy | 

New to web pentesting? Start with **Texas Ranger**, **Pet Shop**, or **Backdrop**, then work your way up to **Abby's Lab**.

---

## Requirements

* Docker
* Docker Compose

## Quick Start

```
git clone https://github.com/Lorikeet-Security/owasp-top-10-labs-lamp-dockerized.git
cd owasp-top-10-labs-lamp-dockerized

# Start a specific lab
cd <lab-name>
docker compose up -d
```

Tear a lab down when you are finished:

```
docker compose down -v
```

## Lab Structure

```
lab-name/
├── docker-compose.yml
├── Dockerfile
└── src/
    └── (application source code)
```

> **Note:** `Shuttle Booking` may require an `/etc/hosts` entry mapping the container IP to `shuttlebooking.pctfs` due to an internal application redirect.

---

## Safe Use

These labs contain **intentionally vulnerable applications**. They are built to be broken.

* Run them on an isolated host or local VM—never on a production system.
* Do not expose them to the public internet or any untrusted network.
* Tear containers down (`docker compose down -v`) when finished rather than leaving them running.
* Apply these techniques only to systems you own or have explicit written authorization to test.

## Contributing

Pull requests are welcome. Useful contributions include:

* Fixes to broken builds, base images, or dependencies
* New labs that follow the existing container structure
* Walkthroughs, remediation guides, and writeups
* Improvements to setup, documentation, or container hygiene

Please do not commit real credentials, customer data, or artifacts from live engagements.

## About Lorikeet Security

Maintained by [Lorikeet Security](https://lorikeetsecurity.com) — AI-native, human-verified Penetration Testing as a Service (PTaaS) and offensive security engineering. Looking for continuous autonomous testing with **Lory**, developer security tooling, or a private training/CTF event for your engineering team? Reach out at [lorikeetsecurity.com](https://lorikeetsecurity.com).

## License

Released under the [MIT License](LICENSE).

You are free to use, modify, and redistribute these labs—including commercially—for training, coursework, internal enablement, or benchmarking AI security agents. Attribution is appreciated, and the only requirement is keeping the license and copyright notice intact.

---

<p align="center">
  <a href="https://lorikeetsecurity.com">
    <img src="https://lorikeetsecurity.com/images/lorikeet-logo-banner.png" alt="Lorikeet Security" width="140"/>
  </a>
  <br>
  © 2026 Lorikeet Corp (<a href="https://lorikeetsecurity.com">lorikeetsecurity.com</a>)
</p>
