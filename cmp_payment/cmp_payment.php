<script type="text/javascript" src="/cmp_payment/cmp_payment.js?<?php echo random_int(0, 99999999); ?>"></script>
<link rel="stylesheet" href="/cmp_payment/style.css?<?php echo random_int(0, 99999999); ?>" />

<?php
include 'db.php';
include 'lang.php';

?>

<?php if (isset($_GET['cmp_payment_cancel'])) { ?>

    <div id="paymentModal_cancel" style="display:block;">
        <div id="paymentModalContent_cancel">
            <h3><?php echo $consentText; ?></h3>
            <p><?php echo $notCompletedPaymentText; ?></p>
            <div id="cmp_payment_cancel_close_btn">x</div>
        </div>
    </div>

<?php } else if (isset($_GET['cmp_payment_token'])) { ?>

    <div id="paymentModal_token" style="display:block;">
        <div id="paymentModalContent_token">
            <h3><?php echo $successfulPurchaseText; ?></h3>
            <p><?php echo $completedPurchaseText; ?></p>
            <p><?php echo $validCodeText; ?><strong><?php echo htmlspecialchars($_GET['cmp_payment_token'], ENT_QUOTES, 'UTF-8'); ?></strong>.</p>
            <p><?php echo $importantSaveCodeText; ?></p>
            <script>localStorage.setItem("cmp_payment_token", "<?php echo htmlspecialchars($_GET['cmp_payment_token'], ENT_QUOTES, 'UTF-8'); ?>");</script>
            <div id="cmp_payment_token_close_btn">x</div>
        </div>
    </div>

<?php } else if (isset($_GET['cmp_payment_check_token'])) { ?>

    <div id="paymentModal_token" style="display:block;">
        <div id="paymentModalContent_token">
            <h3><?php echo $tokenValidation; ?></h3>

            <?php if (checkToken(htmlspecialchars($_GET['cmp_payment_check_token'], ENT_QUOTES, 'UTF-8'))) { ?>
                <p><?php echo $codeValidated; ?></p>
                <p><?php echo $canNavigate; ?></p>
                <script>localStorage.setItem("cmp_payment_token", "<?php echo htmlspecialchars($_GET['cmp_payment_check_token'], ENT_QUOTES, 'UTF-8'); ?>");</script>
            <?php } else { ?>
                <p><?php echo $codeNotValid; ?></p>
                <p><?php echo $waitCode; ?>.</p>
                <p><?php echo $needAccept; ?></p>
            <?php } ?>

            <div id="cmp_payment_token_close_btn">x</div>
        </div>
    </div>

<?php } ?>

