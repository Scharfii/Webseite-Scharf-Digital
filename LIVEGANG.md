# Livegang — Schritt für Schritt

**Stand:** 25.09.2026 · Hosting: Netlify · E-Mail: iCloud+ · Kleinunternehmer nach § 19 UStG
**Gewerbe angemeldet am 22.09.2026, Beginn der Tätigkeit 01.10.2026.**

Keine Rechts- oder Steuerberatung. Die zwei Stellen, an denen das zählt, sind unten markiert.

---

## Was das kostet

| | einmalig | laufend |
|---|---|---|
| Gewerbeanmeldung Erfurt | 0 € (erledigt, gebührenfrei) | — |
| Fragebogen beim Finanzamt (ELSTER) | 0 € | — |
| IHK-Mitgliedschaft | 0 € | in deiner Größe meist beitragsfrei, siehe 3.3 |
| Domain `scharfdigital.de` | — | 5–15 € im Jahr |
| Netlify Hosting | — | 0 € (kostenloses Kontingent reicht deutlich) |
| iCloud+ für die eigene E-Mail-Adresse | — | rund 12 € im Jahr |

**Rund 2 € im Monat.** Das ist der ganze Kostenblock, um online zu sein.

---

## 1 — Domain kaufen (15 Min)

Netlify ist dein Hoster, aber die Domain kaufst du woanders — für `.de`-Domains
ist ein deutscher Anbieter einfacher und billiger.

**Empfehlung: INWX oder netcup.** Beide rund 5–10 € im Jahr für `.de`, beide mit
vollständiger DNS-Verwaltung, die du gleich brauchst. Finger weg von Anbietern,
die dir DNS-Einträge nicht selbst bearbeiten lassen.

1. `scharfdigital.de` prüfen. Falls vergeben: `scharfdigital.de` oder
   `scharfdigital.de`. **Sag mir Bescheid, wenn es eine andere wird** — die
   Adresse steht an rund 40 Stellen im Projekt (canonical-Tags, Sitemap,
   robots.txt, strukturierte Daten) und muss überall stimmen.
2. Mit echtem Namen und echter Anschrift bestellen. Diese Daten landen im
   Register der DENIC.
3. Domain-Datenschutz (Whois-Privacy) brauchst du bei `.de` nicht — die DENIC
   veröffentlicht die Daten von Privatpersonen ohnehin nicht.

---

## 2 — Auf Netlify veröffentlichen (20 Min)

### 2.1 Den Stand auf `main` bringen

Die Arbeit liegt auf dem Zweig `claude/awesome-lamport-6kzptf`. Auf
github.com/Scharfii/Webseite-Scharf-Digital:

*Pull requests → New pull request*, base `main`, compare `claude/awesome-lamport-6kzptf`
→ *Create pull request* → *Merge pull request* → *Confirm merge*.

Sag Bescheid, dann lege ich den Pull Request an.

### 2.2 Seite anlegen

In Netlify: *Add new site → Import an existing project → GitHub →
Scharfii/Webseite-Scharf-Digital*.

| Feld | Wert |
|---|---|
| Branch to deploy | `main` |
| Build command | **leer lassen** |
| Publish directory | `.` (steht schon in `netlify.toml`) |

*Deploy site.* Nach etwa einer Minute ist die Seite unter einer Adresse wie
`zufallsname.netlify.app` erreichbar. Ab hier veröffentlicht jeder Push auf
`main` automatisch — kein FTP, kein Hochladen von Hand.

### 2.3 Domain verbinden

*Site configuration → Domain management → Add a domain* → `scharfdigital.de`.

Netlify schlägt dir *Netlify DNS* vor. **Nimm das.** Du bekommst vier
Nameserver angezeigt; die trägst du bei deinem Domain-Anbieter als Nameserver
ein. Danach verwaltest du alle DNS-Einträge bei Netlify — auch die für iCloud
aus Teil 3, das ist gleich einfacher.

Umstellung dauert je nach Anbieter Minuten bis wenige Stunden.

### 2.4 HTTPS

Passiert von allein. Sobald die Domain verbunden ist, stellt Netlify ein
Let's-Encrypt-Zertifikat aus und leitet `http://` und `www.` auf
`https://scharfdigital.de` um. Unter *Domain management → HTTPS* kannst du
nachsehen, ob das Zertifikat da ist. Erst dann Links verschicken.

