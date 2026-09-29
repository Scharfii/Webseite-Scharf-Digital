/* Sprachumschalter Deutsch/Englisch.

   Die Seite ist auf Deutsch gebaut; Englisch ist eine Vorfuehrung. Die
   Uebersetzungen liegen in assets/i18n/en.json als Woerterbuch
   "deutscher Text" -> "englischer Text" und werden erst geladen, wenn
   jemand umschaltet. Wer nie auf EN klickt, laedt keine zusaetzliche Datei.

   Ersetzt werden Textknoten und die Attribute, die man sieht oder hoert.
   Die deutschen Fassungen bleiben im Speicher, damit das Zurueckschalten
   ohne Neuladen funktioniert. Eigene URLs je Sprache gibt es bewusst
   nicht — die deutsche Fassung bleibt die, die Google indexiert. */
(function () {
  'use strict';
  var SPEICHER = 'scharf-sprache';
  var ATTRIBUTE = ['placeholder', 'aria-label', 'title', 'alt', 'data-glanz'];
  var woerterbuch = null;
  var original = null;           // [{knoten, text}] bzw. [{el, attr, wert}]
  var aktiv = 'de';

  function sammeln() {
    var texte = [], attrs = [];
    var lauf = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
      acceptNode: function (n) {
        var p = n.parentNode;
        if (!p) return NodeFilter.FILTER_REJECT;
        var tag = p.nodeName.toLowerCase();
        if (tag === 'script' || tag === 'style' || p.closest('svg')) return NodeFilter.FILTER_REJECT;
        if (p.closest('[data-keine-uebersetzung]')) return NodeFilter.FILTER_REJECT;
        return n.nodeValue.trim() ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT;
      }
    });
    for (var n; (n = lauf.nextNode());) texte.push(n);
    ATTRIBUTE.forEach(function (a) {
      document.querySelectorAll('[' + a + ']').forEach(function (el) {
        if (el.closest('[data-keine-uebersetzung]')) return;
        attrs.push({ el: el, attr: a });
      });
    });
    return { texte: texte, attrs: attrs };
  }

  function anwenden(sprache) {
    var d = sammeln();
    if (!original) {
      original = {
        texte: d.texte.map(function (n) { return n.nodeValue; }),
        attrs: d.attrs.map(function (x) { return x.el.getAttribute(x.attr); }),
        titel: document.title
      };
    }
    if (sprache === 'de') {
      d.texte.forEach(function (n, i) { if (original.texte[i] != null) n.nodeValue = original.texte[i]; });
      d.attrs.forEach(function (x, i) { if (original.attrs[i] != null) x.el.setAttribute(x.attr, original.attrs[i]); });
      document.title = original.titel;
      document.documentElement.lang = 'de';
    } else {
      var uebersetze = function (roh) {
        if (roh == null) return null;
        // Leerraum am Rand merken und wieder anhaengen — sonst kleben Woerter
        // zusammen, wenn ein Textknoten mitten in einem Satz sitzt.
        var m = roh.match(/^(\s*)([\s\S]*?)(\s*)$/);
        var kern = m[2].replace(/\s+/g, ' ');
        var uebersetzt = woerterbuch[kern];
        return uebersetzt ? m[1] + uebersetzt + m[3] : null;
      };
      d.texte.forEach(function (n, i) {
        var neu = uebersetze(original.texte[i]);
        if (neu != null) n.nodeValue = neu;
      });
      d.attrs.forEach(function (x, i) {
        var neu = uebersetze(original.attrs[i]);
        if (neu != null) x.el.setAttribute(x.attr, neu);
      });
      if (woerterbuch[original.titel]) document.title = woerterbuch[original.titel];
      document.documentElement.lang = 'en';
    }
    aktiv = sprache;
    beschriftung();
    try { localStorage.setItem(SPEICHER, sprache); } catch (e) {}
  }

  function beschriftung() {
    document.querySelectorAll('[data-sprache-name]').forEach(function (el) {
      el.textContent = aktiv === 'de' ? 'Deutsch' : 'English';
    });
    document.querySelectorAll('[data-sprache-kurz]').forEach(function (el) {
      el.textContent = aktiv === 'de' ? 'DE' : 'EN';
    });
    document.querySelectorAll('[data-sprache-wahl]').forEach(function (el) {
      var ist = el.dataset.spracheWahl === aktiv;
      el.setAttribute('aria-checked', ist ? 'true' : 'false');
    });
  }

  function setzen(sprache) {
    if (sprache === aktiv) return;
    if (sprache === 'de') { anwenden('de'); return; }
    if (woerterbuch) { anwenden('en'); return; }
    fetch('/assets/i18n/en.json')
      .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
      .then(function (j) { woerterbuch = j; anwenden('en'); })
      .catch(function () {
        var m = document.querySelector('[data-sprache-fehler]');
        if (m) m.hidden = false;
      });
  }

  function menue() {
    var knopf = document.querySelector('[data-sprache-knopf]');
    var liste = document.querySelector('[data-sprache-liste]');
    if (!knopf || !liste) return;
    var offen = function (auf) {
      liste.hidden = !auf;
      knopf.setAttribute('aria-expanded', auf ? 'true' : 'false');
    };
    knopf.addEventListener('click', function (e) {
      e.stopPropagation();
      offen(liste.hidden);
    });
    liste.addEventListener('click', function (e) {
      var w = e.target.closest('[data-sprache-wahl]');
      if (!w) return;
      setzen(w.dataset.spracheWahl);
      offen(false);
      knopf.focus();
    });
    document.addEventListener('click', function () { offen(false); });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !liste.hidden) { offen(false); knopf.focus(); }
    });
  }

  function start() {
    menue();
    var gespeichert = null;
    try { gespeichert = localStorage.getItem(SPEICHER); } catch (e) {}
    if (gespeichert === 'en') setzen('en'); else beschriftung();
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start);
  else start();
})();
