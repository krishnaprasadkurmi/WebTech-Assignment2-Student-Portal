
<%@ page contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" %>
<%@ page import="java.util.List,java.util.Map" %>

<%
    List<Map<String, Object>> students =
        (List<Map<String, Object>>) request.getAttribute("students");

    String error = (String) request.getAttribute("error");
    int totalFiles = 0;

    if (students != null) {
        for (Map<String, Object> s : students) {
            List<Map<String, Object>> files =
                (List<Map<String, Object>>) s.get("files");
            if (files != null) totalFiles += files.size();
        }
    }
%>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Profiles</title>
    <link rel="stylesheet"
          href="<%= request.getContextPath() %>/style.css">
</head>
<body>

<header class="navbar">
    <a class="brand" href="<%= request.getContextPath() %>/students">
        <span class="brand-icon">🎓</span>
        Student<span class="brand-blue">Portal</span>
    </a>

    <div class="nav-right">
        <span class="nav-label">Student Management</span>
        <a class="logout"
           href="<%= request.getContextPath() %>/logout">↗ Log out</a>
    </div>
</header>

<section class="hero">
    <div class="hero-content">
        <span class="eyebrow">STUDENT MANAGEMENT SYSTEM</span>
        <h1>Student <span>Profiles</span></h1>
        <p>
            All your student information in one place.
            Explore student details and uploaded documents.
        </p>

        <div class="hero-tags">
            <span>✓ MySQL Database</span>
            <span>✓ Java Servlet & JDBC</span>
            <span>✓ Document Management</span>
        </div>
    </div>

    <div class="hero-art" aria-hidden="true">
        <div class="art-circle"></div>
        <div class="cap">🎓</div>
        <div class="art-card">📄<br><small>Student files</small></div>
    </div>
</section>

<main class="container">

    <div class="section-heading">
        <div>
            <span class="eyebrow">OVERVIEW</span>
            <h2>Your student directory</h2>
            <p>Student records retrieved from MySQL using JDBC.</p>
        </div>
        <span class="count-badge">
            <%= students == null ? 0 : students.size() %> Students
        </span>
    </div>

    <% if (error != null) { %>
        <div class="error-message"><%= error %></div>
    <% } %>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">👥</div>
            <div>
                <h3><%= students == null ? 0 : students.size() %></h3>
                <p>Total Students</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">📁</div>
            <div>
                <h3><%= totalFiles %></h3>
                <p>Uploaded Files</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">🎓</div>
            <div>
                <h3>1</h3>
                <p>Academic Portal</p>
            </div>
        </div>
    </div>

    <div class="student-grid">
        <% if (students != null && !students.isEmpty()) { %>

            <% for (Map<String, Object> student : students) {
                String name = String.valueOf(student.get("name"));
                String initial = name.isEmpty() ? "S"
                    : name.substring(0, 1).toUpperCase();

                List<Map<String, Object>> files =
                    (List<Map<String, Object>>) student.get("files");
            %>

            <article class="student-card">
                <div class="card-top">
                    <div class="avatar"><%= initial %></div>
                    <span class="status">● Student Record</span>
                </div>

                <h2><%= student.get("name") %></h2>
                <span class="roll-badge">
                    Roll: <%= student.get("roll_number") %>
                </span>

                <div class="detail-row">
                    <span class="detail-icon">✉</span>
                    <div>
                        <small>Email address</small>
                        <p><%= student.get("email") %></p>
                    </div>
                </div>

                <div class="detail-row">
                    <span class="detail-icon">▤</span>
                    <div>
                        <small>Course / Department</small>
                        <p><%= student.get("course") %></p>
                    </div>
                </div>

                <div class="files-panel">
                    <div class="files-heading">
                        <span>📂</span>
                        Uploaded Documents
                        <span class="file-count">
                            <%= files == null ? 0 : files.size() %>
                        </span>
                    </div>

                    <% if (files != null && !files.isEmpty()) { %>
                        <% for (Map<String, Object> file : files) { %>
                            <div class="file-item">
                                <span class="pdf-icon">PDF</span>
                                <div class="file-info">
                                    <strong><%= file.get("original_name") %></strong>
                                    <small><%= file.get("file_type") %></small>
                                </div>
                                <a class="download-link"
                                   href="<%= request.getContextPath() %>/file?id=<%= file.get("id") %>">
                                    View ↗
                                </a>
                            </div>
                        <% } %>
                    <% } else { %>
                        <div class="empty-files">
                            <span>📄</span>
                            <div>
                                <strong>No files uploaded</strong>
                                <small>Documents will appear here when available.</small>
                            </div>
                        </div>
                    <% } %>
                </div>
            </article>

            <% } %>

        <% } else { %>
            <div class="empty-state">
                <span>🎓</span>
                <h2>No student records yet</h2>
                <p>Add students using your PHP admin panel, then refresh this page.</p>
            </div>
        <% } %>
    </div>

    <footer class="footer">
        Student Portal · Java Servlet · JDBC · MySQL
    </footer>

</main>
</body>
</html>