> Die `.htaccess` im Projekt macht auf Netlify nichts — sie liegt nur dabei,
> falls die Seite später auf einen deutschen Apache-Hoster umzieht. Für Netlify
> gilt `netlify.toml`.

### 2.5 Das Kontaktformular scharf schalten

Das ist der Teil, der neu ist: **Auf Netlify läuft kein PHP.** Ich habe das
Formular deshalb auf *Netlify Forms* umgebaut — das ist in Netlify eingebaut,
kostet nichts und braucht keinen Fremddienst.

1. *Site configuration → Forms*: prüfen, dass **Form detection aktiviert** ist.
   Falls nicht: einschalten und einmal neu deployen (*Deploys → Trigger deploy*).
2. Im Reiter **Forms** muss nach dem Deploy ein Formular namens **`anfrage`**
   auftauchen. Wenn nicht, ist die Erkennung aus — siehe Schritt 1.
3. *Forms → Form notifications → Add notification → Email notification*:
   deine Adresse eintragen. **Anfangs ruhig deine `@icloud.com`-Adresse** —
   dann funktioniert das Formular sofort, auch bevor die eigene Domain-Adresse
   aus Teil 3 fertig ist. Später umstellen.
4. **reCAPTCHA nicht einschalten.** Netlify bietet das an — es würde Google
   wieder auf deine Seite holen und dir die Datenschutzerklärung kaputtmachen.
   Das unsichtbare Honeypot-Feld im Formular reicht.

Kostenloses Kontingent: 100 Einsendungen im Monat. Für den Anfang reichlich.

---

## 3 — E-Mail über iCloud+ (20 Min)

Du willst `anton@scharfdigital.de` statt einer privaten Adresse. Mit iCloud+
geht das direkt.

1. **iCloud+ buchen**, falls noch nicht vorhanden: iPhone → Einstellungen →
   dein Name → iCloud → *Speicher aktualisieren*. Der kleinste Tarif (50 GB,
   rund 1 € im Monat) reicht.
2. **Domain hinzufügen:** `iCloud.com` → Einstellungen → *Benutzerdefinierte
   E-Mail-Domain* → *Domain hinzufügen* → „Nur von dir verwendet" →
   `scharfdigital.de` eintragen.
3. **Adresse anlegen:** `anton@scharfdigital.de`.
4. Apple zeigt dir jetzt eine Liste DNS-Einträge (zwei MX, ein TXT für SPF,
   zwei CNAME für DKIM, ein TXT zur Bestätigung). Diese Einträge legst du bei
   **Netlify unter Domain management → DNS records** an — genau so, wie Apple
   sie anzeigt.
5. Zurück bei Apple auf *Überprüfen*. Kann ein paar Minuten bis Stunden dauern.

Danach schreibst und empfängst du aus der normalen Mail-App unter der neuen
Adresse. **Stell sie als Standard-Absender ein**, sonst verschickst du
weiterhin von `@icloud.com`.

---

## 4 — Rechtliches

### 4.1 Gewerbeanmeldung — erledigt am 22.09.2026

Bescheinigt nach § 15 Abs. 1 GewO, Gebühr 0,00 €. Angemeldet ist:

> Erstellung, Gestaltung und technische Umsetzung von Webseiten sowie damit
> verbundene digitale Dienstleistungen

Nebenerwerb · Hauptniederlassung · Neugründung · keine Mitarbeiter.

**Beginn der Tätigkeit: 01.10.2026.** Das ist das Datum, ab dem du abrechnen
darfst. Keine Rechnung mit einem früheren Datum — Gespräche führen, Angebote
schreiben und die Webseite bewerben darfst du vorher.

Daraus folgen drei Dinge, zwei davon mit Frist:

| Was | Bis wann | Kosten |
|---|---|---|
| Fragebogen zur steuerlichen Erfassung über ELSTER | 01.11.2026 | 0 € |
| Berufsgenossenschaft (VBG) | erledigt, kam von allein | 0 € ohne Mitarbeiter |
| IHK-Mitgliedschaft | läuft automatisch an | siehe 4.3 |

#### Fragebogen zur steuerlichen Erfassung — heute mit ELSTER anfangen

