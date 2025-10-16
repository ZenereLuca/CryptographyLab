<?php
    abstract class Cifrario {
        abstract public function cifra(string $messaggio): string;
        abstract public function decifra(string $messaggio): string;
    }
?>