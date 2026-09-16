# Livegang — Schritt für Schritt

**Stand:** 16.09.2026 · Ziel: diese Woche online, mit HTTPS, rechtlich sauber.

Diese Datei ist kein Ersatz für Rechts- oder Steuerberatung. Die beiden Punkte,
bei denen das zählt, sind unten markiert.

---

## Der Plan in vier Abenden

| Wann | Was | Dauer |
|---|---|---|
| Abend 1 | Domain + Hosting bestellen, E-Mail-Postfächer anlegen | 45 Min |
| Abend 2 | Gewerbe klären, Impressum und Datenschutz vervollständigen | 60 Min |
| Abend 3 | Dateien hochladen, SSL einschalten, alles durchtesten | 60 Min |
| Abend 4 | Search Console, Google Business Profil, Bing | 30 Min |

Laufende Kosten danach: rund 8 € im Monat fürs Hosting, 10–20 € im Jahr für die Domain.

---

## 1 — Domain und Hosting

**Empfehlung: All-Inkl, Paket „PrivatPlus", rund 8 € im Monat.**

Warum dieses: PHP 8 ist dabei (das Kontaktformular braucht es), SSL-Zertifikat
kostenlos und automatisch, Server in Deutschland, Domains im Paket enthalten,
deutscher Telefonsupport, und den Auftragsverarbeitungsvertrag (siehe 4.4)
bekommst du im Kundenmenü mit zwei Klicks.

Alternativen: **Netcup** (etwas billiger, etwas technischer), **IONOS**
(erstes Jahr günstig, danach deutlich teurer, Support schwächer).

**So gehst du vor:**

1. Bei All-Inkl zuerst die Domain prüfen: `scharf-digital.de`.
   Falls vergeben: `scharfdigital.de` oder `scharf-digital.com`.
2. Paket PrivatPlus bestellen, die Domain im Bestellformular direkt mitbestellen.
3. Bestellung mit deinem echten Namen und deiner echten Anschrift ausfüllen —
   diese Daten landen im Domain-Register.
4. Freischaltung dauert meist Minuten, spätestens Stunden. Du bekommst die
   Zugangsdaten fürs KAS (Kundenmenü) per Mail.

> **Wichtig:** Nimm **nicht** GitHub Pages, Netlify oder Vercel. Das
> Kontaktformular ist eine PHP-Datei. Auf diesen Diensten läuft kein PHP — das
> Formular würde still nichts tun. Das merkst du erst, wenn ein Interessent sich
> beschwert, dass er nie eine Antwort bekommen hat.

---

## 2 — Zwei E-Mail-Adressen anlegen

Im KAS unter *E-Mail → E-Mail-Postfach → Neues Postfach*:

| Adresse | Wofür |
|---|---|
| `anton@scharf-digital.de` | Deine Geschäftsadresse. Steht auf der Seite, im Impressum, auf Rechnungen. |
| `formular@scharf-digital.de` | Absender der Formular-Mails. Muss als echtes Postfach existieren. |

**Warum die zweite Adresse nötig ist:** Der Server verschickt die Formular-Mail
im Namen von `formular@scharf-digital.de`. Existiert diese Adresse nicht auf der
Domain, scheitert die SPF-Prüfung und Gmail oder Outlook werfen die Mail weg
oder schieben sie in den Spam. Das ist der häufigste Grund, warum
Kontaktformulare „nicht funktionieren".

`anton@` leitest du im KAS entweder auf deine bisherige Adresse weiter oder du
richtest sie in deiner Mail-App ein (die IMAP-Daten stehen im KAS).

---

## 3 — Deine alte Adresse ersetzen

`antonlorenzscharf@gmail.com` steht noch an mehreren Stellen im Projekt:

- `kontakt.php`, Zeile 12 (`EMPFAENGER`)
- `impressum/index.html` — zweimal
- `datenschutz/index.html`
- `kontakt/index.html` — der sichtbare Kontaktblock
- in allen zwölf Seiten im JSON-LD-Block (`"email"`)

Sag mir die endgültige Adresse, dann ersetze ich das in einem Durchgang. Von
Hand übersieht man garantiert eine Stelle, und ausgerechnet die strukturierten
Daten liest Google aus.

---

## 4 — Rechtliches

### 4.1 Gewerbeanmeldung

Vor der ersten Rechnung. In Erfurt beim Bürgeramt/Gewerbeamt, rund 20–30 €,
das Formular ist eine Seite. Als Tätigkeit reicht: *„Erstellung von Webseiten
und Suchmaschinenoptimierung"*.

Danach schickt dir das Finanzamt den *Fragebogen zur steuerlichen Erfassung*.
Dort entscheidest du die Frage aus 4.2.

> Falls du noch nicht 18 bist: Dann braucht es die Zustimmung der
> Erziehungsberechtigten und eine Genehmigung des Familiengerichts. Ruf vorher
> beim Gewerbeamt an, das klärt sich in fünf Minuten am Telefon.