Pflicht, elektronisch, **innerhalb eines Monats nach Beginn der Tätigkeit**
(§ 138 AO) — also bis zum 01.11.2026. Das Finanzamt schickt dir keine
Aufforderung, auf die du warten könntest; du musst von dir aus einreichen.

Der Haken liegt nicht im Formular, sondern im Konto: Der Aktivierungscode für
ELSTER kommt **per Brief und kann bis zu zwei Wochen dauern**. Danach vergehen
noch einmal **zwei bis sechs Wochen, bis deine Steuernummer da ist**.

Das ist der kritische Pfad, denn: Seit 2025 muss auch auf einer
Kleinunternehmer-Rechnung die **Steuernummer** stehen (§ 34a UStDV). Ohne
Steuernummer kannst du keine gültige Rechnung über 2.000 € schreiben. Wenn im
Oktober der erste Auftrag kommt und du erst dann anfängst, wartest du im
schlimmsten Fall bis Dezember auf dein Geld.

**Reihenfolge:** ELSTER-Konto heute anlegen → Code abwarten → Fragebogen
ausfüllen → beim Kreuz *Kleinunternehmerregelung nach § 19 UStG* bleiben.

#### Berufsgenossenschaft — erledigt, ohne dein Zutun

Das Gewerbeamt hat die Anmeldung weitergeleitet. Die **VBG** (Verwaltungs-
Berufsgenossenschaft, Standort Erfurt) hat sich am 24.09.2026 von selbst
gemeldet und zwei Schreiben geschickt:

1. **Willkommensschreiben** mit deiner Unternehmensnummer — die Nummer steht
   im Brief, nicht hier im Repo.
2. **Bescheid über die Zuständigkeit nach § 136 SGB VII**: Mit Wirkung vom
   01.10.2026 gehört dein Unternehmen der VBG an.

**Beiträge fallen nicht an**, solange du niemanden beschäftigst. Meldepflicht
besteht erst, wenn du erstmals jemanden einstellst — dann innerhalb von vier
Wochen.

Gegen den Bescheid kannst du binnen eines Monats Widerspruch einlegen. Das ist
hier nicht sinnvoll: Die VBG ist für Webdesign die richtige
Berufsgenossenschaft. Frist einfach verstreichen lassen.

**Was du machen kannst:** Das Portal „meine VBG" einrichten
(vbg.de/registrierung), sobald die Legitimierungs-ID per Post kommt. Dann läuft
die Behördenpost digital statt auf Papier.

#### Offene Entscheidung: Freiwillige Unternehmerversicherung

Als Selbstständiger bist du bei der VBG **nicht automatisch unfallversichert** —
die Pflichtversicherung gilt für Beschäftigte, nicht für dich. Die freiwillige
Unternehmerversicherung schließt diese Lücke.

**Zahlen für 2026:** Mindestversicherungssumme 28.476 €, Beitrag darauf je nach
Gefahrklasse etwa 85 bis 440 € im Jahr. Büroarbeit ist die niedrigste
Gefahrklasse, du liegst also voraussichtlich am unteren Ende. Die genaue Zahl
nennt dir die VBG am Telefon (0361 2236444).

**Wofür es bei dir spricht:** Du fährst zu Kundenterminen — so steht es auf
`/webdesign-erfurt/`. Ein Unfall auf dem Weg nach Jena oder Gotha wäre über die
gesetzliche Unfallversicherung gedeckt, über die Krankenkasse nur die
Heilbehandlung, nicht der Verdienstausfall.

**Was dagegen spricht:** Eine private Unfallversicherung gilt rund um die Uhr,
nicht nur bei der Arbeit. Und wer am Anfang des Berufslebens steht, ist
statistisch mit einer Berufsunfähigkeitsversicherung besser bedient, weil die
meisten Fälle Krankheiten sind und keine Unfälle.

**Keine Versicherungsberatung.** Nimm die Frage mit in den IHK-Termin am 09.10.

#### Zwei Punkte für den IHK-Termin am 09.10.

1. **Feld 21 der Anmeldung:** Angekreuzt sind *Handel* und *Sonstiges*.
   Webdesign ist eine Dienstleistung, *Sonstiges* allein hätte gereicht. Kein
   Problem und formlos änderbar, aber es beeinflusst, in welche Sparte dich die
   IHK einsortiert. Sprich es an.
