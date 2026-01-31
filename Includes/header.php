<?php
session_start();
if (isset($_SESSION["useremail"]) && $_SESSION["user_image"]) {

  include_once("config.php");

  $competitionData = mysqli_query($conn, "SELECT * FROM competition ORDER BY start_time ASC");

  if (!$competitionData) {
    echo "Error fetching competitions: " . mysqli_error($conn);
    exit;
  }

  ?>
  <!-- //competition -->
  <?php while ($comp = mysqli_fetch_assoc($competitionData)) {

    $start = strtotime($comp['start_time']);
    $end = strtotime($comp['end_time']);
    $now = time();

    $isUpcoming = ($start > $now);
    $isOngoing = ($start <= $now && $end >= $now);
    $isEnded = ($end < $now);
    ?>
    <br><br><br><br>

    <div class="alert alert-dark shadow-sm border rounded-4 p-3 d-flex comp-line m-3">

      <span class="comp-name"><?= $comp['comp_name']; ?></span>

      <?php if ($isUpcoming): ?>
        <span class="badge bg-primary px-3 rounded-pill">Upcoming</span>
      <?php elseif ($isOngoing): ?>
        <span class="badge bg-success px-3 rounded-pill">Ongoing</span>
      <?php endif; ?>

      <span class="comp-desc"><?= $comp['comp_desc']; ?></span>

      <?php if ($isUpcoming): ?>
        <span id="countdown-<?= $comp['comp_id']; ?>" class="comp-countdown fw-semibold text-success"></span>
      <?php endif; ?>

      <?php if ($isUpcoming): ?>
        <a href="participate.php?id=<?php $comp['comp_id']; ?>" class="btn btn-outline-primary btn-sm px-4">

          Participate
        </a>

      <?php elseif ($isOngoing): ?>
        <a class="btn btn-danger btn-sm px-4 disabled">Competition Ongoing</a>

      <?php elseif ($isEnded): ?>
        <a href="participate.php?id=<?= $comp['comp_id']; ?>" class="btn btn-outline-primary btn-sm px-4">
          Participate
        </a>
      <?php endif; ?>


      <span class="comp-time">Starts: <?= date("d M Y H:i", $start); ?></span>

    </div>


    <!-- Countdown Script -->
    <?php if ($isUpcoming): ?>
      <script>
        (function () {
          const target = new Date("<?= date('Y-m-d H:i:s', $start); ?>").getTime();
          const box = document.getElementById("countdown-<?= $comp['comp_id']; ?>");

          function updateCountdown() {
            const now = new Date().getTime();
            const diff = target - now;

            if (diff <= 0) {
              box.innerHTML = "Competition Started!";
              box.classList.remove("text-success");
              box.classList.add("text-danger");
              return;
            }

            let d = Math.floor(diff / (1000 * 60 * 60 * 24));
            let h = Math.floor((diff / (1000 * 60 * 60)) % 24);
            let m = Math.floor((diff / (1000 * 60)) % 60);
            let s = Math.floor((diff / 1000) % 60);

            box.innerHTML = `⏳ Starts in: <b>${d}d ${h}h ${m}m ${s}s</b>`;
          }

          updateCountdown();
          setInterval(updateCountdown, 1000);
        })();
      </script>
    <?php endif; ?>

  <?php } ?>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    :root {
      --bg: #0a0a0a;
      --glass: rgba(20, 20, 30, 0.65);
      --border-glow: rgba(255, 122, 0, 0.4);
      --accent: #ff6a00;
      --accent-hover: #ff8c33;
      --text: #fff;
      --text-muted: #aaa;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .alert {
      background: linear-gradient(135deg, #fff4e6, #ffe8cc);
      border: none !important;
      border-left: 6px solid #ff8800 !important;
      transition: 0.3s ease-in-out;
    }

    .alert:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 22px rgba(255, 140, 0, 0.25);
    }

    .alert h5 {
      font-size: 1.25rem;
      background: linear-gradient(45deg, #ff6a00, #ff8800);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .badge {
      font-size: 0.8rem !important;
      box-shadow: 0 2px 6px rgba(255, 138, 0, 0.35);
      color: white !important;
    }

    .bg-primary {
      background-color: #ff8800 !important;
    }

    .bg-success {
      background-color: #ff6a00 !important;
    }

    .text-muted {
      font-size: 0.95rem;
      color: #8a6d3b !important;
      line-height: 1.45;
    }

    .btn-outline-primary {
      font-weight: 600;
      border-width: 2px;
      border-radius: 20px;
      border-color: #ff8800 !important;
      color: #ff8800 !important;
      transition: 0.25s;
    }

    .btn-outline-primary:hover {
      background: #ff8800 !important;
      color: #fff !important;
    }

    #countdown {
      font-size: 1.15rem;
      color: #ff6a00;
      text-shadow: 0 0 6px rgba(255, 115, 0, 0.3);
    }

    .text-secondary {
      color: #b36b24 !important;
    }

    .comp-line {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 25px;
      flex-wrap: nowrap;
    }

    .comp-name {
      font-weight: bold;
      white-space: nowrap;
    }

    .comp-desc {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 450px;
    }

    .comp-time {
      font-size: 0.85rem;
      white-space: nowrap;
    }

    .comp-countdown {
      white-space: nowrap;
    }

    body {
      background-color: white;
    }

    /* PREMIUM HEADER */
    .premium-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 80px;
      background-image: url("bg.png");
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border-glow);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
      z-index: 1000;
      padding: 0 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: white;
    }

    .logo-text {
      font-size: 1.6rem;
      font-weight: 700;
      background: linear-gradient(90deg, #ff9d00, #ff6a00);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 1.5px;
      text-shadow: 0 0 50px rgba(255, 255, 255, 0.99);
    }

    .nav-links {
      display: flex;
      gap: 2.5rem;
    }

    .nav-link {
      color: var(--text-muted);
      text-decoration: none;
      font-weight: 500;
      position: relative;
      transition: 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
      color: var(--accent);
    }

    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 50%;
      background: var(--accent);
      transition: 0.4s;
      transform: translateX(-50%);
    }

    .nav-link:hover::after,
    .nav-link.active::after {
      width: 100%;
    }

    .user-area {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .user-avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 2.5px solid var(--accent);
      background-size: cover;
      background-position: center;
      transition: 0.3s;
    }

    .user-avatar:hover {
      transform: scale(1.1);
      box-shadow: 0 0 25px rgba(255, 106, 0, 0.8);
    }

    .logout-btn {
      background: linear-gradient(135deg, #ff3e00, #ff6a00);
      border: none;
      color: #fff;
      padding: 10px 20px;
      border-radius: 50px;
      font-weight: 600;
    }

    .logout-btn:hover {
      transform: translateY(-3px);
      background: linear-gradient(135deg, #ff6a00, #ff3e00);
    }

    @media(max-width:992px) {
      .nav-links {
        display: none;
      }

      .logo-text {
        font-size: 1.4rem;
      }
    }

    @media(max-width:992px) {

      .premium-header {
        height: auto;
        padding: 10px 15px;
        flex-wrap: wrap;
        justify-content: space-between;
      }

      #menu-toggle {
        display: block;
        position: absolute;
        left: 15px;
        top: 20px;
      }

      .logo-text {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        width: 100%;
        margin-top: 5px;
      }

      .nav-links {
        display: none;
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        background: rgba(10, 10, 10, 0.95);
        padding: 15px 0;
        margin-top: 10px;
        border-radius: 6px;
        text-align: center;
      }

      .nav-link {
        font-size: 1.1rem;
        padding: 6px 0;
      }

      .user-area {
        width: 100%;
        justify-content: center;
        margin-top: 10px;
        text-align: center;
      }

      .user-avatar {
        width: 55px;
        height: 55px;
      }
    }
  </style>

  <header class="premium-header">
    <div class="logo-text">E-BOOK PANEL</div>

    <nav class="nav-links" style="display:flex; gap:20px; align-items:center;">
      <a href="index.php" class="nav-link active">
        <i class="fas fa-home" style="margin-right:6px;"></i> Home
      </a>
      <a href="books.php" class="nav-link" style="color: white;">
        <i class="fas fa-book" style="margin-right:6px;"></i> Books
      </a>
      <a href="about.php" class="nav-link" style="color: white;">
        <i class="fas fa-info-circle" style="margin-right:6px;"></i> About Us
      </a>
      <a href="cart.php" class="nav-link cart-nav" style="color:white; position:relative;">
        <i class="fas fa-shopping-cart" style="margin-right:6px;"></i>
        Cart
        <span id="nav-cart-total" style="
        margin-left:6px;
        font-weight:600;">$0</span>
      </a>

    </nav>

    <div style="display:flex; align-items:center; margin-left:100px;">
      <form action="search.php" method="GET"
        style="display:flex; align-items:center; background:#fff; border-radius:50px; padding:5px 5px 5px 10px; box-shadow:0 6px 18px rgba(255,136,0,0.25); transition: all 0.3s ease;">
        <input type="text" name="q" placeholder="Search books, categories..." required
          style="border:none; outline:none; padding:10px 15px; border-radius:50px; width:250px; font-size:15px; transition: width 0.3s ease;"
          onfocus="this.style.width='350px'; this.style.boxShadow='0 4px 12px rgba(255,106,0,0.35)';"
          onblur="this.style.width='250px'; this.style.boxShadow='none';">
        <button type="submit"
          style="background:#ff6600; border:none; color:white; border-radius:50%; width:42px; height:42px; display:flex; align-items:center; justify-content:center; margin-left:5px; cursor:pointer; transition: all 0.3s ease;"
          onmouseover="this.style.background='#ff8800'; this.style.transform='scale(1.1)';"
          onmouseout="this.style.background='#ff6600'; this.style.transform='scale(1)';">
          <i class="bi bi-search" style="font-size:18px;"></i>
        </button>
      </form>
    </div>

    <?php if (!empty($_SESSION['username'])): ?>
      <div class="user-area">
        <span>Hello, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <div class="user-avatar" style="background-image:url('Admin/forms/useruploads/<?= $_SESSION['user_image'] ?>')">
        </div>
        <button class="logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal"><i
            class="bi bi-box-arrow-right me-1"></i>Logout</button>
      </div>
    <?php endif; ?>
  </header>

  <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light border border-orange">
        <div class="modal-header border-0">
          <h5 class="modal-title">Confirm Logout</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">Are you sure you want to logout?</div>
        <div class="modal-footer border-0">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="./Admin/forms/logout.php" class="btn btn-danger">Yes, Logout</a>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
      const nav = document.querySelector(".nav-links");
      nav.style.display = nav.style.display === "flex" ? "none" : "flex";
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php } else {
  header("Location: admin/forms/login.php");
}
?>
<script>
  // Set cart data from PHP session
  window.CART_DATA = {
    total: <?php
      $t = 0;
      $c = 0;
      if (isset($_SESSION['books'])) {
        foreach ($_SESSION['books'] as $b) {
          $qty = $b['qty'] ?? 1;
          $t += $b['price'] * $qty;
          $c += $qty;
        }
      }
      echo $t;
    ?>,
    count: <?php echo $c ?? 0; ?>
  };

  // Update navbar cart totals on page load
  document.addEventListener("DOMContentLoaded", () => {
    const totalEl = document.getElementById("nav-cart-total");
    const countEl = document.getElementById("nav-cart-count");

    if (totalEl) totalEl.innerText = "$" + window.CART_DATA.total;
    if (countEl) countEl.innerText = window.CART_DATA.count;
  });
</script>
