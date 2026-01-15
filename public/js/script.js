(function(){
  const modal = document.getElementById('modalUnique');
  if (!modal) return;

  // s'assurer que la modale est cachée au départ
  modal.classList.remove('show');

  const container = modal.querySelector('#contenuFormulaire');
    const selectors = '.open-modal-btn, .btn-remplir, .edit-link, .open-modal';

    document.querySelectorAll(selectors).forEach(btn => {
      btn.addEventListener('click', function(e){
        e.preventDefault();
        const type = btn.getAttribute('data-type') || 'identity';
        const container = modal.querySelector('#contenuFormulaire');
        if (!container) return;

        // masquer toutes les partials puis afficher celle demandée
        Array.from(container.children).forEach(child => child.style.display = 'none');
        const target = container.querySelector(`[data-type="${type}"]`);
        if (target) {
          target.style.display = '';
          modal.classList.add('show');
          // focus sur le premier champ du formulaire si présent
          const first = target.querySelector('input, select, textarea, button');
          if (first) first.focus();
        } else {
          container.innerHTML = '<p>Le formulaire demandé est indisponible.</p>';
          modal.classList.add('show');
        }
      });
    });

  

  // fermer en cliquant sur le backdrop (extérieur)
  window.addEventListener('click', (e) => {
    if (e.target === modal) modal.classList.remove('show');
  });
})();