2. **Nebenerwerb und Krankenversicherung:** Solange die Selbstständigkeit
   nebenberuflich bleibt, ändert sich an deiner Krankenversicherung in der
   Regel nichts. Lass dir bestätigen, ab welchem Punkt das kippt — bei Stunden
   und Einkommen gibt es Grenzen, und die kennt die IHK-Beratung.

### 4.2 Kleinunternehmer nach § 19 UStG — ist eingetragen

Im Impressum steht jetzt:

> Kleinunternehmer im Sinne von § 19 UStG. Es wird keine Umsatzsteuer berechnet und ausgewiesen.

**Was das für dich heißt:**

- Du weist auf Rechnungen **keine** Umsatzsteuer aus und führst keine ab.
  Auf der Rechnung steht stattdessen der Hinweis auf § 19 UStG.
- Du darfst im Gegenzug keine Vorsteuer ziehen — die 19 % auf Hosting, Software
  und Technik sind für dich echte Kosten.
- **Seit 2025 gelten zwei Grenzen: 25.000 € im Vorjahr und 100.000 € im
  laufenden Jahr.** Für dich als Neugründer zählt zunächst die 25.000 €. Bei
  2.000 € pro Webseite bist du nach dreizehn Webseiten dran, mit laufender
  Betreuung deutlich früher. Überschreitest du 25.000 €, wirst du **ab dem
  Folgejahr** umsatzsteuerpflichtig. Überschreitest du im laufenden Jahr
  100.000 €, endet die Regelung **sofort**, ab genau dem Umsatz, der die
  Grenze reißt.
- Für deine Kunden ist das meist egal: Handwerksbetriebe sind selbst
  vorsteuerabzugsberechtigt, ihnen ist der Bruttopreis gleich.

**Das ist keine Steuerberatung.** Wenn du damit rechnest, im ersten Jahr über
25.000 € zu kommen, sprich das in der kostenlosen Gründerberatung der IHK
Erfurt an — ein Wechsel mitten im Geschäftsjahr ist unangenehmer als von Anfang
an Regelbesteuerung.

### 4.3 IHK — Pflicht, aber wahrscheinlich kostenlos

**Beratungstermin steht: 09.10.2026.** Nimm die Gewerbeanmeldung, die Adresse
der Webseite und die Angebotsvorlage mit.

Mit der Gewerbeanmeldung bist du seit dem 22.09.2026 automatisch IHK-Mitglied. Das erschreckt
viele Gründer, ist aber in deiner Größe in der Regel beitragsfrei: Wer nicht im
Handelsregister steht und unter den gesetzlichen Freigrenzen bleibt, zahlt
keinen Grundbeitrag, und in den ersten Jahren nach der Gründung gibt es
zusätzliche Befreiungen. Die IHK Erfurt sagt dir am Telefon in zwei Minuten,
was für dich gilt — und die Gründerberatung ist ohnehin kostenlos.

### 4.4 Datenschutz — was ich schon eingetragen habe

In `datenschutz/index.html` steht jetzt:

- **Hosting-Anbieter:** Netlify, Inc., San Francisco, USA, mit
  Auftragsverarbeitungsvertrag nach Art. 28 DSGVO und Standardvertragsklauseln
  nach Art. 46 DSGVO für die Übermittlung in die USA.
- **Kontaktformular:** läuft über Netlify Forms, dieselbe Grundlage.

**Was du dazu noch tun musst:** Netlifys Auftragsverarbeitungsvertrag (Data
Processing Addendum) einmal ansehen und als PDF ablegen. Er ist Bestandteil der
Nutzungsbedingungen; im Netlify-Konto findest du ihn unter den rechtlichen
Dokumenten. Du musst nachweisen können, dass er existiert.

> **Der ehrliche Hinweis:** Netlify ist ein US-Unternehmen. Das ist mit
> Auftragsverarbeitungsvertrag und Standardvertragsklauseln zulässig, aber es
> ist Papierkram, den du bei einem deutschen Hoster nicht hättest — und du
> verlierst das Verkaufsargument „Ihre Daten liegen in Deutschland", das bei
> Handwerksbetrieben zieht. Für den Start diese Woche ist Netlify die richtige
> Wahl: kostenlos, sofort, kein FTP. Wenn das Geschäft läuft, ist ein Umzug auf
> einen deutschen Hoster ein Nachmittag Arbeit. Die PHP-Version des Formulars
> liegt dafür weiterhin im Repository.

