/* Scharf Digital — nur auf der Kontaktseite.
   Ohne JavaScript wird das Formular ganz normal abgeschickt; dieses Skript
   sorgt lediglich dafuer, dass der Besucher bei einem Problem nicht auf einer
   Fehlerseite landet, sondern mit seinen Eingaben auf der Seite bleibt. */
(function () {
  var form = document.querySelector('form.form');
  var box  = document.querySelector('[data-fehler]');
  if (!form || !box) return;

  var TELEFON = 'Die Nachricht konnte gerade nicht versendet werden. Rufen Sie mich bitte kurz an: 01522 4610099.';
  var PFLICHT = 'Bitte füllen Sie Betrieb, Ort und Kontakt aus und bestätigen Sie die Einwilligung.';
  var knopf   = form.querySelector('button[type="submit"]');
  var text    = knopf ? knopf.textContent : '';

  function zeigen(meldung) {
    box.textContent = meldung;
    box.hidden = false;
    box.scrollIntoView({ block: 'center' });
    if (knopf) { knopf.disabled = false; knopf.textContent = text; }
  }

  // Ein PHP-Hoster haengt bei Problemen ?fehler=1 oder ?fehler=2 an.
  var fehler = new URLSearchParams(location.search).get('fehler');
  if (fehler) zeigen(fehler === '2' ? TELEFON : PFLICHT);

  if (!window.fetch) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    box.hidden = true;
    if (knopf) { knopf.disabled = true; knopf.textContent = 'Wird gesendet …'; }

    // Netlify erkennt das Formular am Feld form-name. Dokumentiert ist der
    // POST auf "/", manche Aufbauten brauchen den Pfad der Seite - deshalb
    // beides nacheinander. Ein PHP-Skript bekommt ihn direkt.
    var daten = new URLSearchParams(new FormData(form)).toString();
    var wege = /\.php$/.test(form.getAttribute('action') || '')
      ? [form.action]
      : ['/', location.pathname];

    function senden(i) {
      return fetch(wege[i], {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: daten
      }).then(function (antwort) {
        if (!antwort.ok) {
          if (i + 1 < wege.length) return senden(i + 1);
          throw new Error(String(antwort.status));
        }
        var f = (String(antwort.url).match(/fehler=(\d)/) || [])[1];
        if (f) { zeigen(f === '2' ? TELEFON : PFLICHT); return; }
        location.assign('/danke/');
      });
    }

    senden(0).catch(function () { zeigen(TELEFON); });
  });
})();
