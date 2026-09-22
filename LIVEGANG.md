# Livegang — Schritt für Schritt

**Stand:** 16.09.2026 · Hosting: Netlify · E-Mail: iCloud+ · Kleinunternehmer nach § 19 UStG

Keine Rechts- oder Steuerberatung. Die zwei Stellen, an denen das zählt, sind unten markiert.

---

## Was das kostet

| | einmalig | laufend |
|---|---|---|
| Gewerbeanmeldung Erfurt | 20–40 € | — |
| Fragebogen beim Finanzamt (ELSTER) | 0 € | — |
| IHK-Mitgliedschaft | 0 € | in deiner Größe meist beitragsfrei, siehe 3.3 |
| Domain `scharfdigital.de` | — | 5–15 € im Jahr |
| Netlify Hosting | — | 0 € (kostenloses Kontingent reicht deutlich) |
| iCloud+ für die eigene E-Mail-Adresse | — | rund 12 € im Jahr |

**Rund 2 € im Monat plus einmalig die Gewerbeanmeldung.** Das ist der ganze
Kostenblock, um online zu gehen.

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

### 4.1 Gewerbeanmeldung

Vor der ersten Rechnung. In Erfurt beim Bürgeramt/Gewerbeamt, **20–40 €**, das
Formular ist eine Seite. Tätigkeit: *„Erstellung von Webseiten und
Suchmaschinenoptimierung"*. Viele Kommunen bieten das inzwischen online an —
auf der Seite der Stadt Erfurt nach „Gewerbeanmeldung" suchen.

Danach schickt dir das Finanzamt automatisch den *Fragebogen zur steuerlichen
Erfassung*. Den füllst du kostenlos über ELSTER aus. Dort setzt du das Kreuz
bei der Kleinunternehmerregelung.

> **Falls du noch nicht 18 bist:** Es braucht die Zustimmung der
> Erziehungsberechtigten und eine Genehmigung des Familiengerichts. Ruf vorher
> beim Gewerbeamt an — das klärt sich in fünf Minuten am Telefon.

### 4.2 Kleinunternehmer nach § 19 UStG — ist eingetragen

Im Impressum steht jetzt:

> Kleinunternehmer im Sinne von § 19 UStG. Es wird keine Umsatzsteuer berechnet und ausgewiesen.

**Was das für dich heißt:**

- Du weist auf Rechnungen **keine** Umsatzsteuer aus und führst keine ab.
  Auf der Rechnung steht stattdessen der Hinweis auf § 19 UStG.
- Du darfst im Gegenzug keine Vorsteuer ziehen — die 19 % auf Hosting, Software
  und Technik sind für dich echte Kosten.
- **Die Grenze liegt bei 22.000 € Umsatz im ersten Jahr.** Bei 2.500 € pro
  Webseite bist du nach neun Webseiten dran. Reißt du sie, wirst du **ab dem
  Folgejahr** umsatzsteuerpflichtig — dann musst du deine Preise entweder um
  19 % anheben oder die Steuer aus dem bestehenden Preis herausrechnen.
- Für deine Kunden ist das meist egal: Handwerksbetriebe sind selbst
  vorsteuerabzugsberechtigt, ihnen ist der Bruttopreis gleich.

**Das ist keine Steuerberatung.** Wenn du damit rechnest, im ersten Jahr über
22.000 € zu kommen, sprich das in der kostenlosen Gründerberatung der IHK
Erfurt an — ein Wechsel mitten im Geschäftsjahr ist unangenehmer als von Anfang
an Regelbesteuerung.

### 4.3 IHK — Pflicht, aber wahrscheinlich kostenlos

Mit der Gewerbeanmeldung wirst du automatisch IHK-Mitglied. Das erschreckt
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
und die Frage, ob du im ersten Jahr über 22.000 € Umsatz kommst.

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
   Danach musst du auf `/danke/` landen.
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
