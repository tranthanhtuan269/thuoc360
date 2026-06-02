document.addEventListener('DOMContentLoaded', function () {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('.btn-copy').forEach(function (btn) {
        btn.addEventListener('click', async function () {
            const code = btn.dataset.code;
            const revealUrl = btn.dataset.revealUrl;

            if (code) {
                await copyText(code, btn);
                return;
            }

            if (!revealUrl || !csrf) return;

            try {
                const res = await fetch(revealUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                });
                const data = await res.json();
                if (data.code) {
                    await copyText(data.code, btn);
                } else {
                    alert('This offer has no promo code. Click "Shop Now" for details.');
                }
            } catch (e) {
                alert('Could not retrieve the code. Please try again.');
            }
        });
    });

    async function copyText(text, btn) {
        try {
            await navigator.clipboard.writeText(text);
            const original = btn.textContent;
            btn.textContent = 'Copied!';
            btn.classList.add('copied');
            setTimeout(function () {
                btn.textContent = original;
                btn.classList.remove('copied');
            }, 2000);
        } catch (e) {
            prompt('Copy this code:', text);
        }
    }
});
