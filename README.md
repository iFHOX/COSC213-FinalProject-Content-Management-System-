# Hiking Spots CMS

**COSC 213: Web Development using LAMP - Final Project**

A dynamic content management system built with the LAMP stack that allows outdoor enthusiasts to discover, share, and discuss hiking trails.

## Team Members
- **Nery** - Frontend Design & UX
- **Simon** - Database Architecture & Testing
- **Daniel** - Backend Development & Security

## Table of Contents
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Prerequisites](#prerequisites)
- [Installation Guide](#installation-guide)
- [Demo Credentials](#demo-credentials)
- [Project Structure](#project-structure)
- [Security Features](#security-features)
- [Troubleshooting](#troubleshooting)

## Features

### Core Features
- **Public Blog** - Browse all hiking spots with images and descriptions
- **Full Article View** - Read complete hiking spot details with comments
- **User Authentication** - Secure login with bcrypt password hashing
- **Admin Dashboard** - Manage all posts with CRUD operations
- **Article Creation/Editing** - Create and edit hiking spot posts
- **User Roles** - Admin and Author role-based access control

### Advanced Features
- **Comments Section** - Public commenting system (no login required)
- **User-Specific Management** - Users can only edit their own posts
- **Responsive Design** - Mobile-friendly interface
- **Security** - SQL injection prevention, XSS protection, password hashing

## Technology Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | HTML5, CSS3, JavaScript |
| **Backend** | PHP 7.4+ |
| **Database** | MySQL 5.7+ |
| **Server** | Apache 2.4+ |

## Prerequisites

Before you begin, ensure you have the following installed:

- **XAMPP** (or LAMP/MAMP/WAMP) with:
  - Apache 2.4+
  - MySQL 5.7+
  - PHP 7.4+
- A web browser (Chrome, Firefox, Safari, Edge)
- Text editor (optional, for viewing code)

### Download XAMPP
- Windows: https://www.apachefriends.org/download.html
- Mac: https://www.apachefriends.org/download.html
- Linux: https://www.apachefriends.org/download.html

## Installation Guide

### Step 1: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Start **Apache** (click "Start" button)
3. Start **MySQL** (click "Start" button)
4. Verify both services show "Running" in green

### Step 2: Set Up Project Files

1. **Locate your XAMPP htdocs directory:**
   - Windows: `C:\xampp\htdocs\`
   - Mac: `/Applications/XAMPP/htdocs/`
   - Linux: `/opt/lampp/htdocs/`

2. **Create project folder:**
   ```
   htdocs/hiking-spots/
   ```

3. **Copy all project files** into the folder:
   ```
   hiking-spots/
   ├── article.php
   ├── config.php
   ├── dashboard.php
   ├── edit_article.php
   ├── index.php
   ├── login.php
   ├── logout.php
   ├── new_article.php
   ├── password_hashes.php
   ├── schema.sql
   ├── style.css
   └── logo.png
   ```

### Step 3: Create the Database

1. **Open phpMyAdmin:**
   - Navigate to: `http://localhost/phpmyadmin`
   - Or click "Admin" next to MySQL in XAMPP Control Panel

2. **Create new database:**
   - Click "**New**" in the left sidebar
   - Database name: `hiking_spots`
   - Collation: `utf8mb4_general_ci`
   - Click "**Create**"

3. **Import the schema:**
   - Select the `hiking_spots` database (click on it in left sidebar)
   - Click the "**Import**" tab at the top
   - Click "**Choose File**" button
   - Navigate to your project folder and select `schema.sql`
   - Scroll down and click "**Import**" button
   - Wait for success message: "Import has been successfully finished"

### Step 4: Verify Database Setup

1. In phpMyAdmin, click on `hiking_spots` database
2. You should see **3 tables:**
   - `users` (2 rows)
   - `posts` (3 rows)
   - `comments` (5 rows)

### Step 5: Access the Application

1. **Open your web browser**
2. **Navigate to:** `http://localhost/hiking-spots/index.php`
3. You should see the **"Find Your Hike!"** homepage with 3 sample hiking spots

## Demo Credentials

### Admin Account (Full Access)
```
Email: admin@hiking.com
Password: admin123
```
**Permissions:**
- View all posts from all users
- Create new posts
- Edit ANY post
- Delete ANY post

### Regular User Account (Author)
```
Email: user@hiking.com
Password: user123
```
**Permissions:**
- View all posts
- Create new posts
- Edit ONLY their own posts
- Delete ONLY their own posts

## Project Structure

### Core Files

| File | Purpose |
|------|---------|
| `index.php` | Homepage displaying all hiking spots |
| `article.php` | Individual post view with comments |
| `login.php` | User authentication page |
| `logout.php` | Session termination |
| `dashboard.php` | User post management interface |
| `new_article.php` | Create new hiking spot post |
| `edit_article.php` | Edit existing post |
| `config.php` | Database connection & session config |

### Database Files

| File | Purpose |
|------|---------|
| `schema.sql` | Complete database schema with sample data |
| `password_hashes.php` | Password hash generator utility (documentation) |

### Assets

| File | Purpose |
|------|---------|
| `style.css` | Application stylesheet |
| `logo.png` | Site logo image |

## Security Features

### Password Security
- **Bcrypt Hashing**: All passwords hashed using `password_hash()` with `PASSWORD_DEFAULT`
- **No Plain Text**: Passwords never stored or transmitted in plain text
- **Salt Generation**: Automatic random salt for each password

### SQL Injection Prevention
- **Prepared Statements**: All queries use MySQLi prepared statements
- **Parameter Binding**: User input bound with `bind_param()`
- **Type Safety**: Integer parameters use 'i', strings use 's'

### XSS Protection
- **Output Sanitization**: All output uses `htmlspecialchars()`
- **Prevent Script Injection**: User-submitted content cannot execute JavaScript

### Session Security
- **Session Management**: Secure session handling across all pages
- **Authorization Checks**: Users can only modify their own content
- **Role-Based Access**: Admin vs Author permissions

## Usage Guide

### For Visitors (No Login Required)
1. Browse all hiking spots on homepage
2. Click "Read More" to view full post details
3. Leave comments on any hiking spot

### For Logged-In Users
1. Click "**Login**" and enter credentials
2. Click "**New Spot**" to create a hiking post
3. Go to "**Dashboard**" to manage your posts
4. Click "**Edit**" to modify your posts
5. Click "**Delete**" (with confirmation) to remove posts

### For Admin Users
1. Login with admin credentials
2. Access all posts from all users in dashboard
3. Edit or delete any post in the system
4. Full moderation capabilities

## Troubleshooting

### "Connection failed" Error

**Problem:** Cannot connect to database

**Solutions:**
1. Verify MySQL is running in XAMPP Control Panel
2. Check database credentials in `config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'hiking_spots');
   ```
3. Ensure `hiking_spots` database exists in phpMyAdmin

### "Table doesn't exist" Error

**Problem:** Database tables not created

**Solutions:**
1. Re-import `schema.sql` in phpMyAdmin
2. Verify you selected the correct database before importing
3. Check that all 3 tables exist: `users`, `posts`, `comments`

### Login Not Working

**Problem:** Cannot login with demo credentials

**Solutions:**
1. Verify you're using correct credentials:
   - Admin: `admin@hiking.com` / `admin123`
   - User: `user@hiking.com` / `user123`
2. Check that `users` table has 2 rows in phpMyAdmin
3. Clear browser cookies and try again
4. Verify password hashes in database match schema.sql

### Images Not Displaying

**Problem:** Logo or post images not showing

**Solutions:**
1. Verify `logo.png` is in the same directory as PHP files
2. Check image URLs in database are valid and accessible
3. Ensure Apache has permissions to read image files

### "Access Denied" or Redirects to Login

**Problem:** Cannot access protected pages

**Solutions:**
1. Make sure you're logged in
2. Check that sessions are working (config.php starts sessions)
3. Verify you have permission to access the page (regular users can't access other users' edit pages)

### Page Shows Only PHP Code

**Problem:** Browser displays raw PHP code instead of executing it

**Solutions:**
1. Verify Apache is running in XAMPP
2. Access via `http://localhost/` URL (not `file://`)
3. Ensure files have `.php` extension (not `.php.txt`)

## Testing the Application

### Test User Authentication
1. Navigate to login page
2. Try logging in with **wrong** credentials → Should show error
3. Login with correct credentials → Should redirect to dashboard
4. Verify session persists across pages
5. Click logout → Should return to homepage

### Test CRUD Operations
1. Login as regular user
2. Create a new post → Should appear in dashboard
3. Edit your post → Changes should save
4. Try editing another user's post → Should be denied
5. Delete your post → Should remove from database

### Test Admin Privileges
1. Login as admin
2. Navigate to dashboard → Should see ALL posts
3. Edit any post → Should work
4. Delete any post → Should work

### Test Comments
1. Navigate to any hiking spot article
2. Post a comment without logging in → Should work
3. Verify comment appears with username and timestamp
4. Delete a post → Comments should also be deleted

### Test Security
1. Try accessing `dashboard.php` without login → Should redirect to login
2. Try SQL injection in login form → Should be blocked by prepared statements
3. Try XSS in comment form → Should be sanitized with htmlspecialchars()

## Additional Documentation

### Password Hash Generation
The demo account passwords were generated using the `password_hashes.php` utility script. This demonstrates the use of PHP's `password_hash()` function with bcrypt.

**Note:** Due to bcrypt's random salt generation, running this script produces different hashes each time, but all hashes for the same password verify correctly with `password_verify()`.

### Database Schema
The database is normalized to Third Normal Form (3NF):
- **Users** → **Posts** (One-to-Many via `user_id`)
- **Posts** → **Comments** (One-to-Many via `post_id`)
- CASCADE deletes maintain referential integrity

## Learning Outcomes

This project demonstrates:
- PHP server-side programming
- MySQL database design and normalization
- User authentication and session management
- Security best practices (password hashing, SQL injection prevention, XSS protection)
- Frontend-backend integration
- CRUD operations implementation
- Role-based access control
- Responsive web design

## License

This project was created for educational purposes as part of COSC 213 coursework.

## Acknowledgments

- COSC 213 Course Professors
- Team Members: Nery, Simon, Daniel

---

**Course:** COSC 213 - Web Development using LAMP  
**Project:** Content Management System (CMS)
