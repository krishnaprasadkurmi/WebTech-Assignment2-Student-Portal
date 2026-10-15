# Web Technology Assignment 2 — Student Admission & Profile Portal

This project contains all three assignment parts:
1. `question1-registration/` — HTML, CSS, JavaScript registration form and client-side validation.
2. `question2-php-admin/` — PHP + MySQL CRUD, uploads, metadata, and file display.
3. `question3-java-servlet/` — Java Servlet + JDBC + JSP portal with session login and streamed files.

## Requirements
- VS Code
- XAMPP (Apache + MySQL + PHP)
- JDK 17 or newer
- Apache Maven
- Apache Tomcat 10.1
- MySQL Connector/J (download or Maven will resolve it)

## Database setup
1. Start MySQL in XAMPP.
2. Open `http://localhost/phpmyadmin`.
3. Select **Import** and import `database/student_portal.sql`.
   Alternatively, open the SQL file and run it in phpMyAdmin's SQL tab.
4. Default local database credentials in these examples: host `localhost`, database `student_portal`, user `root`, password empty. Change them in PHP `config.php` and Java `DBUtil.java` if your MySQL credentials differ.

## Run Question 1
Open `question1-registration/index.html` in Chrome, or use VS Code Live Server. This is a front-end form demo; it does not save data to the database.

## Run Question 2 (PHP)
1. Copy the `question2-php-admin` folder into `C:\xampp\htdocs\student-portal-php` (Windows).
2. Start **Apache** and **MySQL** in XAMPP.
3. Visit `http://localhost/student-portal-php/`.
4. Uploaded files are stored under `uploads/`. Do not run PHP pages using Live Server; use Apache.

## Run Question 3 (Java Servlet)
1. Install JDK 17+, Maven, and Tomcat 10.1.
2. In terminal, go to `question3-java-servlet`.
3. Run `mvn clean package`.
4. Copy `target/student-portal-servlet.war` to Tomcat's `webapps` folder and start Tomcat.
5. Visit `http://localhost:8080/student-portal-servlet/login`.
6. Demo login: username `student`, password `student123`. Change this before any real deployment.
7. Ensure the database from `database/student_portal.sql` is imported and update `DBUtil.java` if needed.

## Security and assignment notes
- This is an educational local project. Use prepared statements, randomized upload names, file type/size checks, and session checks.
- The demo login uses a simple fixed account to keep the assignment understandable. For production, store password hashes in the database and use HTTPS.
- PHP and Java are separate implementations and may use the same database schema. Upload folders are separate: PHP files go to `question2-php-admin/uploads/`; Java's servlet streams files from the configured upload folder. To show PHP uploads in the Java app too, set the Java `UPLOAD_DIR` to the absolute PHP uploads path in `FileServlet.java`.
