# Drought Prediction System MVP - Local Deployment with XAMPP

## 1. Introduction

This document provides instructions for setting up and running the Drought Prediction System MVP (Minimum Viable Product) on a local machine using XAMPP. XAMPP is a free and open-source cross-platform web server solution stack package, consisting mainly of the Apache HTTP Server, MariaDB database (a MySQL fork), and interpreters for scripts written in the PHP and Perl programming languages.

## 2. Prerequisites

Before you begin, ensure you have the following software installed:

*   **XAMPP:** This package includes Apache (web server), MySQL/MariaDB (database), and PHP.
    *   Download from: [Apache Friends - XAMPP Official Download Page](https://www.apachefriends.org/download.html)
*   **A modern web browser:** (e.g., Google Chrome, Mozilla Firefox, Microsoft Edge).
*   **A code editor:** (Optional, for viewing or modifying the code, e.g., VS Code, Sublime Text, Notepad++).

## 3. Setup Steps

Follow these steps to get the application running locally:

### 3.1. Download and Install XAMPP

1.  Go to the [XAMPP downloads page](https://www.apachefriends.org/download.html) and download the appropriate version for your operating system (Windows, macOS, or Linux).
2.  Install XAMPP by following the on-screen instructions provided by the installer.
    *   **Windows:** Run the downloaded `.exe` installer. It's recommended to install XAMPP in a location like `C:\xampp` rather than `C:\Program Files` to avoid permission issues.
    *   **macOS:** Open the downloaded `.dmg` file and drag the XAMPP folder to your Applications folder.
    *   **Linux:** Download the `.run` file, make it executable (`chmod 755 xampp-linux-*-installer.run`), and run it (`sudo ./xampp-linux-*-installer.run`).
    *   For detailed installation guides, refer to the official XAMPP documentation available on their website.

### 3.2. Start Apache and MySQL

1.  Open the **XAMPP Control Panel**.
    *   **Windows:** Search for "XAMPP Control Panel" in the Start Menu or navigate to the XAMPP installation directory (e.g., `C:\xampp\xampp-control.exe`).
    *   **macOS:** Open the XAMPP application from your Applications folder. Go to the "Manage Servers" tab.
    *   **Linux:** XAMPP usually provides a command-line tool. Navigate to `/opt/lampp` and run `sudo ./manager-linux-x64.run` (or similar).
2.  In the XAMPP Control Panel, **Start** the **Apache** module.
3.  **Start** the **MySQL** module.

### 3.3. Place Project Files

1.  Copy the entire project directory (e.g., `drought-prediction-system/` if you named it that, containing `index.php`, `admin/`, `css/`, etc.) into the XAMPP `htdocs` directory.
    *   **Windows:** Typically `C:\xampp\htdocs\`
    *   **macOS:** Typically `/Applications/XAMPP/htdocs/`
    *   **Linux:** Typically `/opt/lampp/htdocs/`
    *   So, you should have a path like `C:\xampp\htdocs\drought-prediction-system\`.
    *   The project includes an `uploads/` directory at its root (e.g., `drought-prediction-system/uploads/`). This directory is used to store images uploaded by users through the admin panel, specifically in `uploads/images/news/` and `uploads/images/researchers/`. While the application will attempt to create these directories if they don't exist, it's good to be aware of them.

### 3.4. Set Directory Permissions (for Image Uploads)

*   The web server needs write permissions for the `uploads/`, `uploads/images/`, `uploads/images/news/`, and `uploads/images/researchers/` directories to allow image uploads.
*   The PHP scripts in the `admin` panel will attempt to create these directories if they don't exist during the first image upload for the respective sections.
*   If you encounter issues with image uploads (e.g., "Failed to move uploaded file" or "Failed to create directory" errors), please ensure these directories exist (or can be created by the web server) and that your web server process (e.g., the user Apache runs as) has the necessary write permissions for the `uploads/` directory and its subdirectories.
*   **For local development with XAMPP on Windows:** This is usually not an issue as file permissions are more relaxed.
*   **For XAMPP on Linux or macOS:** You might need to manually create the `uploads` directory within your project root (e.g., `htdocs/drought-prediction-system/uploads`) and then set appropriate permissions. For example:
    ```bash
    cd /path/to/your/project/htdocs/drought-prediction-system/
    mkdir -p uploads/images/news
    mkdir -p uploads/images/researchers
    sudo chmod -R 775 uploads 
    # You may also need to change the ownership to the Apache user/group
    # (e.g., sudo chown -R www-data:www-data uploads)
    # Or, for a less secure but often functional local setup:
    # sudo chmod -R 777 uploads
    ```
*   For production environments, consult your hosting provider's documentation for secure permission settings. Typically, directories should be `755` or `775` and files `644`. The web server user must be the owner or part of the group that owns the directories it needs to write to.

### 3.5. Database Setup

1.  **Access phpMyAdmin:** Open your web browser and navigate to `http://localhost/phpmyadmin`.
2.  **Create the Database:**
    *   In phpMyAdmin, click on "**New**" in the left sidebar or go to the "**Databases**" tab.
    *   Under "Create database", enter the database name: `drought_prediction_db` (this must match the `DB_NAME` in `config/db.php`).
    *   For collation, select `utf8mb4_general_ci` (or `utf8mb4_unicode_ci` as specified in `database.sql`).
    *   Click "**Create**".
3.  **Import Table Structure:**
    *   Select the newly created `drought_prediction_db` database in the left sidebar of phpMyAdmin.
    *   Click on the "**Import**" tab at the top.
    *   Under "File to import", click "**Choose File**" (or "Browse...").
    *   Navigate to your project directory (e.g., `C:\xampp\htdocs\drought-prediction-system\`) and select the `database.sql` file.
    *   Ensure the format is set to "SQL".
    *   Click "**Go**" (or "Import") at the bottom of the page. This will execute the SQL commands in the file, creating all necessary tables.

### 3.5. Create Admin User

An admin user is required to access the backend content management system.

1.  **Generate Hashed Password:**
    *   Open your web browser and navigate to the password hashing utility provided with the project: `http://localhost/your-project-directory/utils/hash_password.php` (e.g., `http://localhost/drought-prediction-system/utils/hash_password.php`).
    *   Enter a strong password for your admin user (e.g., `adminpass123`).
    *   Click "Generate Hash".
    *   Copy the generated hashed password string. It will look something like `$2y$10$...`.
2.  **Insert Admin User via phpMyAdmin:**
    *   Go back to phpMyAdmin: `http://localhost/phpmyadmin`.
    *   Select the `drought_prediction_db` database.
    *   Select the `users` table from the list of tables.
    *   Click on the "**Insert**" tab.
    *   In the form:
        *   `id`: You can leave this blank if it's auto-incrementing and NULL is allowed, or enter `1`.
        *   `username`: Enter your desired admin username (e.g., `admin`).
        *   `password`: Paste the **hashed password** you copied from `hash_password.php`.
    *   Click "**Go**".

### 3.6. Verify Configuration (`config/db.php`)

1.  Open the `config/db.php` file from your project directory in a text editor.
2.  Ensure the database credentials match your XAMPP MySQL setup:
    ```php
    define('DB_HOST', 'localhost'); // Usually correct for XAMPP
    define('DB_USERNAME', 'drought_user'); // Replace with your MySQL username
    define('DB_PASSWORD', 'secure_password'); // Replace with your MySQL password
    define('DB_NAME', 'drought_prediction_db'); // Should match the DB you created
    ```
    *   **Note:** By default, the XAMPP MySQL root user is often `root` with **no password**. For development, you might temporarily use these credentials if you haven't set up a specific user:
        ```php
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', ''); 
        ```
    *   It is highly recommended to create a dedicated MySQL user (e.g., `drought_user`) with a strong password and grant it privileges only on `drought_prediction_db` for better security, even for local development. You can do this via phpMyAdmin's "User accounts" tab. (Ensure this user also has `CREATE TABLE` rights if `database.sql` is to be run by this user, though typically import is done as root/admin).

## 4. Running the Application

*   **Frontend Website:**
    *   Open your web browser and navigate to: `http://localhost/your-project-directory-name/`
    *   Example: `http://localhost/drought-prediction-system/`
*   **Backend Admin Panel:**
    *   Navigate to: `http://localhost/your-project-directory-name/admin/`
    *   Example: `http://localhost/drought-prediction-system/admin/`
    *   Log in with the admin username and password you created in step 3.5.

## 5. Troubleshooting (Optional)

*   **Apache or MySQL Not Starting:**
    *   This is often due to port conflicts (e.g., another application like Skype, IIS, or another web server is using port 80 or 443 for Apache, or port 3306 for MySQL).
    *   **Solution:** Stop the conflicting application or change the port for the XAMPP module. In XAMPP Control Panel, click "Config" for the respective module and change the port numbers in files like `httpd.conf` and `httpd-ssl.conf` for Apache, or `my.ini` for MySQL. Remember to update URLs if you change Apache's port (e.g., `http://localhost:8080/`).
*   **Database Connection Errors ("Connection failed..." or similar on the website):**
    *   Double-check the database credentials (`DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_NAME`) in `config/db.php`.
    *   Ensure MySQL server is running in XAMPP.
    *   Ensure the database `drought_prediction_db` exists and the user has permissions.
*   **PHP Errors (e.g., blank pages, error messages within the page):**
    *   Check PHP error logs. In XAMPP Control Panel, there's often a "Logs" button next to Apache, or you can find them in `C:\xampp\php\logs\php_error_log` (Windows) or `/opt/lampp/logs/php_error_log` (Linux).
*   **File Not Found (404 Errors):**
    *   Verify that you've placed the project files correctly in the `htdocs` subdirectory.
    *   Check that the URL you are using matches the directory structure.
    *   Ensure file/folder names are correct (case sensitivity can be an issue, especially if moving from Windows to Linux).
*   **Incorrect Paths for Includes/Requires:**
    *   If you see errors like `Warning: require_once(../config/db.php): failed to open stream...`, it indicates a path issue. The project uses relative paths like `../config/db.php` from within the `admin` directory, which should be correct given the described structure.
*   **Image Upload Failures:**
    *   Ensure the `uploads/`, `uploads/images/`, `uploads/images/news/`, and `uploads/images/researchers/` directories exist within your project root and are writable by the web server (see Section 3.4 on Directory Permissions).
    *   Check PHP error logs for more specific messages (e.g., "permission denied," "failed to write file").
    *   Verify that the `upload_max_filesize` and `post_max_size` directives in your `php.ini` file are large enough for the images you are trying to upload (though the application limits uploads to 5MB, PHP's own limits must also be sufficient).

---
This completes the local deployment guide.
