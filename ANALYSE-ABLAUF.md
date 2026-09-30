# Sichtbarkeits-Analyse — Ablauf

Interne Arbeitsanweisung. **Gehört nicht auf die Webseite** und wird nicht
an den Kunden gegeben. Der Kunde bekommt nur die ausgefüllte
`SICHTBARKEITS-ANALYSE.html` als PDF.

Ziel: **zwanzig Minuten pro Betrieb.** Wer länger braucht, macht zehn
Analysen in der Woche statt dreißig.

---

## Vorher (2 Minuten)

Notiere: Betriebsname, Gewerk, Ort, Webseite (falls vorhanden),
Telefonnummer. Alles aus dem Google-Eintrag oder der Handwerkskammer-Liste.

**Alles im Inkognito-Fenster.** Sonst zeigt Google dir Ergebnisse, die auf
deiner eigenen Suchhistorie beruhen — und die sieht der Kunde nie.

---

## 1. Google-Suche (5 Minuten)

Drei Suchen, immer dieselben drei Muster:

| Nr. | Muster | Beispiel |
|---|---|---|
| 1 | `<Gewerk> <Ort>` | `Dachdecker Erfurt` |
| 2 | `<Gewerk> in der Nähe` | `Dachdecker in der Nähe` |
| 3 | `<Leistung> <Ort>` | `Dachsanierung Erfurt` |

Notiere je Suche: **auf welcher Position** der Betrieb steht (oder gar
nicht) und **wer auf 1 bis 3 steht**.

> **Wichtig bei Suche 2:** „in der Nähe" richtet sich nach deinem Standort,
> nicht nach dem des Kunden. Wenn du von Erfurt aus einen Betrieb in Weimar
> prüfst, ist das Ergebnis wertlos. Dann Suche 2 weglassen und im Formular
> streichen — nicht raten.

---

## 2. Google Maps (3 Minuten)

`<Gewerk> <Ort>` in Google Maps. Ansehen:

- Gibt es den Eintrag überhaupt? Ist er beansprucht oder von Google angelegt?
- Steht er im **Kartenblock** (die drei über den normalen Ergebnissen)?
- Wie viele Bewertungen, welcher Schnitt?
- Öffnungszeiten, Telefonnummer, Leistungen gepflegt?
- Fotos vorhanden?

Der Kartenblock ist der wertvollste Platz im lokalen Handwerk. Wer dort
nicht steht, verliert die Kunden, die gar nichts eintippen.

---

## 3. KI-Antworten (5 Minuten)

Drei Fragen, in ChatGPT **und** Perplexity, jeweils in einem neuen Chat
ohne Verlauf:

```
Welchen <Gewerk> kannst du mir in <Ort> empfehlen?
Wer macht <Leistung> in <Ort>?
Welche <Gewerk>-Betriebe in <Ort> haben gute Bewertungen?
```

Notiere, **ob der Betrieb genannt wird** und **welche stattdessen**.
Mach einen Screenshot — der Wortlaut ist im Gespräch mehr wert als jede
Zusammenfassung.

> KI-Antworten schwanken von Tag zu Tag. Niemals eine Platzierung
> behaupten. Was zählt, ist das Muster: genannt oder nicht.

---

## 4. Die Webseite (4 Minuten)

| Prüfen | Wie |
|---|---|
| Ladezeit | `pagespeed.web.dev`, Wert für Mobil |
| Auf dem Handy bedienbar | Seite auf dem eigenen Handy öffnen |
| Telefonnummer antippbar | antippen — wählt es? |
| KI-Crawler gesperrt | `ihre-adresse.de/robots.txt` aufrufen, nach `GPTBot`, `ClaudeBot`, `PerplexityBot` suchen |
| Text im Quelltext | Rechtsklick → Seitenquelltext, nach einem Satz aus der Seite suchen. Nicht gefunden = per JavaScript zusammengebaut = für KI unsichtbar |
| Impressum, Datenschutz | vorhanden und gefüllt? |

---

## 5. Die drei Punkte auswählen (5 Minuten)

Nicht alles aufschreiben, was auffällt — **die drei mit dem größten Hebel.**
Reihenfolge, nach der ich auswähle:

1. **Kein Google-Eintrag oder ungepflegt.** Größter Hebel, kostet den
   Betrieb nichts außer Zeit. Steht immer an erster Stelle, wenn zutreffend.
2. **KI-Crawler gesperrt.** Schnellster Hebel überhaupt, eine Zeile Arbeit.
3. **Keine Webseite oder nicht auf dem Handy bedienbar.**
4. **Nicht im Kartenblock, obwohl Eintrag vorhanden.**
5. **Unter fünf Bewertungen.**
6. **Ladezeit über drei Sekunden.**
7. **Kein eigener Inhalt zu den Leistungen** (nur eine Startseite).

Jeder Punkt in zwei Sätzen: **was ist** und **was es bedeutet.** Kein
Fachwort ohne Erklärung. Wer „Ihre Core Web Vitals sind schlecht" schreibt,
hat den Kunden verloren.

---

## 6. Rausschicken

**Am Rechner ausfuellen:** `SICHTBARKEITS-ANALYSE.html` im Browser oeffnen
(Doppelklick auf die Datei), Felder ausfuellen, dann **Strg+P → Als PDF
speichern**. Die Eingaben bleiben im Browser gespeichert, bis du auf
„Leeren" drueckst — wenn dich jemand mittendrin anruft, ist nichts weg.
Gespeichert wird nur auf deinem Rechner, nichts geht an einen Server.

**Mit dem Stift ausfuellen:** Blatt leer ausdrucken, ausfuellen,
einscannen. Die Felder haben Schreiblinien.

Benennen nach dem Muster `Sichtbarkeit-<Betrieb>-<JJJJ-MM-TT>.pdf`.

Dazu eine kurze Mail — kein Verkaufstext:

> Guten Tag Herr/Frau ____,
>
> wie besprochen habe ich nachgesehen, wie Ihr Betrieb bei Google und in
> den KI-Antworten auftaucht. Das Ergebnis hängt an.
>
> Der auffälligste Punkt: ____________.
>
> Wenn Sie dazu Fragen haben, rufen Sie gern an — 01522 4610099.
> Wenn nicht, behalten Sie die Auswertung trotzdem.
>
> Viele Grüße, Anton Scharf

---

## Nebenprodukt: die Zahlen sammeln

Führe eine einfache Liste mit: Gewerk, Ort, bei ChatGPT genannt ja/nein.
Nach zehn Betrieben desselben Gewerks hast du einen Satz wie
**„Ich habe zehn Erfurter Dachdecker bei ChatGPT gesucht — acht kamen nicht
vor."**

Das ist der Inhalt für eine eigene Seite auf scharfdigital.de und für
Beiträge. Die Zahlen sind dann echt, nicht behauptet — und echte Zahlen
sind das Einzige, was in diesem Geschäft überzeugt.
