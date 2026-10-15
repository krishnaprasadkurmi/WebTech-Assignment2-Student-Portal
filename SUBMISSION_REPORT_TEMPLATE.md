# Web Technology Assignment 2 — Student Portal

**Student Name:Krishna Prasad Kurmi
**Register / Roll Number:24CS262
**Course:** U21CS501 Web Technology  
**Assignment:** II

## Objective
To develop a student registration form and student profile management portal using HTML, CSS, JavaScript, PHP, MySQL, Java Servlets, JDBC, and JSP.

## Question 1 — Registration Form
The registration form accepts name, roll number, email, course, password, and a file. JavaScript validates required fields, email format, password strength, matching passwords, file type, and file size. CSS makes the form responsive.

## Question 2 — PHP and MySQL
The PHP admin panel performs Create, Read, Update, and Delete operations on student records. Uploaded file metadata (file name, stored name/path, MIME type, size, and upload date) is linked to each student in MySQL. The code checks upload size/type and uses unique filenames to avoid overwriting.

## Question 3 — Servlet, JDBC, and JSP
The Java web application uses JDBC prepared statements to fetch student and file information from MySQL. JSP loops over student records and displays their profiles. FileServlet streams images/documents, and AuthFilter restricts the profile and file routes to logged-in sessions.

## Testing
- [ ] Empty form values show validation errors.
- [ ] Invalid email and weak password are rejected.
- [ ] Unsupported or oversized files are rejected.
- [ ] PHP admin can add, view, edit, and delete a student.
- [ ] Uploaded files and metadata appear on the student details page.
- [ ] Java portal redirects unauthenticated users to login.
- [ ] Correct login shows profiles and uploaded files.

## Screenshots
Paste browser screenshots below:
1. Registration form with validation.
2. PHP student records list.
3. Add/edit student form.
4. Student details with file metadata.
5. Java portal login.
6. Java student profile page with image/document links.

## Conclusion
This assignment demonstrates client-side form validation, server-side CRUD operations, MySQL data storage, secure file upload handling, and dynamic web content using Java Servlets and JSP. It also demonstrates session-based access control and JDBC connectivity.

## GitHub Repository
Add your repository URL here: ____________________
