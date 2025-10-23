{{-- タブ切り替え用JS + 詳細比較モードJS --}}
<script>
function updateCounts(tabId) {
    const target = document.getElementById('tab-' + tabId);
    const counts = target ? target.querySelector('.counts') : null;
    const hook = document.getElementById('result-counts');
    hook.innerHTML = counts ? counts.innerHTML : '';
}

// 初期表示（全体タブ）
updateCounts('all');

// タブ切り替え
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        const target = document.getElementById('tab-' + btn.dataset.tab);
        if (target) target.classList.add('active');

        // 件数更新を追加
        updateCounts(btn.dataset.tab);
    });
});

    // 詳細比較モード
    const detailToggle = document.getElementById('detailToggle');
    const detailStatus = document.getElementById('detailStatus');

    if (detailToggle) {
        detailToggle.addEventListener('click', () => {
            detailToggle.classList.toggle('active');
            const isActive = detailToggle.classList.contains('active');
            detailStatus.textContent = isActive ? 'オン' : 'オフ';
            document.querySelectorAll('.detail-col').forEach(col => {
                col.style.display = isActive ? '' : 'none';
            });
        });

        // 初期状態は非表示
        document.querySelectorAll('.detail-col').forEach(col => col.style.display = 'none');
    }
</script>