### 4.2 Kleinunternehmer oder nicht — das entscheidet eine Zeile im Impressum

**Kleinunternehmerregelung (§ 19 UStG):** möglich, solange du im ersten Jahr
unter 22.000 € Umsatz bleibst. Du weist dann keine Umsatzsteuer aus und musst
auch keine abführen — darfst sie aber auch nicht auf Rechnungen schreiben.

Zeile fürs Impressum:
> Kleinunternehmer im Sinne von § 19 UStG. Es wird keine Umsatzsteuer berechnet und ausgewiesen.

**Regelbesteuerung:** Du bekommst eine USt-IdNr. und weist 19 % aus.

Zeile fürs Impressum:
> Umsatzsteuer-Identifikationsnummer gemäß § 27a UStG: DE123456789

**Zum Nachdenken:** Bei 2.500 € pro Webseite bist du nach neun Webseiten an der
22.000-€-Grenze. Wenn du damit rechnest, sie im ersten Jahr zu reißen, ist
Regelbesteuerung von Anfang an unkomplizierter als ein Wechsel mitten im Jahr.
**Das ist keine Steuerberatung.** Die IHK Erfurt macht dazu eine kostenlose
Gründerberatung — eine Stunde, und genau diese Frage ist ihr Standardthema.

### 4.3 Impressum vervollständigen

In `impressum/index.html` steht noch ein Platzhalter:

```
[UMSATZSTEUER-ID ODER HINWEIS AUF KLEINUNTERNEHMERREGELUNG § 19 UStG — vom Betreiber zu ergänzen]
```

Der muss vor dem Livegang durch eine der beiden Zeilen aus 4.2 ersetzt werden.
Ein unvollständiges Impressum ist der häufigste Abmahngrund bei neuen
Geschäftsseiten — und du verkaufst an Betriebe, die selbst darauf achten.

Prüfe außerdem: `Am Eselsgraben 14, 99094 Erfurt` muss eine ladungsfähige
Anschrift sein, also eine, unter der dich Post tatsächlich erreicht. Ein
Postfach genügt nicht.

### 4.4 Datenschutz — ein Vertrag und zwei Platzhalter

**Der Vertrag:** Mit dem Hoster brauchst du einen
Auftragsverarbeitungsvertrag nach Art. 28 DSGVO. Bei All-Inkl findest du ihn im
KAS unter *Tools → AV-Vertrag*: annehmen, PDF ablegen. Zwei Minuten. Nötig ist
er, weil der Hoster in deinem Auftrag die IP-Adressen deiner Besucher
verarbeitet.

**Die Platzhalter** in `datenschutz/index.html`:

```
[HOSTER UND SPEICHERDAUER EINTRAGEN — vom Betreiber zu ergänzen]
[AUFTRAGSVERARBEITUNGSVERTRAG BESTÄTIGEN — vom Betreiber zu ergänzen]
```

Ersetzen durch Name und Anschrift deines Hosters und die tatsächliche
Löschfrist der Logfiles. Beides steht in den Datenschutzhinweisen des Hosters —
lies es dort ab, rate es nicht.

**Was du dagegen nicht mehr brauchst:** Die Seite setzt keine Cookies, nutzt
kein Tracking und lädt seit heute auch keine Schriften mehr von Google — die
liegen jetzt auf deinem eigenen Server. Damit brauchst du **kein
Cookie-Banner**, und der mit Abstand häufigste Abmahngrund der letzten Jahre
(Google Fonts, Urteil LG München 2022) ist vom Tisch.

### 4.5 Einmal drüberschauen lassen

Impressum und Datenschutz sind von mir als Entwurf geschrieben, nicht juristisch
geprüft. Vor dem Livegang einmal prüfen lassen: IHK-Gründerberatung (kostenlos)
oder ein Anwalt für IT-Recht (150–300 €). Bei deinem Geschäftsmodell ist das
gut angelegt.

---

## 5 — Von GitHub auf den Server

GitHub ist deine Sicherung und dein Verlauf. Es ist hier **nicht** der Webhoster.

### 5.1 Den Stand auf `main` bringen

Die Arbeit liegt auf dem Zweig `claude/awesome-lamport-6kzptf`. Auf
github.com/Scharfii/Webseite-Scharf-Digital:

1. *Pull requests → New pull request*, base: `main`, compare: `claude/awesome-lamport-6kzptf`
2. *Create pull request* → *Merge pull request* → *Confirm merge*

Danach steht alles auf `main`. Sag Bescheid, dann lege ich den Pull Request an.

### 5.2 Herunterladen

Grüner Knopf *Code → Download ZIP*, entpacken. Oder du nimmst das ZIP, das ich
dir geschickt habe — gleicher Inhalt.

### 5.3 Per FTP hochladen

