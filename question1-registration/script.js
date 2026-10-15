const form = document.getElementById("registrationForm");
const fields = ["name", "roll", "email", "course", "password", "confirmPassword", "document"];

function showError(field, message) {
  const input = document.getElementById(field);
  const error = document.getElementById(field + "Error");
  if (input) input.classList.toggle("invalid", Boolean(message));
  if (error) error.textContent = message;
}

form.addEventListener("submit", (event) => {
  event.preventDefault();
  fields.forEach((field) => showError(field, ""));
  document.getElementById("successMessage").textContent = "";

  const name = document.getElementById("name").value.trim();
  const roll = document.getElementById("roll").value.trim();
  const email = document.getElementById("email").value.trim();
  const course = document.getElementById("course").value;
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;
  const file = document.getElementById("document").files[0];
  let valid = true;

  if (name.length < 2) { showError("name", "Enter a name with at least 2 characters."); valid = false; }
  if (!/^[A-Za-z0-9/-]{3,40}$/.test(roll)) { showError("roll", "Use 3–40 letters, numbers, / or -."); valid = false; }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showError("email", "Enter a valid email address."); valid = false; }
  if (!course) { showError("course", "Please select a course."); valid = false; }
  if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(password)) {
    showError("password", "Use 8+ characters with uppercase, lowercase, and a number."); valid = false;
  }
  if (confirmPassword !== password || !confirmPassword) { showError("confirmPassword", "Passwords must match."); valid = false; }
  if (!file) { showError("document", "Choose a file to upload."); valid = false; }
  else {
    const allowed = ["image/jpeg", "image/png", "application/pdf"];
    if (!allowed.includes(file.type)) { showError("document", "Only JPG, PNG, or PDF files are allowed."); valid = false; }
    if (file.size > 2 * 1024 * 1024) { showError("document", "File must be 2 MB or smaller."); valid = false; }
  }

  if (valid) {
    document.getElementById("successMessage").textContent =
      "Validation successful! This front-end demo does not save the data. Use the PHP section to store student records.";
    form.reset();
  }
});
