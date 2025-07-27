<?php

namespace App\Services;

class SerbianTransliterator
{
    // Mapa ćirilica -> latinica
    private static $cyrillicToLatin = [
        'А' => 'A', 'а' => 'a',
        'Б' => 'B', 'б' => 'b',
        'В' => 'V', 'в' => 'v',
        'Г' => 'G', 'г' => 'g',
        'Д' => 'D', 'д' => 'd',
        'Ђ' => 'Đ', 'ђ' => 'đ',
        'Е' => 'E', 'е' => 'e',
        'Ж' => 'Ž', 'ж' => 'ž',
        'З' => 'Z', 'з' => 'z',
        'И' => 'I', 'и' => 'i',
        'Ј' => 'J', 'ј' => 'j',
        'К' => 'K', 'к' => 'k',
        'Л' => 'L', 'л' => 'l',
        'Љ' => 'Lj', 'љ' => 'lj',
        'М' => 'M', 'м' => 'm',
        'Н' => 'N', 'н' => 'n',
        'Њ' => 'Nj', 'њ' => 'nj',
        'О' => 'O', 'о' => 'o',
        'П' => 'P', 'п' => 'p',
        'Р' => 'R', 'р' => 'r',
        'С' => 'S', 'с' => 's',
        'Т' => 'T', 'т' => 't',
        'Ћ' => 'Ć', 'ћ' => 'ć',
        'У' => 'U', 'у' => 'u',
        'Ф' => 'F', 'ф' => 'f',
        'Х' => 'H', 'х' => 'h',
        'Ц' => 'C', 'ц' => 'c',
        'Ч' => 'Č', 'ч' => 'č',
        'Џ' => 'Dž', 'џ' => 'dž',
        'Ш' => 'Š', 'ш' => 'š'
    ];

    // Mapa latinica -> ćirilica
    private static $latinToCyrillic = [
        'A' => 'А', 'a' => 'а',
        'B' => 'Б', 'b' => 'б',
        'V' => 'В', 'v' => 'в',
        'G' => 'Г', 'g' => 'г',
        'D' => 'Д', 'd' => 'д',
        'Đ' => 'Ђ', 'đ' => 'ђ',
        'E' => 'Е', 'e' => 'е',
        'Ž' => 'Ж', 'ž' => 'ж',
        'Z' => 'З', 'z' => 'з',
        'I' => 'И', 'i' => 'и',
        'J' => 'Ј', 'j' => 'ј',
        'K' => 'К', 'k' => 'к',
        'L' => 'Л', 'l' => 'л',
        'M' => 'М', 'm' => 'м',
        'N' => 'Н', 'n' => 'н',
        'O' => 'О', 'o' => 'о',
        'P' => 'П', 'p' => 'п',
        'R' => 'Р', 'r' => 'р',
        'S' => 'С', 's' => 'с',
        'T' => 'Т', 't' => 'т',
        'Ć' => 'Ћ', 'ć' => 'ћ',
        'U' => 'У', 'u' => 'у',
        'F' => 'Ф', 'f' => 'ф',
        'H' => 'Х', 'h' => 'х',
        'C' => 'Ц', 'c' => 'ц',
        'Č' => 'Ч', 'č' => 'ч',
        'Š' => 'Ш', 'š' => 'ш',
        // Specijalni slučajevi za složena slova
        'Lj' => 'Љ', 'lj' => 'љ', 'LJ' => 'Љ',
        'Nj' => 'Њ', 'nj' => 'њ', 'NJ' => 'Њ',
        'Dž' => 'Џ', 'dž' => 'џ', 'DŽ' => 'Џ'
    ];

    /**
     * Pretvori ćirilicu u latinicu
     */
    public static function cyrillicToLatin(string $text): string
    {
        return strtr($text, self::$cyrillicToLatin);
    }

    /**
     * Pretvori latinicu u ćirilicu
     */
    public static function latinToCyrillic(string $text): string
    {
        // Prvo složena slova (Lj, Nj, Dž)
        $text = str_replace(['Lj', 'lj', 'LJ'], ['Љ', 'љ', 'Љ'], $text);
        $text = str_replace(['Nj', 'nj', 'NJ'], ['Њ', 'њ', 'Њ'], $text);
        $text = str_replace(['Dž', 'dž', 'DŽ'], ['Џ', 'џ', 'Џ'], $text);
        
        // Zatim jednostavna slova
        return strtr($text, self::$latinToCyrillic);
    }

    /**
     * Detektuj da li je tekst ćirilica
     */
    public static function isCyrillic(string $text): bool
    {
        return preg_match('/[\x{0400}-\x{04FF}]/u', $text) > 0;
    }

    /**
     * Detektuj da li je tekst latinica (srpska)
     */
    public static function isLatin(string $text): bool
    {
        return preg_match('/[ćčđšžĆČĐŠŽ]/u', $text) > 0;
    }

    /**
     * Auto-detektuj i pretvori u suprotno pismo
     */
    public static function autoTransliterate(string $text): string
    {
        if (self::isCyrillic($text)) {
            return self::cyrillicToLatin($text);
        } elseif (self::isLatin($text)) {
            return self::latinToCyrillic($text);
        }
        
        return $text; // Nema promena ako nije detektovano
    }

    /**
     * Generiši oba pisma odjednom
     */
    public static function generateBothScripts(string $text): array
    {
        if (self::isCyrillic($text)) {
            return [
                'cyrillic' => $text,
                'latin' => self::cyrillicToLatin($text)
            ];
        } elseif (self::isLatin($text)) {
            return [
                'latin' => $text,
                'cyrillic' => self::latinToCyrillic($text)
            ];
        }
        
        // Ako nije detektovano, pretpostavi latinicu
        return [
            'latin' => $text,
            'cyrillic' => self::latinToCyrillic($text)
        ];
    }
}

