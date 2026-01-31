<?php
include_once("config.php");
session_start();
$res = mysqli_query($conn, 'SELECT * FROM competition');

// Store participant ID if passed via URL
if(isset($_GET['id'])){
    $_SESSION['part_id'] = intval($_GET['id']);
}

// Handle form submission
if(isset($_POST['submit-btn'])){
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $part_id = $_SESSION['part_id'];

    $query = "INSERT INTO answers (part_id, answer) VALUES ('$part_id', '$answer')";
    $result = mysqli_query($conn, $query);

    if($result){
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error submitting answer!');</script>";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Competition</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root {
    --orange: #ff7b00;
    --orange-dark: #cc6100;
    --text-light: #ffffff;
    --overlay-dark: rgba(0, 0, 0, 0.6);
}

body {
    background: url('bg.png') center/cover no-repeat fixed;
    font-family: "Poppins", sans-serif;
    min-height: 100vh;
    position: relative;
}
body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: var(--overlay-dark);
    z-index: -1;
}

.main-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.form-container {
    width: 100%;
    max-width: 700px;
    background: rgba(0,0,0,0.5);
    border-radius: 18px;
    padding: 35px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    backdrop-filter: blur(6px);
    border-top: 6px solid var(--orange);
    color: var(--text-light);
}

.form-container h2 {
    color: var(--orange);
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
}

.form-label {
    font-weight: 600;
    color: var(--orange);
    font-size: 14px;
}

.btn-create-account {
    width: 100%;
    background: var(--orange);
    color: #fff;
    font-weight: 600;
    font-size: 16px;
    padding: 12px;
    border-radius: 10px;
    border: none;
    box-shadow: 0 4px 12px rgba(255,136,0,0.4);
    transition: 0.3s;
}
.btn-create-account:hover {
    background: var(--orange-dark);
    box-shadow: 0 6px 20px rgba(255,136,0,0.6);
    transform: translateY(-2px);
}

.error-text { color: red; font-size: 14px; margin-top: 5px; display: none; }
.success-text { color: green; font-size: 14px; margin-top: 5px; display: none; }

@media(max-width: 576px) {
    .form-container { padding: 25px; }
}
</style>
</head>

<body>
<div class="overlay"></div>
<div class="main-container">

    <!-- Timer Box -->
    <div id="timerBox" style="
        position:fixed;
        top:20px;
        right:20px;
        padding:15px 25px;
        background:rgba(0,0,0,0.5);
        backdrop-filter:blur(10px);
        color:#fff;
        font-size:22px;
        border-radius:12px;
        border:1px solid rgba(255,255,255,0.2);
        box-shadow:0 0 15px rgba(0,0,0,0.4);
        z-index:999;
        transition:0.4s ease;">
        ⏳ Time Left: <span id="timer">20:00</span>
    </div>

    <div class="form-container">
        <h2>Write Your Answer Now!</h2>

        <?php foreach($res as $comp){ ?>
            <p>Competition Name : <?php echo $comp['comp_name']; ?></p>
            <p>Competition Description : <?php echo $comp['comp_desc']; ?></p>
            <p>Competition Category : <?php echo $comp['comp_category']; ?></p>
            <p>Competition <strong style="color:red">Question</strong> : <?php echo $comp['comp_question']; ?></p>
        <?php } ?>

        <hr>
        <p class="mt-2">Instructions: <br>
            Your answer must contain <span style="color:#f00"><strong>exactly 100 words</strong></span>.<br>
            You have 20 minutes to complete the competition. Your answer will auto-submit if time ends.
        </p>

        <form method="post" id="answerForm" novalidate>
            <div class="form-group mt-3">
                <label class="form-label">Answer:</label>
                <textarea class="form-control" placeholder="Enter Your Answer" name="answer" id="answerBox" style="height:250px;" required></textarea>

                <p class="error-text" id="wordError">Your answer must be exactly 100 words!</p>
                <p class="success-text" id="wordSuccess">Perfect! You have written exactly 100 words.</p>
            </div>

            <div class="form-group mt-4">
                <input type="submit" class="btn btn-create-account" value="Submit" name="submit-btn">
            </div>
        </form>
    </div>
</div>

<script>
const answerBox = document.getElementById("answerBox");
const form = document.getElementById("answerForm");
const errorText = document.getElementById("wordError");
const successText = document.getElementById("wordSuccess");
const timerBox = document.getElementById("timerBox");
const submitBtn = document.querySelector("input[name='submit-btn']");

function countWords(text) {
    text = text.replace(/\n/g, " ").replace(/\s+/g, " ").trim();
    if(text.length === 0) return 0;
    return text.split(" ").length;
}

// Enable submit only when exactly 100 words
answerBox.addEventListener("input", () => {
    const words = countWords(answerBox.value);
    if(words === 100){
        successText.style.display = "block";
        errorText.style.display = "none";
    } else {
        successText.style.display = "none";
        errorText.style.display = "none";
    }
});

// Validate on submit
form.addEventListener("submit", function(event){
    const words = countWords(answerBox.value);
    if(words !== 100){
        event.preventDefault();
        errorText.innerText = "Your answer has " + words + " words. It must be exactly 100.";
        errorText.style.display = "block";
        successText.style.display = "none";
    }
});

/* TIMER WITH AUTO-SUBMIT */
const COMP_TIMER_KEY = "competition_timer_start";
let startTime = localStorage.getItem(COMP_TIMER_KEY);

if(!startTime){
    startTime = Date.now();
    localStorage.setItem(COMP_TIMER_KEY, startTime);
}

const duration = 20 * 60 * 1000; // 20 minutes
const timerElement = document.getElementById("timer");

function updateTimer(){
    const now = Date.now();
    const elapsed = now - startTime;
    const remaining = duration - elapsed;

    if(remaining <= 0){
        timerElement.textContent = "00:00";
        timerBox.style.background = "red";
        timerBox.style.color = "#fff";
        autoSubmit();
        return;
    }

    const totalSeconds = Math.floor(remaining / 1000);
    let minutes = Math.floor(totalSeconds / 60);
    let seconds = totalSeconds % 60;

    if(totalSeconds <= 60){
        timerBox.style.background = "rgba(255,0,0,0.7)";
        timerBox.style.color = "#fff";
        timerBox.style.boxShadow = "0 0 15px rgba(255,0,0,0.8)";
    }

    timerElement.textContent = (minutes < 10 ? "0":"") + minutes + ":" + (seconds < 10 ? "0":"") + seconds;
}

function autoSubmit(){
    alert("⏳ Time is over! Your answer is being auto-submitted.");
    localStorage.removeItem(COMP_TIMER_KEY);
    form.submit();
}

setInterval(updateTimer, 1000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
