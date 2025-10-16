<?php
    class CifrarioVigenere extends Cifrario {
        private $key;

        // Costruttore che memorizza la chiave di cifratura
        public function __construct(string $key) {
            $this->key = strtoupper($key);
        }

        // Adatta la chiave alla lunghezza del messaggio
        private function formattaChiave(string $messaggio): string {
            $key = $this->key;
            $keyLength = strlen($key);
            $messagLength = strlen($messaggio);
            $formattedKey = '';

            // Costruisce la chiave formattata
            for ($i = 0, $j = 0; $i < $messagLength; $i++) {    // i scorre il messaggio, j scorre la chiave
                $char = $messaggio[$i];    // Prende un carattere del messaggio
                
                // Se è una lettera, prende il carattere dalla chiave
                if (ctype_alpha($char)) {
                    /* Se la chiave è più corta del messaggio, ricomincia dall'inizio
                    (il modulo ritorna la posizione della lettera della chiave) */
                    $formattedKey .= $key[$j % $keyLength];
                    $j++;
                }
                else $formattedKey .= $char; // Non è una lettera (spazio, num, punti) => mantienilo invariato
            }

            return $formattedKey;
        }

        // Cifra il messaggio
        public function cifra(string $messaggio): string {
            $messaggio = strtoupper($messaggio);    // Tutto maiuscolo
            $key = $this->formattaChiave($messaggio); // Adatta la chiave alla lunghezza del messaggio
            $result = '';

            // Scorre il messaggio e cifra ogni lettera
            for ($i = 0; $i < strlen($messaggio); $i++) {
                $char = $messaggio[$i];

                // Se è una lettera => applica la cifratura
                if (ctype_alpha($char)) {
                    // Effetua uno shift (A=0, B=1, ..., Z=25) sulla lettera della chiave
                    $shift = ord($key[$i]) - 65;    // Con ord(c) converte la lettera della chiave in ASCII
                    
                    // Applica lo shift sulla lettera del messaggio e lo converte in char
                    $charCifrato = chr((ord($char) - 65 + $shift) % 26 + 65);

                    $result .= $charCifrato;
                }
                else $result .= $char; // Non è una lettera => mantienilo invariato
            }

            return $result;
        }

        // Decifra il messaggio
        public function decifra(string $messaggio): string {
            $messaggio = strtoupper($messaggio);    // Tutto maiuscolo
            $key = $this->formattaChiave($messaggio);   // Adatta la chiave alla lunghezza del messaggio
            $result = '';

            // Scorre il messaggio e decifra ogni lettera
            for ($i = 0; $i < strlen($messaggio); $i++) {
                $char = $messaggio[$i];

                // Se è una lettera => applica la decifratura
                if (ctype_alpha($char)) {
                    // Effetua uno shift (A=0, B=1, ..., Z=25) sulla lettera della chiave
                    $shift = ord($key[$i]) - 65;    // Con ord(char) converte la lettera della chiave in ASCII
                    
                    // Applica lo shift inverso sulla lettera del messaggio e lo converte in char
                    $charDecifrato = chr((ord($char) - 65 - $shift + 26) % 26 + 65);

                    $result .= $charDecifrato;
                }
                else $result .= $char; // Non è una lettera => mantienilo invariato
            }
            
            return $result;
        }
    }
?>