/**
 * Enquiry form – submit via AJAX (vanilla JS).
 */
(function () {
    var form = document.getElementById('enquiry-form');
    var msg = document.getElementById('enquiry-message');
    var btn = document.getElementById('enquiry-submit');

    if (!form || !msg || !btn) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        msg.style.display = 'none';
        msg.className = '';
        msg.textContent = '';
        btn.disabled = true;
        btn.textContent = 'Sending…';

        var fd = new FormData(form);
        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'submit-enquiry.php');
        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) return;

            btn.disabled = false;
            btn.textContent = 'Submit';

            var ok = false;
            var err = 'Something went wrong. Please try again.';
            try {
                var res = JSON.parse(xhr.responseText || '{}');
                ok = res.ok === true;
                err = res.error || res.msg || err;
            } catch (_) {}

            msg.textContent = err;
            msg.style.display = 'block';
            if (ok) {
                msg.style.background = 'rgba(34,197,94,0.1)';
                msg.style.border = '1px solid rgba(34,197,94,0.3)';
                msg.style.color = '#4ade80';
                form.reset();
            } else {
                msg.style.background = 'rgba(239,68,68,0.1)';
                msg.style.border = '1px solid rgba(239,68,68,0.3)';
                msg.style.color = '#f87171';
            }
        };

        xhr.send(fd);
    });
})();