- **Programm:** FileZilla (kostenlos, filezilla-project.org — „FileZilla Client", nicht Server)
- **Zugangsdaten:** im KAS unter *FTP → FTP-Zugänge*
- **Server:** der in KAS angezeigte Name, **Port 21**, Verschlüsselung
  *„Explizites FTP über TLS"*
- Rechts in den Ordner deiner Domain wechseln. Bei All-Inkl ist das meist direkt
  `/`, bei anderen Hostern `httpdocs`, `public_html` oder `www`.
- Dann den **Inhalt** des entpackten Ordners hinüberziehen: `index.html`,
  `assets`, `kontakt.php`, `.htaccess` und alle Unterordner.

> **Zwei typische Fehler:**
>
> 1. Du ziehst den *Ordner* statt seines *Inhalts* hinüber. Dann liegt die Seite
>    unter `scharf-digital.de/Webseite-Scharf-Digital/`. Merkst du sofort.
> 2. `.htaccess` fehlt. FileZilla blendet Dateien mit führendem Punkt
>    standardmäßig aus — unter *Server → „Anzeige versteckter Dateien
>    erzwingen"* einschalten. Ohne diese Datei gibt es keine
>    HTTPS-Weiterleitung.

---

## 6 — HTTPS einschalten

Im KAS: *Domain → deine Domain → SSL-Schutz → Let's Encrypt* → speichern.
Kostenlos, verlängert sich selbst, ist nach ein paar Minuten aktiv.

Die `.htaccess` im Projekt erledigt den Rest: Jeder Aufruf über `http://` und
jeder über `www.` wird per 301 auf `https://scharf-digital.de/…` umgeleitet.
Das ist nicht nur Sicherheit, sondern auch SEO — sonst zählt Google jede
Variante als eigene Seite.

**Test:** `http://scharf-digital.de` und `http://www.scharf-digital.de` aufrufen.
Beide müssen bei `https://scharf-digital.de` mit Schloss-Symbol landen.

**HSTS erst später.** In der `.htaccess` ist die Zeile
`Strict-Transport-Security` auskommentiert. Schalte sie frühestens nach ein paar
Tagen stabilem Betrieb frei. Wenn HTTPS danach kaputtgeht, weigern sich Browser
ein Jahr lang, die Seite überhaupt zu öffnen.

---

## 7 — Testen nach dem Hochladen

1. Jede Seite einmal aufrufen: `/`, `/webseiten/`, `/seo/`, `/geo/`, `/preise/`,
   `/branchen/solarteure/`, `/branchen/shk/`, `/ueber-mich/`, `/kontakt/`,
   `/impressum/`, `/datenschutz/`
2. **Das Kontaktformular an dich selbst abschicken.** Ausfüllen wie ein Kunde.
   Die Mail muss ankommen und du musst auf `/danke/` landen. Kommt nichts:
   erst Spam-Ordner, dann prüfen, ob `formular@…` als Postfach existiert (Teil 2).
3. Das Formular einmal mit leerem Feld „Betrieb" abschicken — es muss die
   Fehlerseite im Design kommen, keine weiße Seite.
4. Auf dem Handy öffnen. Unten muss die Leiste mit „Anrufen" und
   „Analyse anfordern" stehen.
5. Den Link an dich selbst über WhatsApp schicken — das Vorschaubild muss
   erscheinen. Das machst du nach jedem Telefonat, es muss sitzen.
6. `pagespeed.web.dev` aufrufen, deine URL eintragen. Du verkaufst genau das —
   die Werte sollten grün sein.

---

## 8 — Google (am Tag danach)

1. **Search Console** (`search.google.com/search-console`): Property vom Typ
   *Domain* anlegen, den angezeigten TXT-Eintrag im KAS unter DNS hinterlegen,
   bestätigen. Danach unter *Sitemaps* eintragen:
   `https://scharf-digital.de/sitemap.xml`
2. **Google Business Profil** (`business.google.com`): Du verkaufst die
   Einrichtung solcher Profile und hast selbst keins. Kategorie „Webdesigner".
   Wenn du keine Kunden zu Hause empfangen willst: Einzugsgebiet angeben statt
   Ladenadresse.
3. **Bing Webmaster Tools**: übernimmt die Search-Console-Daten mit zwei Klicks.
   Bing versorgt die Websuche von ChatGPT — für dein GEO-Argument relevant.

---

## 9 — Was bis nächste Woche warten kann

- **Dein Foto.** Der einzige echte Platzhalter im Design.
- Eine 404-Seite.
- Die Vorlage für die Sichtbarkeits-Analyse. Deine Seite verspricht sie an jeder
  Stelle — es gibt sie bisher nicht. Das ist wichtiger als jede weitere Unterseite.
- Eigene Portal-Einträge, erste Bewertungen.

---

## Was ich sofort übernehmen kann

- Die E-Mail-Adresse an allen Stellen ersetzen (sag mir welche)
- Impressum- und Datenschutztexte einsetzen, sobald du Kleinunternehmer ja/nein
  entschieden und den Hoster gewählt hast
- Den Pull Request auf `main` anlegen
- Eine 404-Seite bauen
