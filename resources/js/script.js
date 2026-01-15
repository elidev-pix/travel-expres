// Fix: don't show modal on load; show it on button click and guard elements
(function(){
    const modal = document.getElementById('modalUnique');
    if (!modal) return;

    // ensure hidden state
    modal.classList.remove('show');

    function loadFormFromUrl(url){
        const container = modal.querySelector('#contenuFormulaire');
        if (!container) return;
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                container.innerHTML = html;
                modal.classList.add('show');
            })
            .catch(err => {
                console.error('Failed to load form:', err);
            });
    }

    // Load creation form via the dedicated get-form endpoint
    document.querySelectorAll('.btn-remplir').forEach(btn => {
        btn.addEventListener('click', function(e){
            e.preventDefault();
            const type = btn.getAttribute('data-type') || 'payment';
            const url = '/student/payment/get-form/' + encodeURIComponent(type);
            loadFormFromUrl(url);
        });
    });

    // Load edit form by fetching the edit URL (resource route: /student/payment/{id}/edit)
    document.querySelectorAll('.edit-link').forEach(link => {
        link.addEventListener('click', function(e){
            e.preventDefault();
            const href = link.getAttribute('href');
            if (!href) return;
            loadFormFromUrl(href);
        });
    });

    const closeBtn = modal.querySelector('.btn-close');
    if (closeBtn) closeBtn.addEventListener('click', function(){
        modal.classList.remove('show');
    });

    window.addEventListener('click', function(event){
        if (event.target === modal) modal.classList.remove('show');
    });
})();