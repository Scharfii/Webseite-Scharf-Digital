/* Scharf Digital — das einzige JavaScript der Seite: das Mobil-Menü.
   Alle Inhalte stehen im HTML und sind ohne JavaScript lesbar. */
(function () {
  var toggle = document.querySelector('.burger');
  var menu = document.getElementById('nav-mobile');
  if (!toggle || !menu) return;

  function setOpen(open) {
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? 'Menü schließen' : 'Menü öffnen');
    menu.classList.toggle('is-open', open);
    document.body.classList.toggle('nav-open', open);
    // Das geschlossene Menü darf nicht in der Tab-Reihenfolge liegen -
    // sonst landet der Fokus während der Schließ-Animation auf einem
    // Link, den der Nutzer nicht sieht.
    menu.inert = !open;
  }

  menu.inert = true;

  toggle.addEventListener('click', function () {
    setOpen(toggle.getAttribute('aria-expanded') !== 'true');
  });

  menu.addEventListener('click', function (e) {
    if (e.target.closest('a')) setOpen(false);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
      setOpen(false);
      toggle.focus();
    }
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth > 900) setOpen(false);
  });
})();