**Was du nicht brauchst:** Kein Cookie-Banner. Die Seite setzt keine Cookies,
nutzt kein Tracking und lädt die Schriften vom eigenen Server — die häufigste
Abmahnfalle (Google Fonts) ist damit erledigt.

### 4.5 Einmal prüfen lassen — so erreichst du die IHK

Impressum und Datenschutzerklärung sind von mir als Entwurf geschrieben und
nicht juristisch geprüft. Solange das so ist, steht auf beiden Seiten ein
sichtbarer Hinweis darauf. Der kommt weg, sobald jemand draufgeschaut hat.

**IHK Erfurt — Gründungsberatung, kostenlos**

- Arnstädter Straße 34, 99096 Erfurt
- Telefon **0361 3484-0**
- info@erfurt.ihk.de
- Öffnungszeiten: Mo–Do 8:00–17:00, Fr 8:00–14:30
- Terminvereinbarung und Infos: ihk.de/erfurt → Service → Existenzgründung

**Was du beim Anruf sagst:** „Ich habe mein Gewerbe angemeldet, bin
Einzelunternehmer im Bereich Webseiten und Suchmaschinenoptimierung und
möchte einen Termin zur Gründungsberatung. Ich habe Fragen zur
Kleinunternehmerregelung, zum IHK-Beitrag und hätte gern, dass jemand
einmal über Impressum und Datenschutzerklärung meiner Webseite schaut."

**Was du mitbringst:** die Gewerbeanmeldung, die Adresse deiner Webseite,
und die Frage, ob du im ersten Jahr über 25.000 € Umsatz kommst.

Die IHK macht keine Rechtsberatung im engeren Sinn. Für eine belastbare
Prüfung von Impressum und Datenschutz ist ein Anwalt für IT-Recht der
sichere Weg (150–300 €). Die IHK findet aber die offensichtlichen Lücken
und kostet nichts — für den Anfang reicht das meistens.

---

## 5 — Testen, bevor du den ersten Link verschickst

1. Alle zwölf Seiten einmal aufrufen.
2. Eine erfundene Adresse aufrufen, etwa `/gibtesnicht/` — es muss die
   404-Seite im Design kommen.
3. **Das Formular an dich selbst abschicken.** Es muss unter *Forms → anfrage*
   in Netlify auftauchen **und** die Benachrichtigungs-Mail muss ankommen.
   Danach musst du auf `/danke/` landen. Dazu vier kurze Gegenproben:
   - Ein Pflichtfeld leer lassen → der Browser meckert, es wird nichts gesendet.
   - Auf der Dankeseite F5 drücken → es darf keine zweite Anfrage entstehen.
   - Umlaute testen, etwa „Grüne Wärmetechnik Gößnitz" → muss in der Mail
     richtig ankommen, nicht als `GrÃ¼ne`.
   - Landet die Mail im Spam, ist die Sache nicht erledigt: dann fehlt der
     SPF-Eintrag der Domain. Sag mir Bescheid, das ist ein DNS-Eintrag.
4. Auf dem Handy öffnen: unten muss die Leiste mit „Anrufen" und
   „Analyse anfordern" stehen.
5. Den Link an dich selbst über WhatsApp schicken — das Vorschaubild muss
   erscheinen. Das machst du nach jedem Telefonat, das muss sitzen.
6. `pagespeed.web.dev` mit deiner Adresse. Du verkaufst genau das.

---

## 6 — Google (am Tag danach)

1. **Search Console** (`search.google.com/search-console`): Property vom Typ
   *Domain* anlegen, den TXT-Eintrag bei Netlify unter DNS hinterlegen,
   bestätigen. Dann unter *Sitemaps* eintragen:
   `https://scharfdigital.de/sitemap.xml`
2. **Google Business Profil** (`business.google.com`): Du verkaufst die
   Einrichtung solcher Profile und hast selbst keins. Kategorie „Webdesigner",
   Einzugsgebiet statt Ladenadresse, wenn du keine Kunden zu Hause empfängst.
3. **Bing Webmaster Tools**: übernimmt die Search-Console-Daten mit zwei Klicks.
   Bing versorgt die Websuche von ChatGPT — gehört zu deinem GEO-Argument.

---

## 7 — Was danach kommt

