<?php
/**
 * Scharf Digital — Verarbeitung des Anfrageformulars.
 *
 * Erwartet einen POST von /kontakt/. Bei Erfolg Weiterleitung auf /danke/,
 * bei Fehlern eine Seite mit Meldung und einem Weg zurück zum Formular.
 * Kein externer Dienst, kein Captcha, keine Speicherung auf dem Server.
 */

declare(strict_types=1);

const EMPFAENGER   = 'anton@scharfdigital.de';
const ABSENDER     = 'formular@scharfdigital.de'; // muss zur Domain gehoeren, sonst landet die Mail im Spam
const ZIEL_ERFOLG  = '/danke/';
const ZIEL_FORMULAR = '/kontakt/';

/** Nimmt ein Feld aus dem POST, kuerzt es und entfernt Steuerzeichen. */
function feld(string $name, int $max = 200): string
{
    $wert = $_POST[$name] ?? '';
    if (!is_string($wert)) {
        return '';
    }
    $wert = trim($wert);
    // Zeilenumbrueche und Steuerzeichen raus: schuetzt die Mail-Header.
    $wert = preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $wert) ?? '';
    return mb_substr($wert, 0, $max);
}

/** Betreff und Namen fuer Mail-Header UTF-8-sicher kodieren. */
function kopfzeile(string $text): string
{
    return '=?UTF-8?B?' . base64_encode($text) . '?=';
}

/** Zurueck zum Formular mit Fehlernummer. 303, damit F5 den POST nicht wiederholt. */
function zurueck(int $nummer): void
{
    header('Location: ' . ZIEL_FORMULAR . '?fehler=' . $nummer, true, 303);
    exit;
}

/* ------------------------------------------------------------------ Ablauf */

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: ' . ZIEL_FORMULAR, true, 303);
    exit;
}

// Honeypot: Menschen sehen das Feld nicht. Ist es ausgefuellt, war es ein Bot.
// Wir tun so, als waere alles gut, und verwerfen die Anfrage still.
if (feld('website_url') !== '') {
    header('Location: ' . ZIEL_ERFOLG, true, 303);
    exit;
}

$firma    = feld('firma', 120);
$ort      = feld('ort', 80);
$webseite = feld('webseite', 200);
$kontakt  = feld('kontakt', 120);
$ok       = isset($_POST['einwilligung']);

$gueltig = $firma !== '' && $ort !== '' && $kontakt !== '' && $ok;

// Kontaktangabe einordnen: E-Mail oder Telefonnummer?
$absender_mail = '';
if ($kontakt !== '') {
    if (str_contains($kontakt, '@')) {
        $geprueft = filter_var($kontakt, FILTER_VALIDATE_EMAIL);
        if ($geprueft === false) {
            $gueltig = false;
        } else {
            $absender_mail = $geprueft;
        }
    } elseif (preg_match('/^[0-9+][0-9 \/()\-]{5,}$/', $kontakt) !== 1) {
        $gueltig = false;
    }
}

// Webseite ist freiwillig, muss aber eine URL sein, wenn sie ausgefuellt wurde.
if ($webseite !== '') {
    if (!preg_match('#^https?://#i', $webseite)) {
        $webseite = 'https://' . $webseite;
    }
    if (filter_var($webseite, FILTER_VALIDATE_URL) === false) {
        $webseite = '';
    }
}

if (!$gueltig) {
    zurueck(1);
}

/* ------------------------------------------------------------------- Mail */

$betreff = kopfzeile('Sichtbarkeits-Analyse: ' . $firma . ' (' . $ort . ')');

$text = "Neue Anfrage über das Formular auf scharfdigital.de\n"
      . str_repeat('-', 52) . "\n\n"
      . "Betrieb:   " . $firma . "\n"
      . "Ort:       " . $ort . "\n"
      . "Webseite:  " . ($webseite !== '' ? $webseite : 'keine angegeben') . "\n"
      . "Kontakt:   " . $kontakt . "\n\n"
      . "Einwilligung erteilt: ja\n"
      . "Eingegangen: " . date('d.m.Y, H:i') . " Uhr\n";

$header = [
    'From: ' . kopfzeile('Anfrage scharfdigital.de') . ' <' . ABSENDER . '>',
    'Reply-To: ' . ($absender_mail !== '' ? $absender_mail : ABSENDER),
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
    'MIME-Version: 1.0',
    'X-Mailer: scharfdigital.de',
];

$gesendet = @mail(EMPFAENGER, $betreff, $text, implode("\r\n", $header), '-f' . ABSENDER);

if (!$gesendet) {
    error_log('Formularversand fehlgeschlagen: ' . $firma . ' / ' . $ort);
    zurueck(2);
}

header('Location: ' . ZIEL_ERFOLG, true, 303);
exit;
