<?php
    session_start();    // Necessario per salvare errori nella sessione

    $pageTitle = 'Messaggio Decifrato - CryptographyLab';
    include './ComponentiPagine/Header.php';

    // Incorpora codice PHP dei file delle classi
    require_once './Classi/Cifrario.php';
    require_once './Classi/CifrarioRot13.php';
    require_once './Classi/CifrarioVigenere.php';

    // Verifica che la richiesta sia POST, altrimenti reindirizza a Decifra.php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = 'REQUEST_METHOD non corretto.';
        header('Location: Decifra.php');
        exit;
    }

    // Recupera i dati dal form
    $messaggio = trim($_POST['message'] ?? '');
    $algoritmo = $_POST['algorithm'] ?? '';
    $key = $_POST['key'] ?? '';

    $error = '';
    $messaggioDecifrato = '';
    $showResult = false;

    // Controlla se sono stati inseriti tutti i dati necessari, altrimenti reindirizza a Decifra.php
    if ($messaggio === '' || !in_array($algoritmo, ['rot13', 'vigenere'])) {
        $_SESSION['error'] = 'Dati mancanti o non validi.';
        header('Location: Decifra.php');
        exit;
    }

    // Se è stato scelto Vigenère, controlla che la chiave sia stata fornita, altrimenti reindirizza a Decifra.php
    if ($algoritmo === 'vigenere' && trim($key) === '') {
        $_SESSION['error'] = 'Chiave richiesta per Vigenère.';
        header('Location: Decifra.php');
        exit;
    }
    

    // Decifra il messaggio
    $cifrario = null;
    if ($algoritmo === 'rot13')
        $cifrario = new CifrarioRot13();
    else
        $cifrario = new CifrarioVigenere($key);

    $messaggioDecifrato = $cifrario->decifra($messaggio);
?>

<!-- Parte HTML per mostrare il messaggio decifrato -->
<main>
    <h1>🔓 MESSAGGIO DECIFRATO 🔓</h1>

    <!-- Messaggio Originale -->
    <p><strong>Messaggio da decifrare:</strong> <?php echo htmlspecialchars(strtoupper($messaggio)); ?></p><br>

    <!-- Algoritmo Utilizzato -->
    <p><strong>Algoritmo utilizzato:</strong> <?php echo htmlspecialchars(strtoupper($algoritmo)); ?></p><br>

    <!-- Se l'algoritmo è Vigenère, mostra la chiave -->
    <?php if ($algoritmo === 'vigenere'): ?>
        <p><strong>🔑 Chiave:</strong> <?php echo htmlspecialchars($key); ?> </p>
    <?php endif; ?>
    
    <br>

    <!-- Messaggio Decifrato -->
    <textarea readonly rows="8"><?php echo htmlspecialchars($messaggioDecifrato); ?></textarea><br>

    <button onclick="history.back()">🔙 Torna indietro</button>
</main>

<?php include './ComponentiPagine/Footer.php'; ?>