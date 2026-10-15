<%@ page contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" %>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Student Portal Login</title><link rel="stylesheet" href="${pageContext.request.contextPath}/style.css"></head>
<body><main class="login-card">
  <p class="eyebrow">STUDENT PORTAL</p><h1>Welcome back</h1><p>Sign in to view student profiles.</p>
  <% if (request.getAttribute("error") != null) { %><p class="error"><%= request.getAttribute("error") %></p><% } %>
  <form method="post" action="${pageContext.request.contextPath}/login">
    <label>Username<input name="username" required autocomplete="username"></label>
    <label>Password<input name="password" type="password" required autocomplete="current-password"></label>
    <button type="submit">Sign in</button>
  </form>
  <p class="hint">Demo: student / student123</p>
</main></body></html>
