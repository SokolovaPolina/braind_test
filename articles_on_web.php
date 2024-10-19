<?php
// Проверить можно на спринтхосте: http://a1033270.xsph.ru/index.php
// инициализируем базу данных
$db_host='localhost'; // хост
$db_name='a1033270_mybd'; // бд
$db_user='a1033270_mybd'; // пользователь бд
$db_pass='123456789'; // пароль к бд
// включаем сообщения об ошибках
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// коннект с сервером бд
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name); 
// задаем кодировку
$conn->set_charset("utf8mb4");

/// функция выведения анонса
function generateAnnounce(string $content, int $maxLength = 250): string {
    // Удаляем пробелы в начале и конце текста
    $content = trim($content);

    // Обрезаем текст до максимальной длины с учетом многоточия
    if (mb_strlen($content) > $maxLength - 3) {
        $announce = mb_substr($content, 0, $maxLength - 3) . '...';
    } else {
        $announce = $content;
    }

    return $announce; // Возвращаем анонс
}

// Проверяем, передан ли id_article
if (isset($_GET['id_article'])) {
    $id = (int)$_GET['id_article'];
    $sql = "SELECT * FROM articles WHERE id_article = $id";

    if ($result = $conn->query($sql)) {
        if ($row = $result->fetch_assoc()) {
            echo "<h1>" . htmlspecialchars($row['title']) . "</h1>";
            echo "<p><strong>Анонс:</strong> " . htmlspecialchars($row['announce']) . "</p>";
            echo "<p><strong>Содержимое:</strong> " . htmlspecialchars($row['content']) . "</p>";
            echo "<p><strong>Дата создания:</strong> " . htmlspecialchars($row["date_created"]) . "</p>";
        } else {
            echo "Статья не найдена.";
        }
        $result->free();
    } else {
        echo "Ошибка: " . $conn->error;
    }
} else {
    // Если id_article не задан, показываем список статей
    $sql = "SELECT * FROM articles";
    if ($result = $conn->query($sql)) {
        echo "<table><tr><th>Id</th><th>Название</th><th>Анонс</th><th>Дата создания</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
                echo "<td>" . $row["id_article"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . generateAnnounce($row['announce']) . "<a href='?id_article=" . $row['id_article'] . "'>[Читать далее]</a></td>";
                echo "<td>" . $row["date_created"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        $result->free();
    } else {
        echo "Ошибка: " . $conn->error;
    }
}

$conn->close();
?>
