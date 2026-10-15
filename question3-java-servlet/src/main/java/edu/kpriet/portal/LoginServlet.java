package edu.kpriet.portal;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.*;
import java.io.IOException;

@WebServlet("/login")
public class LoginServlet extends HttpServlet {
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        request.getRequestDispatcher("/WEB-INF/login.jsp").forward(request, response);
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String username = request.getParameter("username");
        String password = request.getParameter("password");

        // Demo credentials for the assignment. Use hashed database passwords in production.
        if ("student".equals(username) && "student123".equals(password)) {
            HttpSession session = request.getSession(true);
            session.setAttribute("loggedInUser", username);
            response.sendRedirect(request.getContextPath() + "/students");
        } else {
            request.setAttribute("error", "Incorrect username or password.");
            request.getRequestDispatcher("/WEB-INF/login.jsp").forward(request, response);
        }
    }
}
