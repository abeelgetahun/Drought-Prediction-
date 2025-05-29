<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Log the request
error_log("Search request: " . print_r($_GET, true));

try {
    require_once 'config/db.php';
    
    $query = isset($_GET['q']) ? trim($_GET['q']) : '';
    $filter = isset($_GET['filter']) ? trim($_GET['filter']) : 'all';
    
    error_log("Search query: '$query', filter: '$filter'");
    
    $results = [];
    
    if (strlen($query) >= 1) {
        $search_param = "%" . $query . "%";

        // Search News
        if ($filter === 'all' || $filter === 'news') {
            $sql_news = "SELECT 'news' as type, id, title, content, publish_date as date FROM news WHERE title LIKE ? OR content LIKE ? ORDER BY publish_date DESC LIMIT 10";
            if ($stmt = $mysqli->prepare($sql_news)) {
                $stmt->bind_param("ss", $search_param, $search_param);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $row['excerpt'] = mb_substr(strip_tags($row['content']), 0, 150) . '...';
                    $row['url'] = 'pages/news.php#news-' . $row['id'];
                    $results[] = $row;
                }
                $stmt->close();
                error_log("Found " . count($results) . " news results");
            } else {
                error_log("Failed to prepare news query: " . $mysqli->error);
            }
        }

        // Search Events
        if ($filter === 'all' || $filter === 'events') {
            $sql_events = "SELECT 'events' as type, id, name as title, description as content, event_date as date FROM events WHERE name LIKE ? OR description LIKE ? ORDER BY event_date DESC LIMIT 10";
            if ($stmt = $mysqli->prepare($sql_events)) {
                $stmt->bind_param("ss", $search_param, $search_param);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $row['excerpt'] = mb_substr(strip_tags($row['content']), 0, 150) . '...';
                    $row['url'] = 'pages/events.php#event-' . $row['id'];
                    $results[] = $row;
                }
                $stmt->close();
            } else {
                error_log("Failed to prepare events query: " . $mysqli->error);
            }
        }

        // Search Researchers
        if ($filter === 'all' || $filter === 'researchers') {
            $sql_researchers = "SELECT 'researchers' as type, id, name as title, bio as content, NULL as date FROM researchers WHERE name LIKE ? OR bio LIKE ? OR research_focus LIKE ? LIMIT 10";
            if ($stmt = $mysqli->prepare($sql_researchers)) {
                $stmt->bind_param("sss", $search_param, $search_param, $search_param);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $row['excerpt'] = mb_substr(strip_tags($row['content']), 0, 150) . '...';
                    $row['url'] = 'pages/researchers.php#researcher-' . $row['id'];
                    $row['date'] = ''; // No date field
                    $results[] = $row;
                }
                $stmt->close();
            } else {
                error_log("Failed to prepare researchers query: " . $mysqli->error);
            }
        }

        // Search Stories
        if ($filter === 'all' || $filter === 'stories') {
            $sql_stories = "SELECT 'stories' as type, id, title, narrative as content, publish_date as date FROM stories WHERE title LIKE ? OR author LIKE ? OR narrative LIKE ? ORDER BY publish_date DESC LIMIT 10";
            if ($stmt = $mysqli->prepare($sql_stories)) {
                $stmt->bind_param("sss", $search_param, $search_param, $search_param);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $row['excerpt'] = mb_substr(strip_tags($row['content']), 0, 150) . '...';
                    $row['url'] = 'pages/stories.php#story-' . $row['id'];
                    $results[] = $row;
                }
                $stmt->close();
            } else {
                error_log("Failed to prepare stories query: " . $mysqli->error);
            }
        }

        // Search Focus
        if ($filter === 'all' || $filter === 'focus') {
            $sql_focus = "SELECT 'focus' as type, id, name as title, description as content, NULL as date FROM focus WHERE name LIKE ? OR description LIKE ? LIMIT 10";
            if ($stmt = $mysqli->prepare($sql_focus)) {
                $stmt->bind_param("ss", $search_param, $search_param);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $row['excerpt'] = mb_substr(strip_tags($row['content']), 0, 150) . '...';
                    $row['url'] = 'pages/focus.php#focus-' . $row['id'];
                    $row['date'] = ''; // No date field
                    $results[] = $row;
                }
                $stmt->close();
            } else {
                error_log("Failed to prepare focus query: " . $mysqli->error);
            }
        }

        
    }
    
    $mysqli->close();
    
    // Sort results by relevance
    usort($results, function($a, $b) use ($query) {
        $aTitle = stripos($a['title'], $query) !== false ? 1 : 0;
        $bTitle = stripos($b['title'], $query) !== false ? 1 : 0;
        
        if ($aTitle !== $bTitle) {
            return $bTitle - $aTitle;
        }
        
        return strtotime($b['date']) - strtotime($a['date']);
    });
    
    $response = [
        'success' => true,
        'results' => array_slice($results, 0, 20),
        'total' => count($results),
        'query' => $query,
        'filter' => $filter,
        'debug' => [
            'query_length' => strlen($query),
            'results_count' => count($results)
        ]
    ];
    
    error_log("Sending response: " . json_encode($response));
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("Search error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'debug' => [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ]);
}
?>