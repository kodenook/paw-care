<div align="center">

# PawCare

![License](https://img.shields.io/badge/license-CC%20BY--NC--SA-blue.svg)
![Node.js Version](https://img.shields.io/badge/Node.js-%5E20.5-blue)
![PHP Version](https://img.shields.io/badge/PHP-%5E8.1-blue)
![Laravel Version](https://img.shields.io/badge/Laravel-%5E10.0-blue)
![Contributions Not Welcome](https://img.shields.io/badge/contributions-not%20welcome-red)
</div>



PawCare is a comprehensive and efficient solution specifically designed to meet the administrative and clinical needs of modern veterinary practices. With an intuitive interface and powerful features.

## Table of Contents

- [PawCare](#pawcare)
  - [Table of Contents](#table-of-contents)
  - [Authors](#authors)
  - [Requirements](#requirements)
  - [Project Tracking](#project-tracking)
  - [Run Locally](#run-locally)
  - [Features](#features)
  - [Contribution](#contribution)
  - [License](#license)


## Authors

- [@kodenook](https://www.github.com/kodenook)

## Requirements

- PHP ^8.1
- MySQL ^8
- Composer (for php dependency management)
- Node (for javascript dependency management)
- Git (for cloning the repository)

## Project Tracking

Welcome to the PawCare project. You can track the project's progress and access different views as follows:

1. **Task List**: Explore all project tasks in the [Task List view](https://github.com/users/kodenook/projects/17/views/1) for a comprehensive overview of our work.

2. **Kanban Board**: Utilize the [Kanban Board](https://github.com/users/kodenook/projects/17/views/2) to visualize task workflows, manage work in progress, and monitor progress during the project's iterations.

3. **Gantt Chart**: Get a complete timeline perspective of the project in the [Gantt Chart view](https://github.com/users/kodenook/projects/17/views/3) for planning and tracking key dates and dependencies.



## Run Locally

1. Clone this repository:
   - HTTPS: `git clone https://github.com/kodenook/pawcare.git`
   - SSH: `git clone git@github.com:kodenook/pawcare.git`
   - GITHUB CLI: `gh repo clone kodenook/pawcare`
2. Navigate to the project folder: `cd pawcare`
3. Copy the `.env.example` file to `.env` and configure the environment variables, such as the database connection.
4. Install PHP dependencies: `composer install`
5. Install javascript dependencies: `npm install`
6. Generate the application key: `php artisan key:generate`
7. Run database migrations: `php artisan migrate`
8. Compile assets:
   - For development: `npm run dev`
   - For production: `npm run build`
9.  Start the development server: `php artisan serve`

## Features

- Patient Management: Record detailed information about each patient, including their medical history, allergies, and past treatments.
- Appointment Scheduling: Schedule and manage appointments for your patients with ease.
- Medical History Access: Quickly access patient medical histories for accurate diagnosis.
- Reports and Statistics: Gain valuable insights into your clinic's performance.


## Contribution

Please note that we are not currently accepting contributions to this project. We appreciate your interest, but this is a personal or closed project, and we do not intend to expand the contributor base at this time.

Thank you for your understanding.

## License

This project is distributed under the terms of the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (CC BY-NC-ND 4.0). See the [License](link-to-your-license-file) file for more details.
