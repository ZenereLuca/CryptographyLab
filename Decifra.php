<?php
    session_start();    // Necessario per leggere l'errore salvato nella sessione

    $pageTitle = 'Decifra un Messaggio - CryptographyLab';
    
    // Recupera l'eventuale errore e poi lo rimuove
    $error = $_SESSION['error'] ?? '';
    unset($_SESSION['error']);

    include './ComponentiPagine/Header.php';
?>

<!-- Parte HTML per il form di decifratura -->
<main>
    <h1>DECIFRA UN MESSAGGIO</h1>
    <form action="Decifrato.php" method="POST" class="cipher-form">
        <!-- Inserimento del messaggio -->
        <label for="message">Messaggio da decifrare:</label>
        <textarea name="message" id="message" rows="5" required placeholder="Inserisci il testo da decifrare..."></textarea>

        <!-- Selezione dell'algoritmo -->
        <label for="algorithm">Scegli l'algoritmo di decifratura:</label>
        <select name="algorithm" id="algorithm" required onchange="toggleKeyField()">
            <option value="">Seleziona un algoritmo...</option>
            <option value="rot13">ROT13 (Cifrario di Cesare)</option>
            <option value="vigenere">Vigenère (Cifrario polialfabetico)</option>
        </select>

        <!--Campo aggiuntivo per la chiave di decifratura di Vigenère-->
        <div id="keyContainer" style="display:none;">
            <label for="key">🔑 Chiave per Vigenère:</label>
            <input type="text" name="key" id="key" placeholder="Inserisci la chiave (solo lettere)..." />
        </div>

        <!-- Mostra eventuale errore -->
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <button type="submit">🔓 DECIFRA MESSAGGIO</button>
    </form>
</main>

<?php include './ComponentiPagine/Footer.php'; ?>