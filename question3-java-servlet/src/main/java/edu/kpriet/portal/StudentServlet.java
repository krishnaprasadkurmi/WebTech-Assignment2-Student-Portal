package edu.kpriet.portal;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.*;
import java.io.IOException;
import java.sql.*;
import java.util.*;

@WebServlet("/students")
public class StudentServlet extends HttpServlet {
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        List<Map<String, Object>> students = new ArrayList<>();
        String sql = "SELECT s.id, s.name, s.roll_number, s.email, s.course, " +
                     "f.id AS file_id, f.original_name, f.file_type " +
                     "FROM students s LEFT JOIN student_files f ON s.id = f.student_id " +
                     "ORDER BY s.id DESC, f.uploaded_at DESC";
        try (Connection connection = DBUtil.getConnection();
             PreparedStatement statement = connection.prepareStatement(sql);
             ResultSet rs = statement.executeQuery()) {
            Map<Integer, Map<String, Object>> byId = new LinkedHashMap<>();
            while (rs.next()) {
                int id = rs.getInt("id");
                Map<String, Object> student = byId.computeIfAbsent(id, key -> {
                    Map<String, Object> map = new LinkedHashMap<>();
                    try {
                        map.put("id", key);
                        map.put("name", rs.getString("name"));
                        map.put("roll_number", rs.getString("roll_number"));
                        map.put("email", rs.getString("email"));
                        map.put("course", rs.getString("course"));
                        map.put("files", new ArrayList<Map<String, Object>>());
                    } catch (SQLException ex) {
                        throw new RuntimeException(ex);
                    }
                    return map;
                });
                int fileId = rs.getInt("file_id");
                if (!rs.wasNull()) {
                    @SuppressWarnings("unchecked")
                    List<Map<String, Object>> studentFiles = (List<Map<String, Object>>) student.get("files");
                    Map<String, Object> file = new LinkedHashMap<>();
                    file.put("id", fileId);
                    file.put("original_name", rs.getString("original_name"));
                    file.put("file_type", rs.getString("file_type"));
                    studentFiles.add(file);
                }
            }
            students.addAll(byId.values());
        } catch (SQLException | RuntimeException ex) {
            getServletContext().log("Could not load student records", ex);
            request.setAttribute("error", "Could not load records. Check MySQL connection and database setup.");
        }
        request.setAttribute("students", students);
        request.getRequestDispatcher("/WEB-INF/students.jsp").forward(request, response);
    }
}
