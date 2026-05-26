/* ============================================
   WARTECH - SPLASH SCREEN JS
   File: script.js (root folder)
   ============================================ */

(function () {
    let redirectUrl   = 'dashboard.php';
    let totalDuration = 3000;

    let loaderFill     = document.getElementById('loaderFill');
    let loaderText     = document.getElementById('loaderText');
    let percentText    = document.getElementById('percentText');
    let successOverlay = document.getElementById('successOverlay');

    if (!loaderFill || !successOverlay) return;

    let messages = [
        { pct: 0,   text: 'Memuat konfigurasi...' },
        { pct: 30,  text: 'Menghubungkan database...' },
        { pct: 55,  text: 'Menyiapkan data produk...' },
        { pct: 75,  text: 'Memuat komponen dashboard...' },
        { pct: 90,  text: 'Hampir selesai...' },
        { pct: 100, text: 'Siap!' },
    ];

    let startTime = null;

    function easeOutCubic(t) {
        return 1 - Math.pow(1 - t, 3);
    }

    function updateMessage(pct) {
        let current = messages[0].text;
        for (let i = 0; i < messages.length; i++) {
            if (pct >= messages[i].pct) current = messages[i].text;
        }
        if (loaderText.textContent !== current) {
            loaderText.style.opacity = '0';
            setTimeout(function () {
                loaderText.textContent = current;
                loaderText.style.opacity = '1';
            }, 150);
        }
    }

    function animate(timestamp) {
        if (!startTime) startTime = timestamp;
        let elapsed  = timestamp - startTime;
        let progress = Math.min(elapsed / totalDuration, 1);
        let eased    = easeOutCubic(progress);
        let pct      = Math.round(eased * 100);

        loaderFill.style.width  = pct + '%';
        percentText.textContent = pct + '%';
        updateMessage(pct);

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            showSuccess();
        }
    }

    function showSuccess() {
        successOverlay.classList.add('show');
        setTimeout(function () {
            window.location.href = redirectUrl;
        }, 900);
    }

    requestAnimationFrame(animate);
})();