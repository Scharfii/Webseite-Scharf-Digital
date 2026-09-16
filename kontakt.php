<?php
/**
 * Scharf Digital — Verarbeitung des Anfrageformulars.
 *
 * Erwartet einen POST von /kontakt/. Bei Erfolg Weiterleitung auf /danke/,
 * bei Fehlern eine Seite mit Meldung und einem Weg zurück zum Formular.
 * Kein externer Dienst, kein Captcha, keine Speicherung auf dem Server.
 */

declare(strict_types=1);

const EMPFAENGER   = 'anton@scharf-digital.com';
const ABSENDER     = 'formular@scharf-digital.com'; // muss zur Domain gehoeren, sonst landet die Mail im Spam
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

/** Fehlerseite im Design der Webseite ausgeben und beenden. */
function fehlerseite(array $meldungen): void
{
    http_response_code(400);
    header('Content-Type: text/html; charset=utf-8');
    $liste = '';
    foreach ($meldungen as $m) {
        $liste .= '<li class="body-lg">' . htmlspecialchars($m, ENT_QUOTES, 'UTF-8') . '</li>';
    }
    echo '<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Anfrage konnte nicht gesendet werden | Scharf Digital</title>
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#0A0F1E">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
</head>
<body>
<main id="inhalt">
<section class="sec" style="padding-block:80px;min-height:60vh">
<div class="wrap stack" style="max-width:640px;gap:24px">
<p class="eyebrow">Da fehlt noch etwas</p>
<h1 class="h1-sub">Die Anfrage konnte nicht gesendet werden.</h1>
<p class="lead-sm">Bitte gehen Sie kurz zurück und ergänzen Sie die folgenden Punkte. Ihre übrigen Angaben sind nicht verloren, wenn Sie den Zurück-Knopf Ihres Browsers benutzen.</p>
<ul class="prose">' . $liste . '</ul>
<div class="row">
<a class="btn btn-primary" href="' . ZIEL_FORMULAR . '">Zurück zum Formular</a>
<a class="btn btn-ghost" href="tel:+4915224610099">01522 4610099</a>
</div>
<p class="small">Wenn es nicht klappt, rufen Sie einfach an oder schreiben Sie an <a href="mailto:' . EMPFAENGER . '">' . EMPFAENGER . '</a>.</p>
</div>
</section>
</main>
</body>
</html>';
    exit;
}

/* ------------------------------------------------------------------ Ablauf */

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: ' . ZIEL_FORMULAR, true, 303);
    exit;
}

// Honeypot: Menschen sehen das Feld nicht. Ist es ausgefuellt, war es ein Bot.
// Wir tun so, als waere alles gut, und verwerfen die Anfrage still.
if (feld('hp_website') !== '') {
    header('Location: ' . ZIEL_ERFOLG, true, 303);
    exit;
}

$betrieb  = feld('betrieb', 120);
$ort      = feld('ort', 80);
$webseite = feld('webseite', 200);
$kontakt  = feld('kontakt', 120);
$ok       = isset($_POST['einwilligung']);

$fehler = [];
if ($betrieb === '') {
    $fehler[] = 'Der Name Ihres Betriebs fehlt.';
}
if ($ort === '') {
    $fehler[] = 'Der Ort fehlt.';
}
if ($kontakt === '') {
    $fehler[] = 'Bitte tragen Sie eine Telefonnummer oder eine E-Mail-Adresse ein, damit ich mich melden kann.';
}
if (!$ok) {
    $fehler[] = 'Ohne die Einwilligung zur Verarbeitung Ihrer Angaben darf ich die Anfrage nicht bearbeiten.';
}

// Kontaktangabe einordnen: E-Mail oder Telefonnummer?
$absender_mail = '';
if ($kontakt !== '') {
    if (str_contains($kontakt, '@')) {
        $geprueft = filter_var($kontakt, FILTER_VALIDATE_EMAIL);
        if ($geprueft === false) {
            $fehler[] = 'Die E-Mail-Adresse sieht nicht richtig aus. Bitte prüfen Sie sie noch einmal.';
        } else {
            $absender_mail = $geprueft;
        }
    } elseif (preg_match('/^[0-9+][0-9 \/()\-]{5,}$/', $kontakt) !== 1) {
        $fehler[] = 'Die Telefonnummer sieht nicht richtig aus. Bitte prüfen Sie sie noch einmal.';
    }
}

// Webseite ist freiwillig, muss aber eine URL sein, wenn sie ausgefuellt wurde.
if ($webseite !== '') {
    if (!preg_match('#^https?://#i', $webseite)) {
        $webseite = 'https://' . $webseite;
    }
    if (filter_var($webseite, FILTER_VALIDATE_URL) === false) {
        $fehler[] = 'Die Adresse Ihrer Webseite sieht nicht richtig aus. Sie können das Feld auch frei lassen.';
    }
}

if ($fehler !== []) {
    fehlerseite($fehler);
}

/* ------------------------------------------------------------------- Mail */

$betreff = kopfzeile('Sichtbarkeits-Analyse: ' . $betrieb . ' (' . $ort . ')');

$text = "Neue Anfrage über das Formular auf scharf-digital.com\n"
      . str_repeat('-', 52) . "\n\n"
      . "Betrieb:   " . $betrieb . "\n"
      . "Ort:       " . $ort . "\n"
      . "Webseite:  " . ($webseite !== '' ? $webseite : 'keine angegeben') . "\n"
      . "Kontakt:   " . $kontakt . "\n\n"
      . "Einwilligung erteilt: ja\n"
      . "Eingegangen: " . date('d.m.Y, H:i') . " Uhr\n";

$header = [
    'From: ' . kopfzeile('Anfrage scharf-digital.com') . ' <' . ABSENDER . '>',
    'Reply-To: ' . ($absender_mail !== '' ? $absender_mail : ABSENDER),
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
    'MIME-Version: 1.0',
    'X-Mailer: scharf-digital.com',
];

$gesendet = @mail(EMPFAENGER, $betreff, $text, implode("\r\n", $header), '-f' . ABSENDER);

if (!$gesendet) {
    fehlerseite([
        'Die Anfrage konnte technisch nicht zugestellt werden. Das liegt an meinem Server, nicht an Ihren Angaben.',
        'Bitte rufen Sie kurz an unter 01522 4610099 oder schreiben Sie direkt an ' . EMPFAENGER . '.',
    ]);
}

header('Location: ' . ZIEL_ERFOLG, true, 303);
exit;
