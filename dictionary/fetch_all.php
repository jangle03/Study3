<?php include '../check.php';

$userId = $_SESSION['user_id'];

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'eng';
$liked = isset($_GET['liked']) ? $_GET['liked'] : false;
$WordSearch = isset($_GET['query']) ? $_GET['query'] : '';
$WordSearch = strtolower($WordSearch);

$results = [];

if ($lang == 'uz') {
    if (!empty($WordSearch)) {
        $queryParam = $query->validate($WordSearch);
        $results = $query->search(
            'words',
            '*',
            "WHERE user_id = ? AND translation LIKE ?",
            [$userId, "%$queryParam%"],
            "is"
        );
    } else {
        $results = $query->select(
            'words',
            '*',
            'WHERE user_id = ? ORDER BY translation ASC',
            [$userId],
            'i'
        );
    }
} else {
    if (!empty($WordSearch)) {
        $queryParam = $query->validate($WordSearch);
        $results = $query->search(
            'words',
            '*',
            "WHERE user_id = ? AND word LIKE ?",
            [$userId, "%$queryParam%"],
            "is"
        );
    } else {
        $results = $query->select(
            'words',
            '*',
            'WHERE user_id = ? ORDER BY word ASC',
            [$userId],
            'i'
        );
    }
}

$likedWords = $query->search('liked_words', 'word_id', 'WHERE user_id = ?', [$userId], 'i');
$likedWordIds = array_column($likedWords, 'word_id');

if ($liked) {
    $results = [];
    foreach ($likedWords as $row) {
        $wordId = $row['word_id'];
        $queryResult = $query->select('words', '*', "WHERE id = ? AND user_id = ?", [$wordId, $userId], 'ii');
        if ($queryResult) {
            $results = array_merge($results, $queryResult);
        }
    }
}

if ($results) {
    usort($results, function ($a, $b) use ($WordSearch) {
        $wordSearchLower = strtolower($WordSearch);
        $aStartsWith = strtolower(substr($a['word'], 0, strlen($wordSearchLower))) === $wordSearchLower;
        $bStartsWith = strtolower(substr($b['word'], 0, strlen($wordSearchLower))) === $wordSearchLower;

        if ($aStartsWith && !$bStartsWith)
            return -1;
        if (!$aStartsWith && $bStartsWith)
            return 1;

        return strcmp(strtolower($a['word']), strtolower($b['word']));
    });


    $html = "<ul>";
    foreach ($results as $index => $row) {
        $isExpanded = isset($expandedSentences[$row['id']]) ? 'expanded' : '';
        $list_id = "list_" . $index;
        $wordId = "word_" . $index;
        $likeId = "heart_" . $index;
        $text = $lang == 'uz' ? htmlspecialchars($row['translation']) : htmlspecialchars($row['word']);
        $isLiked = in_array($row['id'], $likedWordIds);

        $html .= "<div class='list' id='{$list_id}'>
            <li id='{$wordId}' class='{$isExpanded}' onclick='toggleExpand(this)'>" .
            str_ireplace($WordSearch, "<span class='highlight'>{$WordSearch}</span>", $text) . "</li>
            <div class='buttons'>
                <i class='fas fa-volume-up' onclick=\"speakText('{$wordId}')\"></i>
                <i class='fas fa-heart " . ($isLiked ? 'liked' : '') . "' id='{$likeId}' onclick=\"Liked('{$likeId}', '{$row['id']}')\"></i>
                <i class='fas fa-info-circle' onclick='showInfo(" . json_encode([
                "word" => $row["word"],
                "translation" => $row["translation"],
                "definition" => $row["definition"],
                "list_id" => $list_id,
                "id" => $row['id']
            ], JSON_HEX_APOS | JSON_HEX_QUOT) . ")'></i>
            </div>
        </div>";
    }
    $html .= "</ul>";
    echo $html;
} else {

    ?>

    <div class="information-not-found">
        <i class="fa fa-info-circle"></i>
        <p>There are no words.</p>
        <a href="../dictionary/add.php" class="btn btn-primary">Add Words</a>
    </div>

<?php } ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../src/css/root.css">
<link rel="stylesheet" href="../src/css/fetch_all.css">


<div id="infoModal" class="modal" onclick="closeModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="modalWord" class="modal-section"></div>
        <div id="modalTranslation" class="modal-section"></div>
        <div id="modalDefinition" class="modal-section"></div>
        <div class="modal-buttons">
            <a class="sentences" onclick="sentences()">
                Sentences
            </a>

            <div class="btn">
                <i class='fas fa-volume-up' onclick="speakText('modal')"></i>
                <i class='fas fa-edit' onclick="editWord()"></i>
                <i class="fa-solid fa-trash" onclick="deleteDefinition()"></i>
            </div>
        </div>
    </div>
</div>

<script src="../src/js/fetch_all-dictionary.js"></script>