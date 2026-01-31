<?php
session_start();
include_once("includes/header.php");
include_once("config.php");

/* ===== HANDLE QUANTITY ACTION ===== */
if (isset($_GET['action'], $_GET['id'])) {
    foreach ($_SESSION['books'] as &$item) {
        if ($item['id'] == $_GET['id']) {
            if ($_GET['action'] == 'inc') {
                $item['qty']++;
            } elseif ($_GET['action'] == 'dec' && $item['qty'] > 1) {
                $item['qty']--;
            }
            break;
        }
    }
    echo "<script>window.location.href='cart.php'</script>";
    exit;
}
?>

<style>
    .cart-title {
        text-align: center;
        margin: 40px 0 20px;
        font-size: 32px;
        color: #ff7a00;
        font-family: Poppins, sans-serif;
    }

    .cart-container {
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }

    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 40px;
    }

    .cart-head,
    .cart-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 40px;
        align-items: center;
    }

    .cart-head {
        font-weight: 600;
        border-bottom: 1px solid #ddd;
        padding-bottom: 12px;
    }

    .cart-row {
        padding: 18px 0;
        border-bottom: 1px solid #eee;
    }

    .cart-product {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .cart-product img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
    }

    .qty-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-box a {
        width: 28px;
        height: 28px;
        border: 1px solid #ff7a00;
        color: #ff7a00;
        text-align: center;
        line-height: 26px;
        text-decoration: none;
        font-weight: 600;
    }

    .cart-price {
        font-weight: 600;
        color: #ff7a00;
    }

    .remove-btn {
        font-size: 22px;
        color: #ff7a00;
        text-decoration: none;
    }

    .cart-summary {
        background: #fff5ec;
        padding: 25px;
        border-radius: 14px;
    }

    .cart-summary h3 {
        color: #ff7a00;
        margin-bottom: 20px;
    }

    .sum-row {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        margin-bottom: 20px;
    }

    .checkout-btn {
        display: block;
        background: #ff7a00;
        color: #fff;
        text-align: center;
        padding: 14px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    @media(max-width:900px) {
        .cart-layout {
            grid-template-columns: 1fr;
        }
    }
</style>

<h2 class="cart-title">Shopping Cart</h2>

<div class="cart-container">

    <?php if (!empty($_SESSION['books'])) { ?>

        <div class="cart-layout">

            <div>
                <div class="cart-head">
                    <span>PRODUCT</span>
                    <span>QUANTITY</span>
                    <span>TOTAL</span>
                    <span></span>
                </div>

                <?php
                $total = 0;
                foreach ($_SESSION['books'] as &$item) {
                    if (!isset($item['qty']))
                        $item['qty'] = 1;
                    $itemTotal = $item['price'] * $item['qty'];
                    $total += $itemTotal;
                    ?>
                    <div class="cart-row">
                        <div class="cart-product">
                            <img src="bookimages/<?php echo $item['image']; ?>">
                            <div>
                                <h4><?php echo $item['name']; ?></h4>
                                <small><?php echo $item['category']; ?></small>
                            </div>
                        </div>

                        <div class="qty-box">
                            <a href="#" class="qty-btn" data-id="<?php echo $item['id']; ?>" data-action="dec">−</a>
                            <strong id="qty-<?php echo $item['id']; ?>"><?php echo $item['qty']; ?></strong>
                            <a href="#" class="qty-btn" data-id="<?php echo $item['id']; ?>" data-action="inc">+</a>
                        </div>


                        <div class="cart-price">
                            $<span id="item-total-<?php echo $item['id']; ?>">
                                <?php echo $itemTotal; ?>
                            </span>
                        </div>

                        <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>" class="remove-btn">×</a>
                    </div>
                <?php } ?>
            </div>

            <div class="cart-summary">
                <h3>CART TOTAL</h3>

                <div class="sum-row">
                    <span>Total</span>
                    <strong>$<span id="cart-total"><?php echo $total; ?></span></strong>
                </div>

                <a href="checkout.php" class="checkout-btn">PROCEED TO CHECKOUT</a>
            </div>

        </div>

    <?php } else { ?>
        <p style="text-align:center;font-size:22px;color:#777;">Your cart is empty.</p>
    <?php } ?>

</div>

<?php include_once("includes/footer.php"); ?>
<script>
document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const id = this.dataset.id;
        const action = this.dataset.action;

        fetch('cart_ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&action=${action}`
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('qty-' + id).innerText = data.qty;
            document.getElementById('item-total-' + id).innerText = data.itemTotal;
            document.getElementById('cart-total').innerText = data.cartTotal;
        });
    });
});
</script>
