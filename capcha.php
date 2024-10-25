<?php
function detectShape($data) {
    // Разобьем входные данные на строки
    $lines = explode("\n", trim($data));
    
    // Получим размеры изображения
    list($X, $Y) = explode(" ", array_shift($lines));

    // Преобразуем строки в двумерный массив
    $image = [];
    foreach ($lines as $line) {
        $image[] = array_map('intval', explode(" ", $line));
    }
    

    // Функция для проверки, является ли фигура квадратом
function isSquare($image) {
    $height = count($image)-1;
    $width = count($image[0])-1;
  
    

    if ($width !== $height) {
        return false; // Не квадрат, если ширина не равна высоте
    }

    // Проверим, заполнена ли вся квадратная область
    for ($i = 1; $i < $height; $i++) {
        for ($j = 1; $j < $width; $j++) {
            if ($image[$i][$j] == 0) {
                return false; // Если есть пустое место, это не квадрат
            }
        }
    }

    return true; // Если все проверки пройдены, это квадрат
}

    // Определяем фигуру
    if (isSquare($image)) {
        return "\nsquare";
    } 

    return "\nunknown";
}

// Пример использования
$square = "10 10\n0 0 0 0 0 0 0 0 0 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 0 0 0 0 0 0 0 0 0";
echo $square;
echo detectShape($square);
?>
