<?php
if (isset($_SESSION["useremail"]) && $_SESSION["user_image"]) {
include_once("config.php");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contact Us — E-BOOK PANEL</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
:root {
    --accent: #ff6a00;
    --accent-light: #ff8800;
    --text-muted: #6e5846;
    --bg-light: #fff8f0;
    --box-bg: #fff4e6;
    --box-border: rgba(255, 138, 0, 0.3);
}

body {
    font-family: 'Poppins', sans-serif;
    background: var(--bg-light);
    color: #000;
    margin: 0;
}

.page-wrap {
    max-width: 1200px;
    margin: 100px auto 60px auto;
    padding: 0 20px;
}

h2.section-title {
    text-align: center;
    font-size: 2.2rem;
    color: var(--accent);
    font-weight: 700;
    margin-bottom: 10px;
}

p.section-sub {
    text-align: center;
    color: var(--text-muted);
    margin-bottom: 50px;
}

/* Left column contact cards */
.contact-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 40px;
}

.contact-card {
    background: var(--box-bg);
    border: 2px solid var(--box-border);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.contact-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(255,138,0,0.2);
}

.contact-card .icon {
    font-size: 30px;
    color: var(--accent);
    margin-bottom: 10px;
}

.contact-card h5 {
    font-weight: 600;
    color: var(--accent-light);
    margin-bottom: 6px;
}

.contact-card p {
    font-size: 14px;
    color: var(--text-muted);
}

/* Right column form */
.contact-form {
    background: var(--box-bg);
    border: 2px solid var(--box-border);
    border-radius: 12px;
    padding: 30px;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 16px;
    border-radius: 8px;
    border: 1px solid var(--box-border);
    font-size: 14px;
    transition: 0.3s;
}

.contact-form input:focus,
.contact-form textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 4px 12px rgba(255,138,0,0.2);
    outline: none;
}

.contact-form button {
    background: linear-gradient(90deg, var(--accent), var(--accent-light));
    color: #fff;
    font-weight: 600;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    width: 100%;
    transition: transform 0.2s;
}

.contact-form button:hover {
    transform: scale(1.02);
}

/* Two-column layout */
.contact-section {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}

.contact-left, .contact-right {
    flex: 1;
    min-width: 300px;
}

@media (max-width: 991px){
    .contact-section {
        flex-direction: column;
    }
    .contact-info {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>

<div class="page-wrap">
    <h2 class="section-title">Get In Touch With Us!</h2>
    <p class="section-sub">We are here to answer your questions and provide support.</p>

    <div class="contact-section">

        <!-- Left Column: Contact Info -->
        <div class="contact-left">
            <div class="contact-info">
                <div class="contact-card">
                    <div class="icon"><i class="bi bi-telephone-fill"></i></div>
                    <h5>Phone</h5>
                    <p>+1 234 567 890</p>
                </div>
                <div class="contact-card">
                    <div class="icon"><i class="bi bi-envelope-fill"></i></div>
                    <h5>Email</h5>
                    <p>support@ebookpanel.com</p>
                    <p>sales@ebookpanel.com</p>
                </div>
                <div class="contact-card">
                    <div class="icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <h5>Location</h5>
                    <p>123 Book Street, New York, USA</p>
                </div>
                <div class="contact-card">
                    <div class="icon"><i class="bi bi-clock-fill"></i></div>
                    <h5>Working Hours</h5>
                    <p>Mon - Sat | 09:00 AM - 06:00 PM</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Contact Form -->
        <div class="contact-right">
            <div class="contact-form">
                <form id="contactForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="fname" placeholder="First Name *" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="lname" placeholder="Last Name" >
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="mobile" placeholder="Mobile No *" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" placeholder="Email ID *" required>
                        </div>
                    </div>
                    <textarea name="message" rows="5" placeholder="Your Message"></textarea>
                    <input type="text" name="captcha" placeholder="Enter Captcha *" required>
                    <div style="margin-bottom:15px; font-size:14px; color:var(--text-muted)">Captcha: <b>p s t 5 s</b></div>
                    <button type="submit">Submit <i class="bi bi-send-fill"></i></button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('contactForm').addEventListener('submit', function(e){
    e.preventDefault();
    alert('Thank you! Your message has been sent (demo).');
    this.reset();
});
</script>
</body>
</html>
<?php
} else {
    header("Location: admin/forms/login.php");
}
?>
