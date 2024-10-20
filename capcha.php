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
    
    // echo "\n";
    // echo $height;
    // echo "\n";
    // echo $width;
    // echo "\n";
    

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

// Функция для проверки, является ли фигура кругом
function isCircle($image) {
    $height = count($image);
    $width = count($image[0]);
    $radius = min($height, $width) / 2; // Определяем максимальный возможный радиус
    $centerX = $width / 2;
    $centerY = $height / 2;

    $pointsOnEdge = 0;
    for ($y = 1; $y < $height; $y++) {
        for ($x = 1; $x < $width; $x++) {
            if ($image[$y][$x] === 1) {
                // Вычисление расстояния от центра до точки
                $distance = sqrt(pow($x - $centerX, 2) + pow($y - $centerY, 2));
                // Проверка, находится ли точка на границе круга
                if (abs($distance - $radius) < 2) { // Допустимая ошибка для округления
                    $pointsOnEdge++;
                }
            }
        }
    }

    // Если достаточно точек на границе, принимаем это за круг
    return $pointsOnEdge > 0.75 * M_PI * pow($radius, 2); // Примерная площадь круга
}

// Функция для проверки, является ли фигура треугольником
function isTriangle($image) {
    $height = count($image);
    $width = count($image[0]);

    $corners = [];
    // Ищем все углы (где изображение равно 1)
    for ($y = 1; $y < $height-1; $y++) {
        for ($x = 1; $x < $width-1; $x++) {
            if ($image[$y][$x] === 1) {
                $corners[] = [$x, $y]; // Сохраняем координаты углов
            }
        }
    }

    // Проверяем, что найдено ровно три угла
    if (count($corners) !== 3) {
        return false; // Если углов не три, не треугольник
    }

    // Проверка условий треугольника
    // Здесь можно добавить логику для вычисления длины сторон и углов
    // Например, вычисление длины сторон и проверка по формуле косинусов

    return true; // Если условия выполнены, возвращаем true
}


    // Определяем фигуру
    if (isSquare($image)) {
        return "\nsquare";
    } elseif (isCircle($image)) {
        return "\ncircle";
    } elseif (isTriangle($image)) {
        return "\ntriangle";
    }

    return "\nunknown";
}

// Пример использования
// $square = "10 10\n0 0 0 0 0 0 0 0 0 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 1 1 1 1 1 1 1 1 0\n0 0 0 0 0 0 0 0 0 0";
// echo $square;
$circle = "11 11\n0 0 0 0 0 0 0 0 0 0 0\n0 0 0 0 0 1 0 0 0 0 0\n0 0 0 0 1 1 1 0 0 0 0\n0 0 0 1 1 1 1 1 0 0 0\n0 0 1 1 1 1 1 1 1 0 0\n0 1 1 1 1 1 1 1 1 1 0\n0 0 1 1 1 1 1 1 1 0 0\n0 0 0 1 1 1 1 1 0 0 0\n0 0 0 0 1 1 1 0 0 0 0\n0 0 0 0 0 1 0 0 0 0 0\n0 0 0 0 0 0 0 0 0 0 0";
echo $circle;
echo detectShape($circle);
?>
