<?php 
    class CifrarioRot13 extends Cifrario {
        // Cifra il messaggio
        public function cifra(string $messaggio) : string {
            $messaggio = strtoupper($messaggio);    // Tutto maiuscolo
            $result = '';
            
            // Applica la cifratura ROT13 su ogni carattere
            for ($i = 0; $i < strlen($messaggio); $i++) {
                $char = $messaggio[$i];
                
                // Controlla se è una lettera
                if (ctype_alpha($char)) {
                    // Calcola la posizione (A=0, B=1, ..., Z=25)
                    $pos = ord($char) - 65;
                    
                    // Applica ROT13 => (posizione + 13) % 26
                    $newPos = ($pos + 13) % 26;
                    
                    // Converte la pos in carattere
                    $result .= chr($newPos + 65);
                }
                else  $result .= $char; // Non è una lettera => mantienilo invariato
            }
            
            return $result;
        }

        // Decifra il messaggio
        public function decifra(string $messaggio) : string {
            // ROT13 è simmetrico (cifrare 2 volte = decifrare)
            return $this->cifra($messaggio);
        }
    }
?>