<?php
    session_start();    // Necessario per salvare errori nella sessione

    $pageTitle = 'Messaggio Cifrato - CryptographyLab';
    include './ComponentiPagine/Header.php';

    // Incorpora codice PHP dei file delle classi
    require_once './Classi/Cifrario.php';
    require_once './Classi/CifrarioRot13.php';
    require_once './Classi/CifrarioVigenere.php';

    // Verifica che la richiesta sia POST, altrimenti reindirizza a Index.php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = 'REQUEST_METHOD non corretto.';
        header('Location: Index.php');
        exit;
    }

    // Recupera i dati dal form
    $messaggio = trim($_POST['message'] ?? '');
    $algoritmo = $_POST['algorithm'] ?? '';
    $key = $_POST['key'] ?? '';

    $error = '';

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

    // Cifra il messaggio
    $cifrario = null;
    if ($algoritmo === 'rot13')
        $cifrario = new CifrarioRot13();
    else
        $cifrario = new CifrarioVigenere($key);

    $messaggioCifrato = $cifrario->cifra($messaggio);
?>

<!-- Parte HTML per mostrare il messaggio cifrato -->
<main>
    <h1>🔒 MESSAGGIO CIFRATO 🔒</h1>

    <!-- Messaggio Originale -->
    <p><strong>Messaggio da cifrare:</strong> <?php echo htmlspecialchars(strtoupper($messaggio)); ?></p><br>

    <!-- Algoritmo Utilizzato -->
    <p><strong>Algoritmo utilizzato:</strong> <?php echo htmlspecialchars(strtoupper($algoritmo)); ?></p><br>

    <!-- Se l'algoritmo è Vigenère, mostra la chiave -->
    <?php if ($algoritmo === 'vigenere'): ?>
        <p><strong>🔑 Chiave:</strong> <?php echo htmlspecialchars($key); ?> </p>
    <?php endif; ?>
    
    <br>

    <!-- Messaggio Decifrato -->
    <textarea readonly rows="8"><?php echo htmlspecialchars($messaggioCifrato); ?></textarea><br>

    <button onclick="history.back()">🔙 Torna indietro</button>
</main>

<?php include './ComponentiPagine/Footer.php'; ?>