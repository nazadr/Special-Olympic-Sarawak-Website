<?php
/**
 * Admin Dashboard Data Handler
 * Aggregates statistics from multiple tables for dashboard display
 */

header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$action = $_GET['action'] ?? $_POST['action'] ?? 'fetch_all';

try {
    switch ($action) {
        case 'fetch_all':
            $data = [
                'success' => true,
                'participants' => getParticipantsStats($conn),
                'chapters' => getChaptersStats($conn),
                'events' => getEventsStats($conn),
                'media' => getMediaStats($conn),
                'content' => getContentStats($conn),
                'sponsors' => getSponsorsStats($conn),
                'recent_activities' => getRecentActivities($conn)
            ];
            echo json_encode($data);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

$conn->close();

/**
 * Get participants statistics from chapter_participants table
 */
function getParticipantsStats($conn) {
    // Get the latest year with data
    $latest_year_result = $conn->query("SELECT MAX(year) as latest_year FROM chapter_participants");
    $latest_year_row = $latest_year_result->fetch_assoc();
    $year = $latest_year_row['latest_year'] ?? date('Y');
    
    $sql = "SELECT 
                SUM(athletes_male) as athletes_male,
                SUM(athletes_female) as athletes_female,
                SUM(athletes_total) as athletes_total,
                SUM(coaches_male) as coaches_male,
                SUM(coaches_female) as coaches_female,
                SUM(coaches_total) as coaches_total,
                SUM(volunteers_male) as volunteers_male,
                SUM(volunteers_female) as volunteers_female,
                SUM(volunteers_total) as volunteers_total,
                SUM(total_participants) as total_participants
            FROM chapter_participants 
            WHERE year = $year";
    
    $result = $conn->query($sql);
    $stats = $result->fetch_assoc();
    
    // Get chapter breakdown
    $breakdown_sql = "SELECT 
                        c.chapter_name,
                        c.city,
                        cp.athletes_total,
                        cp.coaches_total,
                        cp.volunteers_total,
                        cp.total_participants
                      FROM chapter_participants cp
                      JOIN sarawak_chapters c ON cp.chapter_id = c.id
                      WHERE cp.year = $year
                      ORDER BY cp.total_participants DESC";
    
    $breakdown_result = $conn->query($breakdown_sql);
    $breakdown = [];
    while ($row = $breakdown_result->fetch_assoc()) {
        $breakdown[] = $row;
    }
    
    return [
        'totals' => $stats,
        'by_chapter' => $breakdown,
        'year' => $year
    ];
}

/**
 * Get chapters statistics
 */
function getChaptersStats($conn) {
    $total = $conn->query("SELECT COUNT(*) as count FROM sarawak_chapters")->fetch_assoc()['count'];
    $active = $conn->query("SELECT COUNT(*) as count FROM sarawak_chapters WHERE status = 'active'")->fetch_assoc()['count'];
    $upcoming = $conn->query("SELECT COUNT(*) as count FROM sarawak_chapters WHERE status = 'upcoming'")->fetch_assoc()['count'];
    
    return [
        'total' => $total,
        'active' => $active,
        'upcoming' => $upcoming
    ];
}

/**
 * Get events statistics
 */
function getEventsStats($conn) {
    $total = $conn->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];
    
    // Upcoming events (future dates)
    $upcoming = $conn->query("SELECT COUNT(*) as count FROM events WHERE event_date >= CURDATE()")->fetch_assoc()['count'];
    
    // Past events
    $past = $conn->query("SELECT COUNT(*) as count FROM events WHERE event_date < CURDATE()")->fetch_assoc()['count'];
    
    // Events by type
    $by_type = [];
    $type_result = $conn->query("SELECT type, COUNT(*) as count FROM events GROUP BY type");
    while ($row = $type_result->fetch_assoc()) {
        $by_type[$row['type']] = $row['count'];
    }
    
    // Next upcoming event
    $next_event = $conn->query("SELECT title, event_date, location FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 1")->fetch_assoc();
    
    return [
        'total' => $total,
        'upcoming' => $upcoming,
        'past' => $past,
        'by_type' => $by_type,
        'next_event' => $next_event
    ];
}

/**
 * Get media statistics
 */
function getMediaStats($conn) {
    // Photos
    $total_photos = $conn->query("SELECT COUNT(*) as count FROM gallery_photos")->fetch_assoc()['count'];
    $photo_collections = $conn->query("SELECT COUNT(*) as count FROM gallery_photos_collection")->fetch_assoc()['count'];
    
    // Videos
    $total_videos = $conn->query("SELECT COUNT(*) as count FROM gallery_videos")->fetch_assoc()['count'];
    $video_collections = $conn->query("SELECT COUNT(*) as count FROM gallery_videos_collection")->fetch_assoc()['count'];
    
    // Recent uploads (last 30 days)
    $recent_photos = $conn->query("SELECT COUNT(*) as count FROM gallery_photos WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->fetch_assoc()['count'];
    $recent_videos = $conn->query("SELECT COUNT(*) as count FROM gallery_videos WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->fetch_assoc()['count'];
    
    return [
        'photos' => [
            'total' => $total_photos,
            'collections' => $photo_collections,
            'recent' => $recent_photos
        ],
        'videos' => [
            'total' => $total_videos,
            'collections' => $video_collections,
            'recent' => $recent_videos
        ],
        'total_media' => $total_photos + $total_videos
    ];
}

/**
 * Get content statistics
 */
function getContentStats($conn) {
    $total_news = $conn->query("SELECT COUNT(*) as count FROM news")->fetch_assoc()['count'];
    $total_sports = $conn->query("SELECT COUNT(*) as count FROM sports")->fetch_assoc()['count'];
    $total_state_games = $conn->query("SELECT COUNT(*) as count FROM state_games")->fetch_assoc()['count'];
    
    // Recent news (last 30 days)
    $recent_news = $conn->query("SELECT COUNT(*) as count FROM news WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->fetch_assoc()['count'];
    
    // Check if program tables exist
    $alp_count = 0;
    $hap_count = 0;
    $yap_count = 0;
    
    $tables = $conn->query("SHOW TABLES LIKE '%_articles'");
    while ($table = $tables->fetch_array()) {
        $table_name = $table[0];
        if (strpos($table_name, 'alp') !== false) {
            $alp_count = $conn->query("SELECT COUNT(*) as count FROM $table_name")->fetch_assoc()['count'];
        } elseif (strpos($table_name, 'hap') !== false) {
            $hap_count = $conn->query("SELECT COUNT(*) as count FROM $table_name")->fetch_assoc()['count'];
        } elseif (strpos($table_name, 'yap') !== false) {
            $yap_count = $conn->query("SELECT COUNT(*) as count FROM $table_name")->fetch_assoc()['count'];
        }
    }
    
    return [
        'news' => $total_news,
        'sports' => $total_sports,
        'state_games' => $total_state_games,
        'programs' => [
            'alp' => $alp_count,
            'hap' => $hap_count,
            'yap' => $yap_count
        ],
        'recent_news' => $recent_news
    ];
}

/**
 * Get sponsors statistics
 */
function getSponsorsStats($conn) {
    // Check if new columns exist
    $columns_check = $conn->query("SHOW COLUMNS FROM sponsorships LIKE 'chapter_id'");
    $has_new_columns = $columns_check->num_rows > 0;
    
    $total = $conn->query("SELECT COUNT(*) as count FROM sponsorships")->fetch_assoc()['count'];
    
    if ($has_new_columns) {
        $state_level = $conn->query("SELECT COUNT(*) as count FROM sponsorships WHERE chapter_id IS NULL")->fetch_assoc()['count'];
        $chapter_level = $conn->query("SELECT COUNT(*) as count FROM sponsorships WHERE chapter_id IS NOT NULL")->fetch_assoc()['count'];
        
        // By tier
        $by_tier = [];
        $tier_result = $conn->query("SELECT sponsor_tier, COUNT(*) as count FROM sponsorships GROUP BY sponsor_tier");
        while ($row = $tier_result->fetch_assoc()) {
            $by_tier[$row['sponsor_tier']] = $row['count'];
        }
        
        return [
            'total' => $total,
            'state_level' => $state_level,
            'chapter_level' => $chapter_level,
            'by_tier' => $by_tier
        ];
    }
    
    return ['total' => $total];
}

/**
 * Get recent activities
 */
function getRecentActivities($conn) {
    $activities = [];
    
    // Recent news
    $news = $conn->query("SELECT 'news' as type, headline as title, created_at FROM news ORDER BY created_at DESC LIMIT 3");
    while ($row = $news->fetch_assoc()) {
        $activities[] = $row;
    }
    
    // Recent events
    $events = $conn->query("SELECT 'event' as type, title, event_date as created_at FROM events ORDER BY id DESC LIMIT 3");
    while ($row = $events->fetch_assoc()) {
        $activities[] = $row;
    }
    
    // Sort by date
    usort($activities, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    
    return array_slice($activities, 0, 5);
}
