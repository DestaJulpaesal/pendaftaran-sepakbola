document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Lakukan validasi username dan password di sini, misalnya dengan AJAX ke server.

        // Contoh sederhana:
        if (username === "admin" && password === "admin") {
            alert("Login berhasil!");
            // Redirect ke halaman selanjutnya
            window.location.href = "index.html";
        } else {
            alert("Login gagal. Silakan coba lagi.");
        }
    });
});