- **Dein Foto.** Der einzige echte Platzhalter im Design.
- **Die Vorlage für die Sichtbarkeits-Analyse.** Deine Seite verspricht sie an
  jeder Stelle — es gibt sie bisher nicht. Wichtiger als jede weitere Unterseite.
- Erste Referenzen und Google-Bewertungen.

---

## Was ich sofort übernehmen kann

- Den Pull Request auf `main` anlegen
- Die Domain im ganzen Projekt ändern, falls `scharfdigital.de` vergeben ist
- Eine Rechnungsvorlage mit korrektem § 19-Hinweis
- Die Analyse-Vorlage aus Punkt 7

---

# Anhang: Drei Anleitungen

**Stand 23.09.2026.** Die drei Dinge, die vor dem Livegang noch zu erledigen sind.

---

## A — Auftragsverarbeitungsvertrag mit Netlify

**Gute Nachricht vorweg:** Du musst nichts aushandeln und nichts unterschreiben.
Netlifys Auftragsverarbeitungsvertrag (Data Processing Agreement, DPA) ist
**Bestandteil der Nutzungsbedingungen**, die du bei der Anmeldung akzeptiert
hast. Er gilt also bereits. Was fehlt, ist nur ein Nachweis für deine Unterlagen.

1. **netlify.com/gdpr-ccpa/** aufrufen
2. Dort das **Data Processing Agreement als PDF** herunterladen
3. Speichern unter einem Namen, den du wiederfindest, z. B.
   `Netlify-DPA_2026-09-23.pdf`
4. Dazu das **Abrufdatum** notieren — bei einer Prüfung willst du sagen können,
   welche Fassung galt, als du die Seite online gestellt hast
5. Im `VERARBEITUNGSVERZEICHNIS.md` in der Tabelle unten den Status von
   „offen" auf „liegt vor, Fassung vom …" ändern

**Optional, wenn du es formeller willst:** Eine unterschriebene Ausfertigung
kannst du bei **privacy@netlify.com** anfordern. Für ein Einzelunternehmen ist
das nicht nötig — die einbezogene Fassung reicht.

**Was du dir ansehen solltest:** Im DPA stehen die Unterauftragsverarbeiter
(welche Dienstleister Netlify seinerseits einsetzt) und die technischen
Maßnahmen. Zwei Seiten überfliegen genügt.

---

## B — anton@scharfdigital.de über iCloud+ einrichten

### Vorher prüfen

- **iCloud+ aktiv?** iPhone → Einstellungen → dein Name → iCloud →
  *Speicher aktualisieren*. Der 50-GB-Tarif reicht.
- **Zwei-Faktor-Authentifizierung aktiv?** Ohne die geht es nicht.
- **iCloud Mail aktiviert?** Du brauchst eine bestehende `@icloud.com`-Adresse
  als Basis. Falls nicht vorhanden: Einstellungen → iCloud → iCloud Mail
  einschalten und Adresse anlegen.

### Reihenfolge

**Verbinde zuerst die Webseite mit Netlify** und lass Netlify die DNS-Verwaltung
übernehmen. Dann trägst du die iCloud-Einträge an derselben Stelle ein und musst
dich nicht zwischen zwei Oberflächen hin- und herbewegen.

### Einrichten

1. **iCloud.com** im Browser öffnen, anmelden
2. Oben rechts auf deinen Namen → **Einstellungen**
3. Bereich **„Benutzerdefinierte E-Mail-Domain"** → **Domain hinzufügen**
4. **„Nur von dir verwendet"** wählen (nicht „Du und andere Personen")
5. `scharfdigital.de` eintragen
6. Als E-Mail-Adresse **`anton@scharfdigital.de`** anlegen
7. Apple zeigt dir jetzt eine **Liste von DNS-Einträgen**. Fenster offen lassen.

### Die DNS-Einträge eintragen

Bei Netlify unter *Site configuration → Domain management → DNS records*, oder
beim Domain-Anbieter, falls du die Nameserver dort gelassen hast.

| Typ | Name/Host | Wert | Priorität |
|---|---|---|---|
| MX | @ | `mx01.mail.icloud.com` | 10 |
| MX | @ | `mx02.mail.icloud.com` | 10 |
| TXT | @ | SPF-Wert, den Apple anzeigt | — |
| CNAME | `sig1._domainkey` | Wert von Apple (DKIM) | — |
| TXT | @ | Bestätigungswert von Apple | — |

**Trag die Werte ab, die Apple dir anzeigt** — nicht die aus dieser Tabelle
raten. Die MX-Server stimmen immer, SPF, DKIM und der Bestätigungswert sind
bei jedem anders.

> **Achtung, falls auf der Domain schon Mail läuft:** Neue MX-Einträge ersetzen
> die alten. Ankommende Mails gehen dann an iCloud, nicht mehr an den alten
> Anbieter. Bei einer frisch gekauften Domain ist das egal.

### Abschließen

8. Zurück bei Apple auf **Überprüfen** klicken
9. **Warten:** 15 Minuten bis 24 Stunden, bis die Einträge überall bekannt sind
10. **Standard-Absender umstellen** auf `anton@scharfdigital.de` — sonst
    verschickst du weiter von `@icloud.com`
11. **Testen, beides:** Von einer fremden Adresse eine Mail an
    `anton@scharfdigital.de` schicken, und von dort eine rausschicken.
    Erst wenn beide Richtungen laufen, ist es fertig.

---

## C — IHK Erfurt anschreiben

### Kontakt

| | |
|---|---|
| **IHK Erfurt** | Arnstädter Straße 34, 99096 Erfurt |
| **Telefon** | 0361 3484-0 |
| **E-Mail** | info@erfurt.ihk.de |
| **Zeiten** | Mo–Do 8:00–17:00, Fr 8:00–14:30 |
| **Online** | ihk.de/erfurt → Service → Existenzgründung |

**Anrufen ist schneller.** Eine Mail kann ein paar Tage liegen; am Telefon hast
du in fünf Minuten einen Termin. Wenn du lieber schreibst, nimm den Text unten.

### Was die IHK leistet — und was nicht

Die IHK macht **Gründungsberatung**, keine Rechtsberatung im engeren Sinn. Sie
schaut über deine Angaben, findet die offensichtlichen Lücken und beantwortet
Fragen zu Steuerstatus und Beitragspflicht. Das kostet nichts.

Eine **belastbare Prüfung** von Impressum und Datenschutzerklärung, auf die du
dich im Streitfall berufen kannst, bekommst du nur bei einem **Anwalt für
IT-Recht** (150–300 €). Für den Start reicht die IHK meistens.

### E-Mail-Vorlage

**Betreff:** Terminanfrage Gründungsberatung — Einzelunternehmen Webdesign und SEO

```
Sehr geehrte Damen und Herren,

ich habe ein Gewerbe als Einzelunternehmer angemeldet und arbeite im
Bereich Webseiten und Suchmaschinenoptimierung für Handwerksbetriebe.
Die Anmeldung beim Finanzamt ist eingereicht, der Bescheid steht noch aus.

Ich würde gern einen Termin zur Gründungsberatung vereinbaren und habe
vier konkrete Fragen:

1. Kleinunternehmerregelung: Ich plane, sie nach § 19 UStG in Anspruch
   zu nehmen. Bei meinem Preisgefüge könnte ich im ersten Jahr an die
   Grenze von 25.000 € kommen. Was raten Sie?

2. IHK-Beitrag: Bin ich in meiner Größenordnung beitragsfrei, und
   worauf muss ich achten, damit das so bleibt?

3. Impressum: Ich stelle demnächst meine Webseite online. Können Sie
   einmal über die Pflichtangaben nach § 5 DDG schauen?

4. Datenschutzerklärung: Mein Webhoster und mein E-Mail-Anbieter sitzen
   in den USA, beide sind unter dem EU-US Data Privacy Framework
   zertifiziert. Reicht der Verweis darauf, oder fehlt etwas?

Ich bin zeitlich flexibel und komme gern zu Ihnen.

Mit freundlichen Grüßen
Anton Scharf
Scharf Digital
Am Eselsgraben 14, 99094 Erfurt
Telefon 01522 4610099
```

### Zum Termin mitnehmen

- Gewerbeanmeldung
- Die Adresse deiner Webseite (falls schon online) oder einen Ausdruck von
  Impressum und Datenschutzerklärung
- Deine Preisliste — für die Frage nach der Umsatzgrenze

### Danach

Wenn die Prüfung durch ist: Sag mir Bescheid, dann entferne ich den sichtbaren
Entwurfshinweis von Impressum und Datenschutzerklärung.
