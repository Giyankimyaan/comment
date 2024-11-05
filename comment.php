<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Book</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border 0.3s;
        }

        textarea {
            resize: vertical;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }


        .comments {
            margin-top: 40px;
            width: 100%;
            max-width: 600px;
        }

        .comment {
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 6px;
        }

        .comment p {
            margin-bottom: 10px;
        }


        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }
            h1 {
                font-size: 24px;
            }
            input[type="text"],
            textarea {
                font-size: 14px;
            }
            input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>


    <div class="form-container">
        <h1>Sign the Guest Book</h1>
        <form action="addcomment.php" method="post" name="guest" onsubmit="return Validate();">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required />

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required />

            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="6" required></textarea>

            <input type="submit" value="Sign this in the Book" />
        </form>
    </div>


    <div class="comments">
        <?php

        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "mydb";
        $con = mysqli_connect($host, $user, $pass, $dbname);

        if (mysqli_connect_errno()) {
            echo "<h1>Failed to connect to MySQL: " . mysqli_connect_error() . "</h1>";
            exit();
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            $sql = "INSERT INTO guestbook (name, email, message) VALUES ('$name', '$email', '$message')";

            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            } else {
                echo "<p>Comment added successfully!</p>";
            }
        }
        $sql = "SELECT name, message FROM guestbook ORDER BY id DESC";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='comment'>";
                echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong></p>";
                echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No comments yet. Be the first to leave one!</p>";
        }

        mysqli_close($con);
        ?>
    </div>

    <script type="text/javascript">
        // <![CDATA[
        function Validate() {
            var x = document.forms["guest"]["email"].value;
            var y = document.forms["guest"]["name"].value;
            if (y == null || y == "") {
                alert("Please enter your Name!");
                return false;
            }
            if (x == null || x == "") {
                alert("Please enter your email address!");
                return false;
            }

            var atpos = x.indexOf("@");
            var dotpos = x.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
                alert("Not a valid e-mail address");
                return false;
            } else {
                return true;
            }
        }
        // ]]>
    </script>

</body>
</html>
