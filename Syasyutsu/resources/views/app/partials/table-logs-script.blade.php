<script>
function chk(url, targetId) {
    if (!url) return;
    return new Promise((resolve, reject) => {
        const img = new Image();
        const timer = setTimeout(() => reject(new Error("Timeout")), 1000);
        img.onload = () => { clearTimeout(timer); resolve(url); };
        img.onerror = () => { clearTimeout(timer); reject(url); };
        img.src = url;
    }).catch(() => {
        const el = document.getElementById(targetId);
        if (el) {
            el.innerHTML = '<img src="/image/no_image.png" width="60px">';
        }
    });
}

document.querySelectorAll('[id^="row_"]').forEach(row => {
    const id = row.id.replace('row_', '');
    const upper = row.dataset.upper || '';
    const side  = row.dataset.side  || '';

    if (upper) chk(upper, `img_upper_${id}`);
    if (side)  chk(side,  `img_side_${id}`);
});
</script>
