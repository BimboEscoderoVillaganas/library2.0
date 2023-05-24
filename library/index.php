<?php

//Developed BY: Villaganas, Bimbo, Escodero.
// Function to connect to the database
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

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

// Save book information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectDB();

    $title = $_POST["title"];
    $author_FirstName = $_POST["author_FirstName"];
    $author_LastName = $_POST["author_LastName"];
    $publisher_FirstName = $_POST["publisher_FirstName"];
    $publisher_LastName = $_POST["publisher_LastName"];
    $isbn = $_POST["isbn"];

    $sql = "INSERT INTO books (title, author_FirstName, author_LastName, publisher_FirstName, publisher_LastName, isbn) VALUES ('$title', '$author_FirstName', '$author_LastName', '$publisher_FirstName', '$publisher_LastName', '$isbn')";

    if ($conn->query($sql) === TRUE) {
        $message = "Book information saved successfully.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Book Information</title>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Add Book</a>
        <a href="books_list.php">View Books</a>
    </div>
    <h1>Book Information</h1>

    <div class="container">
        <div class="form-container">
            <h2>Add Book</h2>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="author_FirstName">Author First Name:</label>
                <input type="text" id="author_FirstName" name="author_FirstName" required>

                <label for="author_LastName">Author Last Name:</label>
                <input type="text" id="author_LastName" name="author_LastName" required>

                <label for="publisher_FirstName">Publisher First Name:</label>
                <input type="text" id="publisher_FirstName" name="publisher_FirstName" required>

                <label for="publisher_LastName">Publisher Last Name:</label>
                <input type="text" id="publisher_LastName" name="publisher_LastName" required>

                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" required>

                <input type="submit" value="Save Book">
            </form>

            <?php if (isset($message)) { ?>
                <p class="message"><?php echo $message; ?></p>
            <?php } ?>
        </div>

        <div class="table-container">
            <h2>Books</h2>

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
        </div>
    </div>
</body>
</html>
