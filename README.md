# Algoritmi di Cifratura - 🔐 CryptographyLab 🔐

## 📄 Descrizione

CryptographyLab è un laboratorio interattivo per la **cifratura e decifratura di messaggi**, un applicazione web realizzata in **PHP**, **HTML**, **CSS** e **JavaScript**.

Permette di **cifrare e decifrare messaggi** tramite gli algoritmi de:
- Il **Cifrario ROT13**;
- Il **Cifrario di Vigenère**.

## ⚙️ Funzionalità principali

- 📧 **Cifratura e decifratura** di messaggi testuali tramite Cifrario di Vigenère.
- 🔑 **Gestione chiave di cifratura** con adattamento automatico alla lunghezza del testo.
- 🧠 **Formattazione intelligente** del testo (consigliato utilizzare solo lettere ma funziona anche con caratteri speciali, tutto maiuscolo).
- 💾 **Sessioni PHP** per gestione degli errori e dei dati tra le pagine.  
- 🎨 **Interfaccia moderna** in stile "laboratorio", sviluppata con PHP, HTML, CSS e JavaScript personalizzato.  
- 📂 **Struttura modulare** con componenti riutilizzabili (`Header.php`, `NavBar.php`, `Footer.php`).

## 📂 Struttura del progetto

Il progetto si trova nel branch `Release`.

```
CryptographyLab/
│
├── Index.php                 # Pagina iniziale per la cifratura
├── Cifrato.php               # Pagina che mostra il risultato della cifratura
├── Decifra.php               # Pagina (iniziale) per la decifratura
├── Decifrato.php             # Pagina che mostra il risultato della decifratura
│
├── Classi/
│   ├── Cifrario.php          # Classe base astratta per i cifrari
│   ├── CifrarioRot13.php     # Implementazione del Cifrario ROT13
│   └── CifrarioVigenere.php  # Implementazione del Cifrario di Vigenère
│
├── ComponentiPagine/
│   ├── Header.php            # Header comune con titolo e menu
│   ├── NavBar.php            # Barra di navigazione comune
│   └── Footer.php            # Footer comune
│
├── Style/
│   └── Style.css             # Stile grafico del sito
│
├── Code/
│   └── Script.js             # Script per la gestione del campo aggiuntivo della chiave di Vigenère
│
└── README.md                 # Documentazione del progetto (questo file)
```

## 🧠 Architettura del codice PHP

Il progetto **CryptographyLab** adotta una struttura **modulare e orientata agli oggetti**, progettata per separare chiaramente logica, presentazione e gestione dei dati.

### 1️⃣ Classi (Cartella `/Classi`)

- **`Cifrario.php`**  
  Classe astratta che definisce l’interfaccia comune per tutti i cifrari.  
  ```php
  abstract class Cifrario {
      abstract public function cifra(string $testo): string;
      abstract public function decifra(string $testo): string;
  }
  ```
  Questo approccio consente di aggiungere facilmente nuovi algoritmi di cifratura semplicemente estendendo la classe base.

- **`CifrarioRot13.php`**  
  Implementa il **Cifrario ROT13**, una versione semplificata del cifrario di Cesare con rotazione fissa di 13 posizioni.  
  È un metodo simmetrico, cioè la funzione di cifratura e quella di decifratura coincidono.

- **`CifrarioVigenere.php`**  
  Implementa la logica specifica del **Cifrario di Vigenère**, gestendo:
  - La formattazione della chiave,
  - La conversione dei caratteri,
  - La rotazione delle lettere tramite operazioni ASCII (`ord` e `chr`).



### 2️⃣ Pagine PHP principali

- **`Index.php`**  
  Pagina principale con il form per l’inserimento del messaggio e della chiave.
  
  Invia i dati tramite una richiesta `POST` alla pagina di elaborazione (`Cifrato.php`).

- **`Cifrato.php`**  
  Riceve i dati dal form e utilizza la classe corrispondente per eseguire la cifratura.  
  Gestisce anche la **sessione PHP** per la gestione degli errori e dei dati tra una pagina e l’altra:
