<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Word Frequency Counter</h1>
    
    <form action="" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea id="text" name="text" rows="10" cols="50" required><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''; ?></textarea><br><br>
        
        <label for="sort">Sort by frequency:</label>
        <select id="sort" name="sort">
            <option value="asc" <?php echo (isset($_POST['sort']) && $_POST['sort'] === 'asc') ? 'selected' : ''; ?>>Ascending</option>
            <option value="desc" <?php echo (isset($_POST['sort']) && $_POST['sort'] === 'desc') ? 'selected' : ''; ?>>Descending</option>
        </select><br><br>
        
        <label for="limit">Number of words to display:</label>
        <input type="number" id="limit" name="limit" value="<?php echo isset($_POST['limit']) ? htmlspecialchars($_POST['limit']) : '10'; ?>" min="1"><br><br>
        
        <input type="submit" name="calculate" value="Calculate Word Frequency">
    </form>

    <?php
    if (isset($_POST['calculate'])) {
        // Function to calculate word frequencies
        function calculateWordFrequency($text) {
            // Define common stop words to ignore
            $stopWords = ["the", "and", "in", "of", "a", "to", "is", "it"];

            // Tokenize the text into words
            $words = str_word_count($text, 1);

            // Remove stop words
            $filteredWords = array_diff($words, $stopWords);

            // Count word frequencies
            $wordFrequencies = array_count_values($filteredWords);

            return $wordFrequencies;
        }

        $text = $_POST["text"];
        $sortOrder = $_POST["sort"];
        $limit = $_POST["limit"];

        $wordFrequencies = calculateWordFrequency($text);

        // Sort word frequencies based on user selection
        if ($sortOrder === "asc") {
            asort($wordFrequencies);
        } else {
            arsort($wordFrequencies);
        }

        // Display the top N words based on the user's input
        echo "<h2>Word Frequency Results:</h2>";
        echo "<table>";
        echo "<tr><th>Word</th><th>Frequency</th></tr>";

        $count = 0;
        foreach ($wordFrequencies as $word => $frequency) {
            if ($count >= $limit) {
                break;
            }
            echo "<tr><td>$word</td><td>$frequency</td></tr>";
            $count++;
        }

        echo "</table>";
    }
    ?>
</body>
</html>
