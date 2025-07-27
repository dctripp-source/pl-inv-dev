<?php
// app/helpers.php - Твој постојећи фајл + нове функције

if (!function_exists('getCurrentScript')) {
    function getCurrentScript()
    {
        return app()->getLocale() === 'cir' ? 'cyrillic' : 'latin';
    }
}

if (!function_exists('getLocalizedText')) {
    function getLocalizedText($latinText, $cyrillicText = null)
    {
        $script = getCurrentScript();
        
        if ($script === 'cyrillic' && $cyrillicText) {
            return $cyrillicText;
        }
        
        return $latinText;
    }
}

if (!function_exists('__sr')) {
    /**
     * Translate for Serbian with both Latin and Cyrillic scripts
     * 
     * @param string $key
     * @param string $latin
     * @param string $cyrillic
     * @return string
     */
    function __sr($key, $latin, $cyrillic)
    {
        return getCurrentScript() === 'cyrillic' ? $cyrillic : $latin;
    }
}

// НОВА ФУНКЦИЈА ЗА АУТОМАТСКИ ПРЕВОД
if (!function_exists('convertScript')) {
    /**
     * Конвертује текст између латинице и ћирилице
     * 
     * @param string $text
     * @param string $targetScript ('latin' или 'cyrillic')
     * @return string
     */
    function convertScript($text, $targetScript)
    {
        if (empty($text)) {
            return $text;
        }

        // Мапа за превод латинице у ћирилицу
        $latinToCyrillic = [
            'a' => 'а', 'A' => 'А', 'b' => 'б', 'B' => 'Б', 'v' => 'в', 'V' => 'В',
            'g' => 'г', 'G' => 'Г', 'd' => 'д', 'D' => 'Д', 'đ' => 'ђ', 'Đ' => 'Ђ',
            'e' => 'е', 'E' => 'Е', 'ž' => 'ж', 'Ž' => 'Ж', 'z' => 'з', 'Z' => 'З',
            'i' => 'и', 'I' => 'И', 'j' => 'ј', 'J' => 'Ј', 'k' => 'к', 'K' => 'К',
            'l' => 'л', 'L' => 'Л', 'm' => 'м', 'M' => 'М', 'n' => 'н', 'N' => 'Н',
            'o' => 'о', 'O' => 'О', 'p' => 'п', 'P' => 'П', 'r' => 'р', 'R' => 'Р',
            's' => 'с', 'S' => 'С', 't' => 'т', 'T' => 'Т', 'ć' => 'ћ', 'Ć' => 'Ћ',
            'u' => 'у', 'U' => 'У', 'f' => 'ф', 'F' => 'Ф', 'h' => 'х', 'H' => 'Х',
            'c' => 'ц', 'C' => 'Ц', 'č' => 'ч', 'Č' => 'Ч', 'š' => 'ш', 'Š' => 'Ш',
        ];

        // Мапа за превод ћирилице у латиницу
        $cyrillicToLatin = [
            'а' => 'a', 'А' => 'A', 'б' => 'b', 'Б' => 'B', 'в' => 'v', 'В' => 'V',
            'г' => 'g', 'Г' => 'G', 'д' => 'd', 'Д' => 'D', 'ђ' => 'đ', 'Ђ' => 'Đ',
            'е' => 'e', 'Е' => 'E', 'ж' => 'ž', 'Ж' => 'Ž', 'з' => 'z', 'З' => 'Z',
            'и' => 'i', 'И' => 'I', 'ј' => 'j', 'Ј' => 'J', 'к' => 'k', 'К' => 'K',
            'л' => 'l', 'Л' => 'L', 'љ' => 'lj', 'Љ' => 'Lj', 'м' => 'm', 'М' => 'M',
            'н' => 'n', 'Н' => 'N', 'њ' => 'nj', 'Њ' => 'Nj', 'о' => 'o', 'О' => 'O',
            'п' => 'p', 'П' => 'P', 'р' => 'r', 'Р' => 'R', 'с' => 's', 'С' => 'S',
            'т' => 't', 'Т' => 'T', 'ћ' => 'ć', 'Ћ' => 'Ć', 'у' => 'u', 'У' => 'U',
            'ф' => 'f', 'Ф' => 'F', 'х' => 'h', 'Х' => 'H', 'ц' => 'c', 'Ц' => 'C',
            'ч' => 'č', 'Ч' => 'Č', 'џ' => 'dž', 'Џ' => 'Dž', 'ш' => 'š', 'Ш' => 'Š',
        ];

        // Проверава да ли је текст ћирилични
        $isCyrillic = preg_match('/[\p{Cyrillic}]/u', $text) > 0;

        if ($targetScript === 'cyrillic') {
            if ($isCyrillic) {
                return $text; // Већ је ћирилица
            }
            
            // Конвертуј сложене карактере прво
            $text = str_replace(['dž', 'Dž', 'DŽ'], ['џ', 'Џ', 'Џ'], $text);
            $text = str_replace(['lj', 'Lj', 'LJ'], ['љ', 'Љ', 'Љ'], $text);
            $text = str_replace(['nj', 'Nj', 'NJ'], ['њ', 'Њ', 'Њ'], $text);
            $text = str_replace(['dj', 'Dj', 'DJ'], ['ђ', 'Ђ', 'Ђ'], $text);
            
            return strtr($text, $latinToCyrillic);
        }

        if ($targetScript === 'latin') {
            if (!$isCyrillic) {
                return $text; // Већ је латиница
            }
            
            return strtr($text, $cyrillicToLatin);
        }

        return $text;
    }
}