<?php include 'includes/header.php'; ?>
<style>
  body{
    background-color: black;
    color: white;
  }
</style>
<div class="content-area">

  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <h1>Financial Dashboard</h1>
    <small class="text-white">Welcome, Admin</small>
  </div>

  <!-- Summary Cards -->
  <div class="row g-4">
    <?php
    $cards = [
      ["Total Revenue","$25400","sparkRevenue"],
      ["Paid Orders","180","sparkPaid"],
      ["Pending Payments","25","sparkPending"],
      ["Refunds","5","sparkRefund"]
    ];
    foreach($cards as $c){
      echo '<div class="col-md-3 col-sm-6">';
      echo '<div class="panel text-center p-4">';
      echo "<h5>$c[0]</h5><h3 class='counter' data-count='".str_replace('$','',$c[1])."'>$c[1]</h3>";
      echo "<canvas id='$c[2]' height='50'></canvas>";
      echo '</div></div>';
    }
    ?>
  </div>

  <!-- Charts Row -->
  <div class="row mt-5 g-4">
    <div class="col-lg-6 col-md-12">
      <div class="panel p-3">
        <h5>Monthly Revenue</h5>
        <canvas id="revenueChart" height="250"></canvas>
      </div>
    </div>
    <div class="col-lg-6 col-md-12">
      <div class="panel p-3">
        <h5>Order Status</h5>
        <canvas id="ordersPieChart" height="250"></canvas>
      </div>
    </div>
  </div>

  <!-- Recent Transactions Table -->
  <div class="row mt-5">
    <div class="col-12">
      <div class="panel p-3">
        <h5>Recent Transactions</h5>
        <div class="table-responsive">
        <table class="table table-striped table-hover table-dark">
          <thead>
            <tr>
              <th>ID</th><th>User</th><th>Book</th><th>Type</th><th>Amount</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>#TX101</td><td>John Doe</td><td>PHP Mastery</td><td>PDF</td><td>$20</td><td><span class="badge bg-success">Paid</span></td></tr>
            <tr><td>#TX102</td><td>Mary Smith</td><td>Comics Vol.1</td><td>Hard Copy</td><td>$15</td><td><span class="badge bg-warning text-dark">Pending</span></td></tr>
            <tr><td>#TX103</td><td>Alice Brown</td><td>Science GK</td><td>PDF</td><td>$10</td><td><span class="badge bg-danger">Refund</span></td></tr>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>

</div> <!-- content-area -->

<script>
/* Animated counters */
document.querySelectorAll('.counter').forEach(el => {
  const countTo = parseInt(el.dataset.count);
  let count = 0;
  const step = Math.ceil(countTo/100);
  const interval = setInterval(()=>{
    count+=step;
    if(count>=countTo){ el.innerText=countTo; clearInterval(interval); }
    else el.innerText=count;
  },15);
});

/* Sparkline charts */
function drawSpark(id,data){
  new Chart(document.getElementById(id).getContext('2d'),{
    type:'line',
    data:{ labels:data.map((_,i)=>i+1), datasets:[{
      data:data, borderColor:'var(--accent)', backgroundColor:'rgba(255,122,0,0.2)', fill:true, tension:0.3, pointRadius:0
    }]},
    options:{responsive:true, plugins:{legend:{display:false}}, scales:{x:{display:false},y:{display:false}}}
  });
}

drawSpark('sparkRevenue',[1200,1300,1250,1500,1600,1800]);
drawSpark('sparkPaid',[30,40,45,50,60,70]);
drawSpark('sparkPending',[5,10,8,12,15,20]);
drawSpark('sparkRefund',[2,1,3,4,5,5]);

/* Revenue Line Chart */
new Chart(document.getElementById('revenueChart').getContext('2d'),{
  type:'line',
  data:{
    labels:['Jan','Feb','Mar','Apr','May','Jun'],
    datasets:[{
      label:'Revenue ($)',
      data:[1200,1900,1500,2200,2800,3200],
      borderColor:'var(--accent)',
      backgroundColor:'rgba(255,122,0,0.2)',
      tension:0.4,
      fill:true,
      pointBackgroundColor:'var(--accent)',
      pointBorderColor:'var(--accent)'
    }]
  },
  options:{responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
});

/* Orders Pie Chart */
new Chart(document.getElementById('ordersPieChart').getContext('2d'),{
  type:'pie',
  data:{
    labels:['Paid','Pending','Refunds'],
    datasets:[{
      data:[180,25,5],
      backgroundColor:['rgba(255,122,0,0.8)','rgba(255,122,0,0.5)','rgba(255,122,0,0.3)'],
      borderColor:'#fff', borderWidth:2
    }]
  },
  options:{responsive:true, plugins:{legend:{position:'bottom',labels:{color:'var(--text)'}}}}
});
</script>

<?php include 'includes/footer.php'; ?>
