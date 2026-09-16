# scharfdigital.de

Statische Webseite für **Scharf Digital** — Anton Scharf, Webseiten und Sichtbarkeit
für Solarteure und SHK-Betriebe.

Reines HTML, CSS und ein einziges kleines JavaScript (Mobil-Menü). Kein Framework,
kein Build-Prozess, kein npm. Die Dateien werden so, wie sie hier liegen, per FTP
hochgeladen und laufen sofort.

## Hochladen

Den kompletten Inhalt dieses Ordners in das Web-Verzeichnis des Hosters kopieren
(bei den meisten Anbietern `httpdocs/`, `public_html/` oder `www/`). Sonst nichts.

## Voraussetzungen beim Hoster

* PHP für `kontakt.php` (jede Version ab 8.0). Kann der Hoster kein PHP, muss das
  Formular auf einen DSGVO-konformen Dienst mit Serverstandort EU umgestellt und
  in der Datenschutzerklärung benannt werden.
* In `kontakt.php` steht `ABSENDER = formular@scharfdigital.de`. Diese Adresse muss
  beim Hoster existieren, sonst stufen viele Mailserver die Anfragen als Spam ein.
* HTTPS aktivieren und `http` dauerhaft auf `https` umleiten.

## Aufbau

```
index.html                      Startseite
webseiten/ seo/ geo/            Leistungsseiten (Webseiten, SEO, GEO)
branchen/solarteure/ shk/       Zielgruppenseiten
preise/ ueber-mich/ kontakt/    Preise, Person, Anfrage
impressum/ datenschutz/         Rechtstexte (ENTWURF)
danke/                          Bestätigung nach Formularversand (noindex)
assets/css/style.css            das einzige Stylesheet
assets/js/main.js               nur das Mobil-Menü
kontakt.php                     Formularverarbeitung
robots.txt sitemap.xml          Suchmaschinen und KI-Crawler
```

Header und Footer stehen in jeder Datei einzeln. Wer sie ändert, muss das in allen
zwölf HTML-Dateien tun — dafür gibt es keinen Build-Schritt, den jemand vergessen kann.

## Vor dem Livegang

1. Impressum und Datenschutzerklärung juristisch prüfen lassen (IHK Erfurt, für
   Gründer kostenlos). Beide Dateien tragen oben einen Entwurfs-Kommentar.
2. Umsatzsteuer-Angabe im Impressum ergänzen.
3. Hoster und Speicherdauer der Logfiles in der Datenschutzerklärung eintragen.
4. Portraitfoto einsetzen (Platzhalter auf `/` und `/ueber-mich/`).
5. In der Google Search Console die `sitemap.xml` einreichen.
