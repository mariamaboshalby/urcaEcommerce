/**
 * urca Admin JS
 */
(function () {
  'use strict';

  const sidebar  = document.getElementById('admSidebar');
  const overlay  = document.getElementById('admOverlay');
  const toggleBtn = document.getElementById('admToggleBtn');
  const closeBtn  = document.getElementById('admSidebarClose');

  function openSidebar() {
    sidebar?.classList.add('active');
    overlay?.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar?.classList.remove('active');
    overlay?.classList.remove('active');
    document.body.style.overflow = '';
  }

  toggleBtn?.addEventListener('click', openSidebar);
  closeBtn?.addEventListener('click', closeSidebar);
  overlay?.addEventListener('click', closeSidebar);

  // Auto-dismiss alerts
  const alert = document.getElementById('admAlert');
  if (alert) {
    setTimeout(() => {
      alert.style.transition = 'opacity .4s ease';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 400);
    }, 4000);
  }

  // Confirm delete
  document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', e => {
      if (!confirm(btn.dataset.confirm || 'هل أنت متأكد؟')) e.preventDefault();
    });
  });

  // Specs rows
  const addSpecBtn = document.getElementById('addSpecBtn');
  const specsContainer = document.getElementById('specsContainer');

  if (addSpecBtn && specsContainer) {
    addSpecBtn.addEventListener('click', () => {
      const row = document.createElement('div');
      row.className = 'spec-row';
      row.innerHTML = `
        <input type="text" name="specs[]" class="form-control" placeholder="مثال: السرعة: 40 صفحة/دقيقة">
        <button type="button" class="btn btn-danger btn-sm remove-spec"><i class="fas fa-trash"></i></button>
      `;
      specsContainer.appendChild(row);
      row.querySelector('.remove-spec').addEventListener('click', () => row.remove());
    });

    specsContainer.querySelectorAll('.remove-spec').forEach(btn => {
      btn.addEventListener('click', () => btn.closest('.spec-row').remove());
    });
  }

})();
