# SAMYAMA 2026 | RVITM Event Registration Portal

A responsive event registration website for **SAMYAMA**, RVITM's Kannada Rajyotsava cultural celebration. Built with HTML5, CSS3, JavaScript, jQuery and PHP. The visual identity uses the Karnataka flag colours: yellow and red.

## Features
- Student registration details: name, USN, department, year, email and phone.
- Individual or team participation selection.
- Conditional team name and team-size fields.
- Multiple activity selection.
- jQuery client-side validation and PHP server-side validation.
- CSRF token protection and escaped output.
- Successful registration confirmation with a generated reference ID.
- Print-friendly registration confirmation.
- Responsive desktop and mobile layout.

## Activities included
Kannada Singing, Solo Dance, Group Dance, Drama & Skits, Kannada Poetry & Recitation, Kannada Quiz, Debate & Speech, Rangoli Competition, Traditional Attire, and Group Cultural Performance.

**Important:** These are sample activity options included to make the assignment complete. Edit the `$activities` array near the top of `index.php` to match the final official SAMYAMA activity list.

## Run locally

1. Install PHP 8.2 or later.
2. Open a terminal in this project folder.
3. Run:

   ```bash
   php -S localhost:8000
   ```

4. Open http://localhost:8000 in your browser.

The Google Fonts and jQuery CDN assets require an internet connection.

## Deploy on Render

This project includes a Dockerfile.

1. Create a GitHub repository and upload the project files.
2. Sign in to [Render](https://render.com/).
3. Select **New + → Web Service** and connect your GitHub repository.
4. Select **Docker** as the runtime.
5. Create the service and wait for deployment.
6. Open the public `onrender.com` URL shown in your Render dashboard.

Check Render's current pricing and free-tier availability before deployment, as hosting plans can change.

## Project structure

```text
samyama_rvitm_event_registration/
├── index.php
├── Dockerfile
├── README.md
├── .dockerignore
└── assets/
    ├── css/
    │   └── style.css
    └── js/
        └── script.js
```

## Assignment explanation

**Objective:** To design and develop an online event registration application for SAMYAMA, the Kannada Rajyotsava cultural fest conducted at RVITM.

**Working:** HTML is used to structure the registration form. CSS creates the responsive interface using Karnataka's yellow and red flag colours. JavaScript and jQuery validate user inputs on the client side and show or hide team details depending on the selected participation type. PHP processes the submitted form, validates the information again on the server, generates a unique registration reference, and displays a formatted confirmation page with the participant's details and selected activities.

**Cloud hosting:** The application is packaged with Docker and can be hosted as a web service on Render after uploading the source code to GitHub.

**Storage note:** This assignment version displays the submitted registration details in the browser but does not permanently save them in a database or send email notifications. For a production event portal, connect a database and add appropriate access controls.
