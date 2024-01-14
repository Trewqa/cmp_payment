function startPayment() {
    const spToken = localStorage.getItem("cmp_payment_token");

    if (spToken) {
        console.log('cmp_payment_token found.');

        fetch(`/cmp_payment/db.php?token=${spToken}`)
            .then(response => response.text())
            .then(result => {
                if (result !== "1") {
                    localStorage.removeItem("cmp_payment_token");
                    console.log('Start the payment process.');
                    document.getElementById('paymentModal').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        console.log('Start the payment process.');
        document.getElementById('paymentModal').style.display = 'block';
    }
}

function parseQueryString(query) {
    const vars = query.split("&");
    const queryString = {};

    for (let i = 0; i < vars.length; i++) {
        const pair = vars[i].split("=");
        const key = decodeURIComponent(pair.shift());
        const value = decodeURIComponent(pair.join("="));

        if (typeof queryString[key] === "undefined") {
            queryString[key] = value;
        } else if (typeof queryString[key] === "string") {
            queryString[key] = [queryString[key], value];
        } else {
            queryString[key].push(value);
        }
    }

    return queryString;
}

function removeQueryParam(url, param, value) {
    const regex = new RegExp(`\\?${param}=${value}|&${param}=${value}`, 'g');
    return url.replace(regex, '');
}

function checkConsents(tcData) {
    if (tcData.gdprApplies) {
        if (tcData.eventStatus === 'tcloaded' || tcData.eventStatus === 'useractioncomplete') {
            const allConsentsAccepted = Object.values(tcData.purpose.consents).every(value => value === true);

            if (allConsentsAccepted) {
                console.log('All purposes have been accepted');
                document.getElementById('paymentModal').style.display = 'none';
            } else {
                console.log('Not all purposes have been accepted');

                if (window.location.href.indexOf("cmp_payment_") === -1) {
                    startPayment();
                }
            }
        }
    }
}

document.addEventListener("DOMContentLoaded", (event) => {
    window.__tcfapi('addEventListener', 2, (tcData, success) => {
        if (success) {
            checkConsents(tcData);
        }
    });

    const submitTokenBtn = document.getElementById("submitToken");
    if (submitTokenBtn !== null) {
        submitTokenBtn.onclick = () => {
            const token = document.getElementById("tokenInput").value;
            let spCheckUrl = window.location.href;

            spCheckUrl += window.location.href.indexOf('?') !== -1 ? `&cmp_payment_check_token=${token}` : `?cmp_payment_check_token=${token}`;

            window.location.href = spCheckUrl;
        };
    }

    const cancelCloseBtn = document.getElementById("cmp_payment_cancel_close_btn");
    if (cancelCloseBtn !== null) {
        cancelCloseBtn.onclick = () => {
            window.location.href = removeQueryParam(window.location.href, 'cmp_payment_cancel', '1');
        };
    }

    const tokenCloseBtn = document.getElementById("cmp_payment_token_close_btn");
    if (tokenCloseBtn !== null) {
        tokenCloseBtn.onclick = () => {
            const token = parseQueryString(window.location.search.substring(1)).cmp_payment_token;
            const payer = parseQueryString(window.location.search.substring(1)).PayerID;
            const spCheckToken = parseQueryString(window.location.search.substring(1)).cmp_payment_check_token;

            let urlRedirect = window.location.href;
            urlRedirect = removeQueryParam(urlRedirect, 'cmp_payment_token', token);
            urlRedirect = removeQueryParam(urlRedirect, 'PayerID', payer);
            urlRedirect = removeQueryParam(urlRedirect, 'cmp_payment_check_token', spCheckToken);

            window.location.href = urlRedirect;
        };
    }
});
