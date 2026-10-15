package edu.kpriet.portal;

import javax.servlet.annotation.WebServlet;
import javax.servlet.http.*;
import java.io.*;
import java.nio.file.*;
import java.sql.*;

@WebServlet("/file/*")
public class FileServlet extends HttpServlet {
    // By default, stream files uploaded by the PHP application.
    // Change this to an absolute path if your XAMPP htdocs folder is elsewhere.
    private static final Path UPLOAD_DIR =
        Paths.get(System.getProperty("user.dir"), "uploads").toAbsolutePath().normalize();

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException {
        String idPart = request.getPathInfo();
        if (idPart == null || !idPart.matches("/\\d+")) {
            response.sendError(HttpServletResponse.SC_BAD_REQUEST, "Invalid file ID");
            return;
        }
        int id = Integer.parseInt(idPart);
        String sql = "SELECT original_name, stored_name, file_type FROM student_files WHERE id = ?";
        try (Connection connection = DBUtil.getConnection();
             PreparedStatement statement = connection.prepareStatement(sql)) {
            statement.setInt(1, id);
            try (ResultSet rs = statement.executeQuery()) {
                if (!rs.next()) {
                    response.sendError(HttpServletResponse.SC_NOT_FOUND, "File not found");
                    return;
                }
                String storedName = Paths.get(rs.getString("stored_name")).getFileName().toString();
                String originalName = rs.getString("original_name");
                String mime = rs.getString("file_type");
                Path path = UPLOAD_DIR.resolve(storedName).normalize();

                if (!path.startsWith(UPLOAD_DIR) || !Files.isRegularFile(path)) {
                    response.sendError(HttpServletResponse.SC_NOT_FOUND,
                        "File is missing. Configure UPLOAD_DIR in FileServlet.java to the PHP uploads folder.");
                    return;
                }
                response.setContentType(mime);
                response.setHeader("X-Content-Type-Options", "nosniff");
                response.setHeader("Content-Disposition",
                    (mime.startsWith("image/") ? "inline" : "attachment") +
                    "; filename*=UTF-8''" + java.net.URLEncoder.encode(originalName, java.nio.charset.StandardCharsets.UTF_8).replace("+", "%20"));
                response.setContentLengthLong(Files.size(path));
                try (InputStream in = Files.newInputStream(path); OutputStream out = response.getOutputStream()) {
                    in.transferTo(out);
                }
            }
        } catch (SQLException ex) {
            getServletContext().log("Could not stream file", ex);
            response.sendError(HttpServletResponse.SC_INTERNAL_SERVER_ERROR, "Database error");
        }
    }
}