```php
// Verifica che la richiesta sia POST, altrimenti reindirizza a Index.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'REQUEST_METHOD non corretto.';
    header('Location: Index.php');
    exit;
}

// Controlla se sono stati inseriti tutti i dati necessari, altrimenti reindirizza a Index.php
if ($messaggio === '' || !in_array($algoritmo, ['rot13', 'vigenere'])) {
    $_SESSION['error'] = 'Dati mancanti o non validi.';
    header('Location: Index.php');
    exit;
}

// Se l'algoritmo è Vigenère, controlla che la chiave sia stata fornita
if ($algoritmo === 'vigenere' && trim($key) === '') {
    $_SESSION['error'] = 'Chiave richiesta per Vigenère.';
    header('Location: Index.php');
    exit;
}
```

### 3️⃣ Componenti riutilizzabili (Cartella `/ComponentiPagine`)
Tutte le pagine PHP che riguardano l'inserimento o la visualizzazione del risultato, contengono degli elementi comuni dell’interfaccia (titolo, menù, stile), inclusi nelle varie pagine tramite `include`.

I componenti riutilizzabili sono i file:
   - **`Header.php`**
   - **`NavBar.php`**
   - **`Footer.php`**

Vengono riutilizzati inserendo questa riga:
```php
include './ComponentiPagine/<NomeComponenteComune>.php';
```

### 4️⃣ Interfaccia utente (HTML + CSS + JS)

- Il frontend è gestito con **HTML5** e **CSS3**.  
  Lo stile è definito in `Style/Style.css`, con un tema azzuro chiaro/scuro con accenni al verde colore tipico della codifica.
- Il campo aggiuntivo della chiave di Vigenèreè è gestito in `Code/Script.js`.

## 🔧 Vantaggi architetturali

- **Separazione netta tra logica e presentazione**.  
- **Estendibilità**: basta creare una nuova classe che estende `Cifrario` per aggiungere un nuovo algoritmo.  
- **Manutenibilità**: il codice è modulare e leggibile.  
- **Compatibilità**: il progetto è eseguibile in qualsiasi ambiente PHP senza database.

## ✅ Requisiti

Per eseguire CryptoLab in locale è necessario:

- **PHP >= 8.0**
- Un server locale come **XAMPP**
- Un browser web moderno (Chrome, Firefox, Edge…)


## 🚀 Istruzioni per l’esecuzione

1. Clona o scarica il progetto:
   ```bash
   git clone https://github.com/ZenereLuca/CryptographyLab
   ```
2. Copia la cartella `CryptographyLab` nella directory `htdocs`.
3. Avvia **Apache** dal pannello di controllo di XAMPP.
4. Apri il browser oppure clicca su **Admin di Apache di XAMPP** e visita:
   ```
   http://localhost/CryptographyLab/
   ```


## 🧮 Come funzionano i cifrari

### ⏩ Come funziona il Cifrario ROT13

Il **Cifrario ROT13** (“rotate by 13 places”) è una **variante del classico Cifrario di Cesare** in cui ogni lettera dell’alfabeto viene sostituita da quella che si trova **13 posizioni dopo**.

Poiché l’alfabeto latino ha 26 lettere, **applicare ROT13 2 volte riporta il testo originale**:
> ROT13(ROT13(testo)) = testo

È un metodo **simmetrico** e molto semplice, spesso usato per oscurare brevi testi o spoiler su Internet.

Esempio:
```
Testo: CRYPTO
ROT13: PELCGB
```

### 🔑 Come funziona il Cifrario di Vigenère

Il **Cifrario di Vigenère** è un metodo di crittografia **polialfabetico** che utilizza una **chiave per cifrare** un testo.

Ogni lettera del messaggio è traslata secondo la corrispondente lettera della chiave (ripetuta ciclicamente).

Esempio:
```
Testo:            ATTACCAILNEMICO
Chiave:           LIMONE
Chiave corrisp.:  LIMONELIMONELIM
Risultato:        LXFOPVEFRNHRMUG
```

## 👨‍💻 Autore

**Progetto sviluppato da:** *Luca Zenere*  
**Anno Scolastico:** 2025-2026  
**Classe:** 5AII  
**Linguaggi:** PHP, HTML, CSS, JavaScript  
**Licenza:** MIT

## 📸 Screenshot

![Schermata principale per la cifratura](/Screenshot/Index.jpg)  
![Risultato cifratura](/Screenshot/Cifrato.jpg)  
![Schermata principale per la decifratura](/Screenshot/Decifra.jpg)  
![Risultato decifratura](/Screenshot/Decifrato.jpg)  
![Diagramma FlowChart](/Diagrammi/DiagrammaFlowChart.png)  
![Schema dell'applicazione](/Diagrammi/SchemaApplicazione.png)