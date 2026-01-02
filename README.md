# OWASP Top 10 Labs - LAMP Dockerized

A collection of 10 vulnerable LAMP stack lab environments for practicing web application security testing. Each lab is containerized with Docker for easy deployment and isolation.

## Labs Included
| Lab | Image | Description | Root Flag | User Flag | Difficulty |
|-----|-------|-------------|-----------|-----------|------------|
| Abby's Lab | ![Abby's Lab](https://s3.parrot-ctfs.com/hacking/machines/abby_lab_capture_the_flag.png) | No way! I'm getting hacked! Break through Abby's IPS in order to breach her system. | `aHR0cHM6Ly93d3cueW91dHViZS5jb20vd2F0Y2g/dj1tc1g0b0FYcHZVRQ==` | `Ik5vIHdheSEgSSdtIGdldHRpbmcgaGFja2VkISIgLSBBYmJ5` | Hard |
| Blogger | ![Blogger](https://s3.parrot-ctfs.com/hacking/machines/blogger_hacking_labs_capture_the_flag.png) | A company has hired you to perform a penetration test against this blog. Can you bring back good results? | `01cd7b3d09f84463806ac226099d725745c0b6d1c0fb6da068e484da2a5c2167` | `07c68b84d3f0e7475cbe1b760683f4a9c310592a7154d51e3e740a004a69478a` | Medium |
| Dentist Office | ![Dentist Office](https://s3.parrot-ctfs.com/hacking/machines/dentist_office_hacking_beginner_ctfs.png) | Sharpen up your skills like this under the bridge dentist sharpens teeth. Show us can you hack this website? | `318fa5ec4d9403186175de04abbdcd96d7798a583d160d0b0c6765d2a71410fa` | `b78e381e360da323290665f09339b16f567bb42a4904895221c00fcd147f3d7b` | Easy |
| File Ception | ![File Ception](https://s3.parrot-ctfs.com/6778ddb73b4f29.35580835.png) | Welcome to the ultimate cybersecurity carnival, where Local File Inclusion meets Remote Code Execution! | `PCTF{78ff1b969bded694fc1990f7d6d9d0b3}` | `PCTF{4d0380e5146ae94dd0b295c15b05bd05}` | Easy |
| Mr Robot V2 | ![Mr Robot](https://s3.parrot-ctfs.com/hacking/machines/mr_robot_hacking_capture_the_flag.png) | FSociety has assigned you a task: Hack Ecorp and Their Employees. Can you do it? | `f7078b7bde35e8cf24d622aeb3c3081bc0a73f2217d1ebd550c65e36f6c22362` | `01ff0430f950192ac9ff72c348b6ebeba8b62c5a18fed92a04eff05708284f2d` | Medium |
| Pet Shop | ![Pet Shop](https://s3.parrot-ctfs.com/hacking/machines/pet_shop_hacking_labs_capture_the_flags.png) | This old school pet shop owner has an old website. It's not even set up yet! Can you find your way in? | `25eaff4f14c33c598c8c2397024f6d73263618bda147c15e7c16c3806dbd848b` | `c5f14388a245cab785def0524cf8566e505b73401441fdf6a3970493189c74a5` | Easy |
| Shuttle Booking | ![Shuttle Booking](https://s3.parrot-ctfs.com/6719cd957e7d64.07939587.png) | Welcome to the Shuttle Booking system, where only the bravest hackers thrive. Unleash the full power of XSS! | `401d4db814c5e73c10fc893e00c75c94c009bf72ab6e8209d2f03c12deefb919` | `197a919c1062a25a7fec257e839142bd6a49e6ade7a51790c79ee019a78b42f0` | Medium |
| Splinter | ![Splinter](https://s3.parrot-ctfs.com/66eda74b8d0479.56629970.png) | Unemployable INC needs your penetration testing skills. Exploit SSTI vulnerabilities and infiltrate their systems. | `9672a0e42813d0de7de380cc99fdd900e31e39280e0445b2a3e28ffb864ef27d` | `4833141889debce0c37dfb185a6fd7b5e9467a6e86eaf01e17e416e1e2530e6f` | Easy |
| Texas Ranger | ![Texas Ranger](https://s3.parrot-ctfs.com/hacking/machines/walker_texas_ranger_beginner_ctfs.png) | Yee haw! Can you show the Texas Rangers who is boss? | `f7078b7bde35e8cf24d622aeb3c3082bc0a73f2217d1ebd550c65e36f6c22362` | `01df0430f950192ac9ff72c348b6ebeba8b62c5a18fed92a04eff05708284f2d` | Easy |
| Ticket | ![Ticket](https://s3.parrot-ctfs.com/hacking/machines/ticketing_system_beginner_capture_hacking_labs.png) | Ticketing Systems are common in IT operations. Find the flaw in this application. | `8f43b3d7ec0fd513d4e34f8e1068fab9cfaf79fadb4641f3f812b99976f76edf` | `0f9722115e15e8191e3b82e26b02d2184a1bd8ec7cdd99646185ec9ab3d74e31` | Easy |

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