<div id="paymentModal">
    <div id="paymentModalContent">
        <div class="acceptContent">
            <h2><?php echo $browseFree; ?></h2>
            <button onclick="Sddan.cmp.displayUI()"><?php echo $consentText; ?></button>
        </div>
        <div class="paymentContent">
            <h2><?php echo $browseWithoutAccept; ?></h2>
            <p><?php echo $payWithText; ?></p>

            <?php

                $cmp_payment_token = substr(str_shuffle(MD5(microtime())), 0, 30);

                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                $cmp_payment_cancel_url = $cmp_payment_finish_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                if (strpos($_SERVER['REQUEST_URI'], '?') !== false) {
                    $cmp_payment_cancel_url .= '&cmp_payment_cancel=1';
                    $cmp_payment_finish_url .= '&cmp_payment_token=' . $cmp_payment_token;
                } else {
                    $cmp_payment_cancel_url .= '?cmp_payment_cancel=1';
                    $cmp_payment_finish_url .= '?cmp_payment_token=' . $cmp_payment_token;
                }

                $cmp_payment_notify_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/cmp_payment/payment_ipn.php';

            ?>
            
            <form id="paypal_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input name="amount" type="hidden" value="41.32">
                <input name="currency_code" type="hidden" value="EUR">
                <input name="shipping" type="hidden" value="0.00">
                <input name="no_note" type="hidden" value="1">
                <input type="hidden" name="no_shipping"value="1">
                <input name="tax" type="hidden" value="8.68">
                <input name="return" type="hidden" value="<?php echo $cmp_payment_finish_url; ?>">
                <input name="cancel_return" type="hidden" value="<?php echo $cmp_payment_cancel_url; ?>">
                <input name="notify_url" type="hidden" value="<?php echo $cmp_payment_notify_url; ?>">
                <input name="cmd" type="hidden" value="_xclick">
                <input name="business" type="hidden" value="<?php echo $paypal_email; ?>">
                <input name="item_name" type="hidden" value="<?php echo $oneYear; ?>">
                <input name="lc" type="hidden" value="ES">
                <input name="bn" type="hidden" value="PP-BuyNowBF">
                <input name="custom" type="hidden" value="<?php echo $cmp_payment_token; ?>">
                
                <div onclick="document.forms['paypal_form'].submit();">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAxcHgiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAxMDEgMzIiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaW5ZTWluIG1lZXQiIHhtbG5zPSJodHRwOiYjeDJGOyYjeDJGO3d3dy53My5vcmcmI3gyRjsyMDAwJiN4MkY7c3ZnIj48cGF0aCBmaWxsPSIjMDAzMDg3IiBkPSJNIDEyLjIzNyAyLjggTCA0LjQzNyAyLjggQyAzLjkzNyAyLjggMy40MzcgMy4yIDMuMzM3IDMuNyBMIDAuMjM3IDIzLjcgQyAwLjEzNyAyNC4xIDAuNDM3IDI0LjQgMC44MzcgMjQuNCBMIDQuNTM3IDI0LjQgQyA1LjAzNyAyNC40IDUuNTM3IDI0IDUuNjM3IDIzLjUgTCA2LjQzNyAxOC4xIEMgNi41MzcgMTcuNiA2LjkzNyAxNy4yIDcuNTM3IDE3LjIgTCAxMC4wMzcgMTcuMiBDIDE1LjEzNyAxNy4yIDE4LjEzNyAxNC43IDE4LjkzNyA5LjggQyAxOS4yMzcgNy43IDE4LjkzNyA2IDE3LjkzNyA0LjggQyAxNi44MzcgMy41IDE0LjgzNyAyLjggMTIuMjM3IDIuOCBaIE0gMTMuMTM3IDEwLjEgQyAxMi43MzcgMTIuOSAxMC41MzcgMTIuOSA4LjUzNyAxMi45IEwgNy4zMzcgMTIuOSBMIDguMTM3IDcuNyBDIDguMTM3IDcuNCA4LjQzNyA3LjIgOC43MzcgNy4yIEwgOS4yMzcgNy4yIEMgMTAuNjM3IDcuMiAxMS45MzcgNy4yIDEyLjYzNyA4IEMgMTMuMTM3IDguNCAxMy4zMzcgOS4xIDEzLjEzNyAxMC4xIFoiPjwvcGF0aD48cGF0aCBmaWxsPSIjMDAzMDg3IiBkPSJNIDM1LjQzNyAxMCBMIDMxLjczNyAxMCBDIDMxLjQzNyAxMCAzMS4xMzcgMTAuMiAzMS4xMzcgMTAuNSBMIDMwLjkzNyAxMS41IEwgMzAuNjM3IDExLjEgQyAyOS44MzcgOS45IDI4LjAzNyA5LjUgMjYuMjM3IDkuNSBDIDIyLjEzNyA5LjUgMTguNjM3IDEyLjYgMTcuOTM3IDE3IEMgMTcuNTM3IDE5LjIgMTguMDM3IDIxLjMgMTkuMzM3IDIyLjcgQyAyMC40MzcgMjQgMjIuMTM3IDI0LjYgMjQuMDM3IDI0LjYgQyAyNy4zMzcgMjQuNiAyOS4yMzcgMjIuNSAyOS4yMzcgMjIuNSBMIDI5LjAzNyAyMy41IEMgMjguOTM3IDIzLjkgMjkuMjM3IDI0LjMgMjkuNjM3IDI0LjMgTCAzMy4wMzcgMjQuMyBDIDMzLjUzNyAyNC4zIDM0LjAzNyAyMy45IDM0LjEzNyAyMy40IEwgMzYuMTM3IDEwLjYgQyAzNi4yMzcgMTAuNCAzNS44MzcgMTAgMzUuNDM3IDEwIFogTSAzMC4zMzcgMTcuMiBDIDI5LjkzNyAxOS4zIDI4LjMzNyAyMC44IDI2LjEzNyAyMC44IEMgMjUuMDM3IDIwLjggMjQuMjM3IDIwLjUgMjMuNjM3IDE5LjggQyAyMy4wMzcgMTkuMSAyMi44MzcgMTguMiAyMy4wMzcgMTcuMiBDIDIzLjMzNyAxNS4xIDI1LjEzNyAxMy42IDI3LjIzNyAxMy42IEMgMjguMzM3IDEzLjYgMjkuMTM3IDE0IDI5LjczNyAxNC42IEMgMzAuMjM3IDE1LjMgMzAuNDM3IDE2LjIgMzAuMzM3IDE3LjIgWiI+PC9wYXRoPjxwYXRoIGZpbGw9IiMwMDMwODciIGQ9Ik0gNTUuMzM3IDEwIEwgNTEuNjM3IDEwIEMgNTEuMjM3IDEwIDUwLjkzNyAxMC4yIDUwLjczNyAxMC41IEwgNDUuNTM3IDE4LjEgTCA0My4zMzcgMTAuOCBDIDQzLjIzNyAxMC4zIDQyLjczNyAxMCA0Mi4zMzcgMTAgTCAzOC42MzcgMTAgQyAzOC4yMzcgMTAgMzcuODM3IDEwLjQgMzguMDM3IDEwLjkgTCA0Mi4xMzcgMjMgTCAzOC4yMzcgMjguNCBDIDM3LjkzNyAyOC44IDM4LjIzNyAyOS40IDM4LjczNyAyOS40IEwgNDIuNDM3IDI5LjQgQyA0Mi44MzcgMjkuNCA0My4xMzcgMjkuMiA0My4zMzcgMjguOSBMIDU1LjgzNyAxMC45IEMgNTYuMTM3IDEwLjYgNTUuODM3IDEwIDU1LjMzNyAxMCBaIj48L3BhdGg+PHBhdGggZmlsbD0iIzAwOWNkZSIgZD0iTSA2Ny43MzcgMi44IEwgNTkuOTM3IDIuOCBDIDU5LjQzNyAyLjggNTguOTM3IDMuMiA1OC44MzcgMy43IEwgNTUuNzM3IDIzLjYgQyA1NS42MzcgMjQgNTUuOTM3IDI0LjMgNTYuMzM3IDI0LjMgTCA2MC4zMzcgMjQuMyBDIDYwLjczNyAyNC4zIDYxLjAzNyAyNCA2MS4wMzcgMjMuNyBMIDYxLjkzNyAxOCBDIDYyLjAzNyAxNy41IDYyLjQzNyAxNy4xIDYzLjAzNyAxNy4xIEwgNjUuNTM3IDE3LjEgQyA3MC42MzcgMTcuMSA3My42MzcgMTQuNiA3NC40MzcgOS43IEMgNzQuNzM3IDcuNiA3NC40MzcgNS45IDczLjQzNyA0LjcgQyA3Mi4yMzcgMy41IDcwLjMzNyAyLjggNjcuNzM3IDIuOCBaIE0gNjguNjM3IDEwLjEgQyA2OC4yMzcgMTIuOSA2Ni4wMzcgMTIuOSA2NC4wMzcgMTIuOSBMIDYyLjgzNyAxMi45IEwgNjMuNjM3IDcuNyBDIDYzLjYzNyA3LjQgNjMuOTM3IDcuMiA2NC4yMzcgNy4yIEwgNjQuNzM3IDcuMiBDIDY2LjEzNyA3LjIgNjcuNDM3IDcuMiA2OC4xMzcgOCBDIDY4LjYzNyA4LjQgNjguNzM3IDkuMSA2OC42MzcgMTAuMSBaIj48L3BhdGg+PHBhdGggZmlsbD0iIzAwOWNkZSIgZD0iTSA5MC45MzcgMTAgTCA4Ny4yMzcgMTAgQyA4Ni45MzcgMTAgODYuNjM3IDEwLjIgODYuNjM3IDEwLjUgTCA4Ni40MzcgMTEuNSBMIDg2LjEzNyAxMS4xIEMgODUuMzM3IDkuOSA4My41MzcgOS41IDgxLjczNyA5LjUgQyA3Ny42MzcgOS41IDc0LjEzNyAxMi42IDczLjQzNyAxNyBDIDczLjAzNyAxOS4yIDczLjUzNyAyMS4zIDc0LjgzNyAyMi43IEMgNzUuOTM3IDI0IDc3LjYzNyAyNC42IDc5LjUzNyAyNC42IEMgODIuODM3IDI0LjYgODQuNzM3IDIyLjUgODQuNzM3IDIyLjUgTCA4NC41MzcgMjMuNSBDIDg0LjQzNyAyMy45IDg0LjczNyAyNC4zIDg1LjEzNyAyNC4zIEwgODguNTM3IDI0LjMgQyA4OS4wMzcgMjQuMyA4OS41MzcgMjMuOSA4OS42MzcgMjMuNCBMIDkxLjYzNyAxMC42IEMgOTEuNjM3IDEwLjQgOTEuMzM3IDEwIDkwLjkzNyAxMCBaIE0gODUuNzM3IDE3LjIgQyA4NS4zMzcgMTkuMyA4My43MzcgMjAuOCA4MS41MzcgMjAuOCBDIDgwLjQzNyAyMC44IDc5LjYzNyAyMC41IDc5LjAzNyAxOS44IEMgNzguNDM3IDE5LjEgNzguMjM3IDE4LjIgNzguNDM3IDE3LjIgQyA3OC43MzcgMTUuMSA4MC41MzcgMTMuNiA4Mi42MzcgMTMuNiBDIDgzLjczNyAxMy42IDg0LjUzNyAxNCA4NS4xMzcgMTQuNiBDIDg1LjczNyAxNS4zIDg1LjkzNyAxNi4yIDg1LjczNyAxNy4yIFoiPjwvcGF0aD48cGF0aCBmaWxsPSIjMDA5Y2RlIiBkPSJNIDk1LjMzNyAzLjMgTCA5Mi4xMzcgMjMuNiBDIDkyLjAzNyAyNCA5Mi4zMzcgMjQuMyA5Mi43MzcgMjQuMyBMIDk1LjkzNyAyNC4zIEMgOTYuNDM3IDI0LjMgOTYuOTM3IDIzLjkgOTcuMDM3IDIzLjQgTCAxMDAuMjM3IDMuNSBDIDEwMC4zMzcgMy4xIDEwMC4wMzcgMi44IDk5LjYzNyAyLjggTCA5Ni4wMzcgMi44IEMgOTUuNjM3IDIuOCA5NS40MzcgMyA5NS4zMzcgMy4zIFoiPjwvcGF0aD48L3N2Zz4" alt="PayPal">
                </div> 
            </form>
            
            <p><?php echo $haveCode; ?></p>
            <input type="text" id="tokenInput" placeholder="<?php echo $tokenInputPlaceholder; ?>">
            <button id="submitToken"><?php echo $submitTokenButtonText; ?></button>
        </div>
    </div>
</div>