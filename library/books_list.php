<?php

//Developed BY: Villaganas, Bimbo, Escodero.
// Function to connect to the database
require_once('db_connection.php');

// Function to retrieve all books
function getBooks() {
    $conn = connectDB();

    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);

    $books = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    $conn->close();

    return $books;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>View Books</title>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Add Book</a>
        <a href="books_list.php">View Books</a>
    </div>
    <h1>View Books</h1>

    <table>
        <tr>
            <th>Title</th>
            <th>Author First Name</th>
            <th>Author Last Name</th>
            <th>Publisher First Name</th>
            <th>Publisher Last Name</th>
            <th>ISBN</th>
        </tr>
        <?php
        $books = getBooks();
        foreach ($books as $book) {
            echo "<tr>";
            echo "<td>" . $book["title"] . "</td>";
            echo "<td>" . $book["author_FirstName"] . "</td>";
            echo "<td>" . $book["author_LastName"] . "</td>";
            echo "<td>" . $book["publisher_FirstName"] . "</td>";
            echo "<td>" . $book["publisher_LastName"] . "</td>";
            echo "<td>" . $book["isbn"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>
