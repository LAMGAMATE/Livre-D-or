<!DOCTYPE html>
<html>
<head>
    <title>Form</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 500px; margin: 0 auto; background-color: #ffcc00; padding: 20px; border-radius: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; }
        .comments { margin-top: 20px; }
        .comment { background-color: #fff; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; }
        .comment-header { font-weight: bold; }
        .comment-date { font-size: 0.9em; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Donnez votre avis sur PHP 8 !</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="email">Mail :</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="comment">Vos commentaires sur le site :</label>
                <textarea id="comment" name="comment" rows="4" ></textarea>
            </div>
            <button type="submit" name="submit">Envoyer</button>
            <button type="submit" name="show">Afficher les avis</button>
        </form>

        <h3>Les cinq premiers avis</h3>
        <div class="comments">
            <?php
            $filename = 'comments.txt';

            if (!file_exists($filename)) {
                file_put_contents($filename, '');
            }

            $comments = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if (isset($_POST['submit'])) {
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $comment = htmlspecialchars($_POST['comment']);
                $date = date('Y-m-d H:i:s');
                $new_comment = "$name|$email|$comment|$date";

                $comments[] = $new_comment;

                file_put_contents($filename, implode(PHP_EOL, $comments) . PHP_EOL);
            }

            if (isset($_POST['show'])) {
                $display_comments = array_slice($comments, 0, 5);
                foreach ($display_comments as $comment) {
                    list($name, $email, $commentText, $date) = explode('|', $comment);
                    echo '<div class="comment">';
                    echo '<div class="comment-header">' . htmlspecialchars($name) . ' (' . htmlspecialchars($email) . ')</div>';
                    echo '<div class="comment-date">' . htmlspecialchars($date) . '</div>';
                    echo '<div class="comment-body">' . nl2br(htmlspecialchars($commentText)) . '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>