<?php
session_start();

// Debug: Show session status (remove in production)
$debug_mode = true; // Set to false in production

if ($debug_mode) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    if ($debug_mode) {
        // In debug mode, create a temporary session for testing
        $_SESSION['user'] = 'SO Sarawak Admin';
        $_SESSION['admin_id'] = 1; // Use existing user ID from database
        echo "<!-- DEBUG: Temporary session created for testing -->";
    } else {
        // Redirect to login page if not logged in
        header('Location: login_page_v1.php');
        exit();
    }
}

if ($debug_mode) {
    echo "<!-- DEBUG: Session User: " . ($_SESSION['user'] ?? 'Not set') . ", Admin ID: " . ($_SESSION['admin_id'] ?? 'Not set') . " -->";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Webmaster | Special Olympics Sarawak</title>
    <!-- White color logo of SO represents an admin -->
    <link rel="shortcut icon" href="../assets/images/master-logo-front-white.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/events-calendar-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/sports-management-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/state-games-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/news-style.css?v=<?php echo time(); ?>">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Force Add News Button Styling */
        .add-news-btn {
            font-family: 'Inter', sans-serif !important;
            background-color: #3b82f6 !important;
            color: white !important;
            padding: 10px 20px !important;
            border: none !important;
            border-radius: 99px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        .add-news-btn:hover {
            background-color: #2563eb !important;
        }
        
        .add-news-btn i {
            font-size: 14px !important;
        }
        
        /* Force Add Photo Button Styling */
        .add-photo-btn {
            font-family: 'Inter', sans-serif !important;
            background-color: #3b82f6 !important;
            color: white !important;
            padding: 10px 20px !important;
            border: none !important;
            border-radius: 99px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        .add-photo-btn:hover {
            background-color: #2563eb !important;
        }
        
        .add-photo-btn i {
            font-size: 14px !important;
        }
        
        /* Force Add Video Button Styling */
        .add-video-btn {
            font-family: 'Inter', sans-serif !important;
            background-color: #3b82f6 !important;
            color: white !important;
            padding: 10px 20px !important;
            border: none !important;
            border-radius: 99px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        .add-video-btn:hover {
            background-color: #2563eb !important;
        }
        
        .add-video-btn i {
            font-size: 14px !important;
        }
        
        /* Force Add Sport Button Styling */
        .add-sport-btn {
            font-family: 'Inter', sans-serif !important;
            background-color: #3b82f6 !important;
            color: white !important;
            padding: 10px 20px !important;
            border: none !important;
            border-radius: 99px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        .add-sport-btn:hover {
            background-color: #2563eb !important;
        }
        
        .add-sport-btn i {
            font-size: 14px !important;
        }
        
        /* Force Add State Games Button Styling */
        .add-state-games-btn {
            font-family: 'Inter', sans-serif !important;
            background-color: #3b82f6 !important;
            color: white !important;
            padding: 10px 20px !important;
            border: none !important;
            border-radius: 99px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        .add-state-games-btn:hover {
            background-color: #2563eb !important;
        }
        
        .add-state-games-btn i {
            font-size: 14px !important;
        }
        
        /* Force Add YAP Button Styling */
        .add-yap-btn {
            font-family: 'Inter', sans-serif !important;
            background-color: #3b82f6 !important;
            color: white !important;
            padding: 10px 20px !important;
            border: none !important;
            border-radius: 99px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        .add-yap-btn:hover {
            background-color: #2563eb !important;
        }
        
        .add-yap-btn i {
            font-size: 14px !important;
        }
        
        /* STANDARDIZED MODAL STYLING - Based on News Modal */
        .photo-modal,
        .event-modal,
        .sponsorship-modal,
        .video-modal,
        .sport-modal,
        .yap-modal {
            display: none !important;
        }
        
        #photoModal,
        #eventModal,
        #sponsorshipModal,
        #addVideoModal,
        #addSportModal,
        #sportModal,
        #yapModal {
            display: none !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            background: rgba(0, 0, 0, 0.8) !important;
            z-index: 999999 !important;
            justify-content: center !important;
            align-items: center !important;
        }
        
        #photoModal.show,
        #eventModal.show,
        #sponsorshipModal.show,
        #addVideoModal.show,
        #addSportModal.show,
        #sportModal.show,
        #yapModal.show {
            display: flex !important;
        }
        
        .photo-modal-content,
        .event-modal-content,
        .sponsorship-modal-content,
        .video-modal-content,
        .sport-modal-content,
        .yap-modal-content {
            background: white !important;
            border-radius: 12px !important;
            width: 95% !important;
            max-width: 900px !important;
            max-height: 95vh !important;
            overflow: hidden !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
        }
        
        /* News Modal Header Styling Applied to All */
        .modal-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 24px 32px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            background: #f8fafc !important;
        }
        
        .modal-title {
            font-size: 20px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin: 0 !important;
        }
        
        .modal-close {
            cursor: pointer !important;
            font-size: 24px !important;
            color: #64748b !important;
            font-weight: bold !important;
            padding: 4px !important;
            border-radius: 4px !important;
            transition: all 0.2s ease !important;
            border: none !important;
            background: none !important;
        }
        
        .modal-close:hover {
            color: #e53935 !important;
            background: rgba(229, 57, 53, 0.1) !important;
        }
        
        /* Modal Body Styling */
        .photo-modal-content form,
        .event-modal-content form,
        .sponsorship-modal-content form,
        .video-modal-content form,
        .sport-modal-content form,
        .yap-modal-content form {
            padding: 32px !important;
            max-height: calc(95vh - 140px) !important;
            overflow-y: auto !important;
        }

        /* Standardized Modal Actions/Buttons */
        .modal-footer,
        .news-modal-actions,
        .state-games-modal-actions,
        .sport-modal-actions,
        .video-modal-actions,
        .photo-modal-actions,
        .yap-modal-actions {
            display: flex !important;
            justify-content: flex-end !important;
            gap: 12px !important;
            padding-top: 24px !important;
            margin-top: 24px !important;
            border-top: 1px solid #e2e8f0 !important;
        }

        /* Standardized Button Styles */
        .btn-cancel,
        .btn-secondary {
            padding: 10px 24px !important;
            background: #6c757d !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            font-family: 'Inter', sans-serif !important;
        }

        .btn-cancel:hover,
        .btn-secondary:hover {
            background: #5a6268 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3) !important;
        }

        .btn-submit,
        .btn-primary {
            padding: 10px 24px !important;
            background: #3b82f6 !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            font-family: 'Inter', sans-serif !important;
        }

        .btn-submit:hover,
        .btn-primary:hover {
            background: #2563eb !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4) !important;
        }

        .btn-submit:active,
        .btn-primary:active {
            transform: translateY(0) !important;
        }

        /* Edit mode specific button */
        .btn-submit.edit-mode {
            background: #10b981 !important;
        }

        .btn-submit.edit-mode:hover {
            background: #059669 !important;
        }

        /* State Games specific button fix */
        #submitStateGamesBtn {
            padding: 10px 24px !important;
            background: #3b82f6 !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            font-family: 'Inter', sans-serif !important;
        }

        #submitStateGamesBtn:hover {
            background: #2563eb !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4) !important;
        }

        /* When in edit mode */
        #submitStateGamesBtn.edit-mode {
            background: #10b981 !important;
        }

        #submitStateGamesBtn.edit-mode:hover {
            background: #059669 !important;
        }

        #cancelEditStateGamesBtn {
            padding: 10px 24px !important;
            background: #6c757d !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            font-family: 'Inter', sans-serif !important;
        }

        #cancelEditStateGamesBtn:hover {
            background: #5a6268 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3) !important;
        }
        
        /* Rich Text Editor Styling */
        .rich-editor-container {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
        }
        
        .editor-toolbar {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 12px;
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }
        
        .editor-btn {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 6px 10px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
        }
        
        .editor-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }
        
        .editor-btn.active {
            background: #3b82f6;
            color: white;
            border-color: #2563eb;
        }
        
        .editor-separator {
            width: 1px;
            background: #e5e7eb;
            margin: 0 4px;
        }
        
        .editor-content {
            min-height: 300px;
            padding: 16px;
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .editor-content:focus {
            outline: none;
        }
        
        /* Color picker styling */
        .color-picker {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        /* YAP Content Preview Styling */
        .yap-content-preview {
            margin-top: 20px;
        }
        
        .yap-preview-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .yap-preview-card h3 {
            margin-bottom: 15px;
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
        }
        
        .loading {
            text-align: center;
            color: #64748b;
            font-style: italic;
        }
        
        /* Dashboard Styles */
        .dashboard-section {
            margin-bottom: 32px;
        }
        
        .dashboard-section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .dashboard-section-title i {
            color: #3b82f6;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }
        
        .stat-card.highlight {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stat-card.highlight .stat-value,
        .stat-card.highlight .stat-label,
        .stat-card.highlight .stat-subtitle {
            color: white;
        }
        
        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            flex-shrink: 0;
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 4px 0;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            margin: 0 0 8px 0;
        }
        
        .stat-subtitle,
        .stat-breakdown {
            font-size: 12px;
            color: #94a3b8;
        }
        
        .stat-breakdown {
            margin-top: 4px;
        }
        
        .dashboard-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .dashboard-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .dashboard-card-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .dashboard-card-header i {
            color: #3b82f6;
        }
        
        .view-all-link {
            font-size: 14px;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .view-all-link:hover {
            color: #2563eb;
        }
        
        .dashboard-card-body {
            padding: 24px;
        }
        
        .mini-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .mini-stat {
            text-align: center;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .mini-stat-value {
            display: block;
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .mini-stat-label {
            display: block;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        
        .chapter-breakdown {
            max-height: 220px;
            overflow-y: auto;
        }
        
        .chapter-item {
            padding: 12px 16px;
            border-left: 3px solid #3b82f6;
            background: #f8fafc;
            margin-bottom: 8px;
            border-radius: 6px;
        }
        
        .chapter-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        
        .chapter-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }
        
        .chapter-total {
            font-weight: 700;
            color: #3b82f6;
            font-size: 16px;
        }
        
        .chapter-details {
            font-size: 12px;
            color: #64748b;
        }
        
        .next-event {
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            color: white;
        }
        
        .next-event-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
            margin-bottom: 8px;
        }
        
        .next-event-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .next-event-details {
            font-size: 13px;
            opacity: 0.9;
            display: flex;
            gap: 16px;
        }
        
        .next-event-details i {
            margin-right: 6px;
        }
        
        .media-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .media-stat-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .media-stat-item i {
            font-size: 32px;
        }
        
        .media-stat-value {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .media-stat-label {
            display: block;
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }
        
        .media-stat-item small {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }
        
        .recent-uploads {
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .recent-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .recent-badges {
            display: flex;
            gap: 12px;
        }
        
        .recent-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: white;
            border-radius: 20px;
            font-size: 13px;
            color: #1e293b;
            font-weight: 500;
        }
        
        .recent-badge i {
            font-size: 12px;
            color: #3b82f6;
        }
        
        .content-stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        
        .content-stat {
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            text-align: center;
        }
        
        .content-stat i {
            font-size: 28px;
            color: #3b82f6;
            margin-bottom: 8px;
        }
        
        .content-stat-value {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .content-stat-label {
            display: block;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        
        .activities-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .activity-item {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: background 0.2s;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-item:hover {
            background: #f8fafc;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }
        
        .activity-icon.news {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .activity-icon.event {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .activity-type {
            font-size: 12px;
            color: #64748b;
        }
        
        .activity-date {
            font-size: 12px;
            color: #94a3b8;
            white-space: nowrap;
        }
        
        /* Analytics Styles */
        .analytics-section {
            margin-bottom: 32px;
        }
        
        .analytics-section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .analytics-section-title i {
            color: #3b82f6;
        }
        
        .analytics-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .analytics-kpi-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.3s ease;
        }
        
        .analytics-kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .analytics-kpi-icon {
            width: 56px;
            height: 56px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }
        
        .analytics-kpi-content {
            flex: 1;
        }
        
        .analytics-kpi-value {
            display: block;
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .analytics-kpi-label {
            display: block;
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }
        
        .analytics-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .analytics-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .analytics-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .analytics-card-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .analytics-card-header i {
            color: #3b82f6;
        }
        
        .analytics-card-body {
            padding: 24px;
        }
        
        /* Gender Distribution */
        .gender-distribution {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        
        .gender-category h4 {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
        }
        
        .gender-bars {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .gender-bar-container {
            display: grid;
            grid-template-columns: 80px 1fr 50px;
            align-items: center;
            gap: 12px;
        }
        
        .gender-bar-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .gender-bar-track {
            height: 24px;
            background: #f1f5f9;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .gender-bar {
            height: 100%;
            border-radius: 12px;
            transition: width 1s ease;
        }
        
        .gender-bar.male {
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
        }
        
        .gender-bar.female {
            background: linear-gradient(90deg, #ec4899 0%, #db2777 100%);
        }
        
        .gender-bar-value {
            text-align: right;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Chapter Comparison */
        .chapter-comparison {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .chapter-comparison-item {
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }
        
        .chapter-comparison-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .chapter-comparison-name {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .chapter-comparison-total {
            font-size: 18px;
            font-weight: 700;
            color: #3b82f6;
        }
        
        .chapter-comparison-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }
        
        .chapter-comparison-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
            border-radius: 4px;
            transition: width 1s ease;
        }
        
        .chapter-comparison-details {
            font-size: 12px;
            color: #64748b;
        }
        
        /* Event Type Chart */
        .event-type-chart {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .event-type-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .event-type-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }
        
        .event-type-content {
            flex: 1;
        }
        
        .event-type-name {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            text-transform: capitalize;
        }
        
        .event-type-bar {
            height: 8px;
            background: #f1f5f9;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 6px;
        }
        
        .event-type-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
            transition: width 1s ease;
        }
        
        .event-type-count {
            font-size: 18px;
            font-weight: 700;
            color: #3b82f6;
        }
        
        /* Media Growth */
        .media-growth-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .media-growth-item {
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .media-growth-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .media-growth-header i {
            font-size: 20px;
        }
        
        .media-growth-value {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }
        
        .media-growth-detail {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 12px;
        }
        
        .media-growth-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .media-growth-progress {
            height: 100%;
            border-radius: 4px;
            transition: width 1s ease;
        }
        
        .media-growth-progress.photos {
            background: linear-gradient(90deg, #8b5cf6 0%, #a78bfa 100%);
        }
        
        .media-growth-progress.videos {
            background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
        }
        
        /* Leaderboard */
        .leaderboard {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .leaderboard-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .leaderboard-item:hover {
            background: #f1f5f9;
            transform: translateX(4px);
        }
        
        .leaderboard-rank {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }
        
        .leaderboard-rank.gold {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }
        
        .leaderboard-rank.silver {
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        }
        
        .leaderboard-rank.bronze {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
        }
        
        .leaderboard-rank.other {
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        }
        
        .leaderboard-content {
            flex: 1;
        }
        
        .leaderboard-name {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .leaderboard-details {
            font-size: 12px;
            color: #64748b;
        }
        
        .leaderboard-score {
            font-size: 24px;
            font-weight: 700;
            color: #3b82f6;
        }
        
        /* Content Activity */
        .content-activity-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .content-activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .content-activity-item i {
            font-size: 28px;
            color: #3b82f6;
        }
        
        .content-activity-value {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .content-activity-label {
            display: block;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        
        .content-recent-activity {
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            color: white;
        }
        
        .content-recent-activity h4 {
            font-size: 14px;
            margin-bottom: 8px;
            opacity: 0.9;
        }
        
        .recent-content-info {
            font-size: 13px;
            margin: 0;
        }
        
        /* Insights */
        .insights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
        }
        
        .insight-card {
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .insight-card.positive {
            background: #ecfdf5;
            border-left-color: #10b981;
        }
        
        .insight-card.warning {
            background: #fef3c7;
            border-left-color: #f59e0b;
        }
        
        .insight-card.info {
            background: #dbeafe;
            border-left-color: #3b82f6;
        }
        
        .insight-icon {
            font-size: 24px;
            margin-bottom: 12px;
        }
        
        .insight-card.positive .insight-icon {
            color: #10b981;
        }
        
        .insight-card.warning .insight-icon {
            color: #f59e0b;
        }
        
        .insight-card.info .insight-icon {
            color: #3b82f6;
        }
        
        .insight-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }
        
        .insight-description {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        /* ========================================
           Section Header Icon Styling
           ======================================== */
        
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 20px;
        }

        .section-header-content {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .section-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            display: flex;
            align-items: center;
            <span class="section-title"><i class="fa fa-globe"></i> Malaysia &amp; State</span>
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }

        .section-icon i {
            font-size: 24px;
            color: white;
        }

        .section-icon img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .section-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .section-title {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
        }

        .section-subtitle {
            margin: 0;
            font-size: 14px;
            color: #64748b;
        }

        /* Icon color variations for different sections */
        .section-icon.dashboard {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .section-icon.analytics {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .section-icon.posters {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .section-icon.events {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .section-icon.sports {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .section-icon.participants {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .section-icon.media {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .section-icon.articles {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .section-icon.affiliates {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .section-icon.settings {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }

        /* ========================================
           Other Special Olympics Management Styles
           ======================================== */
        
        /* Add Organization Button */
        .add-other-so-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .add-other-so-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .add-other-so-btn i {
            font-size: 16px;
        }

        /* Stats Grid */
        .other-so-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        /* Controls */
        .other-so-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
            flex-wrap: wrap;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-btn:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 16px;
            min-width: 300px;
        }

        .search-bar i {
            color: #94a3b8;
            margin-right: 8px;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 14px;
        }

        /* Organizations Container */
        .other-so-management-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .other-so-list {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .other-so-category-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .category-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        .category-title i {
            color: #667eea;
        }

        /* Organizations Grid */
        .other-so-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .international-grid {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        /* Organization Card */
        .other-so-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: move;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .other-so-card:hover {
            border-color: #667eea;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .card-drag-handle {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #cbd5e1;
            cursor: grab;
            padding: 4px;
            margin: -8px -8px 0 -8px;
        }

        .card-drag-handle:active {
            cursor: grabbing;
        }

        .card-drag-handle i {
            font-size: 16px;
        }

        .card-image {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 120px;
            background: #f8fafc;
            border-radius: 8px;
            padding: 15px;
        }

        .card-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .card-content {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .meta-badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .category-international {
            background: #dbeafe;
            color: #1e40af;
        }

        .category-malaysia {
            background: #fee2e2;
            color: #991b1b;
        }

        .category-state {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #fef2f2;
            color: #991b1b;
        }

        .card-link {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #64748b;
        }

        .card-link i {
            font-size: 12px;
        }

        .card-link-empty {
            font-size: 13px;
            color: #cbd5e1;
            font-style: italic;
        }

        .website-link {
            color: #667eea;
            text-decoration: none;
        }

        .website-link:hover {
            text-decoration: underline;
        }

        .card-actions {
            display: flex;
            gap: 8px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
        }

        .action-btn {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-toggle {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-toggle:hover {
            background: #f59e0b;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        /* Modal Styles */
        .other-so-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .other-so-modal.show {
            opacity: 1;
        }

        .other-so-modal-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .other-so-modal-content {
            position: relative;
            background: white;
            border-radius: 16px;
            max-width: 800px;
            max-height: 90vh;
            margin: 5vh auto;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-hint {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            color: #64748b;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .image-preview {
            margin-top: 10px;
        }

        .image-preview-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .image-preview-item img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
        }

        .image-preview-item small {
            color: #64748b;
            font-size: 12px;
        }

        /* Loading & Empty States */
        .loading-spinner {
            text-align: center;
            padding: 60px;
            color: #64748b;
            font-size: 16px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        /* Sortable States */
        .sortable-ghost {
            opacity: 0.4;
        }

        .sortable-chosen {
            cursor: grabbing;
        }

        .sortable-drag {
            opacity: 0.8;
        }

        /* Drag Handle Styles for Gallery Items */
        .gallery-drag-handle {
            position: absolute;
            top: 8px;
            left: 8px;
            width: 32px;
            height: 32px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: grab;
            opacity: 0;
            transition: opacity 0.2s ease;
            z-index: 10;
            pointer-events: auto;
        }

        .gallery-drag-handle:active {
            cursor: grabbing;
        }

        .gallery-drag-handle i {
            color: white;
            font-size: 16px;
        }

        /* Show drag handle on hover */
        .gallery-item:hover .gallery-drag-handle,
        .video-item:hover .gallery-drag-handle {
            opacity: 1;
        }

        /* Ensure buttons remain clickable */
        .gallery-item .edit-btn,
        .gallery-item .delete-btn,
        .video-item .edit-btn,
        .video-item .delete-btn {
            pointer-events: auto;
            position: relative;
            z-index: 11;
        }

        /* Collection Header Drag Handle */
        .collection-header-drag-handle {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            cursor: grab;
            background: rgba(0, 0, 0, 0.03);
            border-radius: 6px;
            margin-right: 12px;
            transition: background 0.2s ease;
        }

        .collection-header-drag-handle:hover {
            background: rgba(0, 0, 0, 0.08);
        }

        .collection-header-drag-handle:active {
            cursor: grabbing;
        }

        .collection-header-drag-handle i {
            color: #64748b;
            font-size: 16px;
        }

        /* Make sure gallery items are positioned relatively */
        .gallery-item,
        .video-item {
            position: relative;
        }

        /* Prevent text selection during drag */
        .sortable-collection.dragging,
        .sortable-items.dragging {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .other-so-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-buttons {
                justify-content: center;
            }

            .search-bar {
                min-width: 100%;
            }

            .other-so-grid,
            .international-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .other-so-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="../assets/images/Remake/SO Sarawak (site footer) BG.png" style="width: auto; height: 60px;">
            </div>
        </div>

        <nav class="sidebar-nav">
            <!-- Main Navigation -->
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="#" class="nav-item active" data-section="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item" data-section="analytics">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
            </div>

            <!-- Managements -->
            <div class="nav-section">
                <div class="nav-section-title">Managements</div>
                <a href="#" class="nav-item" data-section="posters">
                    <i class="fa-solid fa-house"></i>
                    <span>Posters</span>
                </a>
                <a href="#" class="nav-item" data-section="events">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events Calendar</span>
                </a>

                <a href="#" class="nav-item" data-section="sports">
                    <i class="fa-solid fa-futbol"></i>
                    <span>Sports</span>
                </a>
                <a href="#" class="nav-item" data-section="athletes">
                    <i class="fas fa-users"></i>
                    <span>Athletes</span>
                </a>
                <a href="#" class="nav-item" data-section="volunteers">
                    <i class="fas fa-hands-helping"></i>
                    <span>Volunteers</span>
                </a>
                <a href="#" class="nav-item" data-section="coaches">
                    <i class="fas fa-user-tie"></i>
                    <span>Coaches</span>
                </a>
            </div>

            <!-- Articles -->
            <div class="nav-section">
                <div class="nav-section-title">Articles and Programs</div>
                <a href="#" class="nav-item" data-section="state-games">
                    <i class="fas fa-newspaper"></i>
                    <span>State Games</span>
                </a>
                <a href="#" class="nav-item" data-section="news">
                    <i class="fas fa-newspaper"></i>
                    <span>News</span>
                </a>
                <a href="#" class="nav-item" data-section="alp">
                    <i class="fas fa-newspaper"></i>
                    <span>Athlete Leadership</span>
                </a>
                <a href="#" class="nav-item" data-section="sohap">
                    <i class="fas fa-newspaper"></i>
                    <span>Healthy Athletes</span>
                </a>
                <a href="#" class="nav-item" data-section="yap">
                    <i class="fas fa-newspaper"></i>
                    <span>Young Athletes</span>
                </a>
            </div>

            <!-- Media -->
            <div class="nav-section">
                <div class="nav-section-title">Media</div>
                <a href="#" class="nav-item" data-section="photos">
                    <i class="fas fa-images"></i>
                    <span>Photos</span>
                </a>
                <a href="#" class="nav-item" data-section="videos">
                    <i class="fa-solid fa-video"></i>
                    <span>Videos</span>
                </a>
                <a href="#" class="nav-item" data-section="documents">
                    <i class="fas fa-file-alt"></i>
                    <span>Documents</span>
                </a>
            </div>

            <!-- Affiliates -->
            <div class="nav-section">
                <div class="nav-section-title">Affiliates</div>
                <a href="#" class="nav-item" data-section="sarawak-chapters">
                    <img src="../assets/icons/samarahan-hornbill.png"
                        style="width: 16px; height: 16px; margin: 0 14px 0 2px; filter: invert(1);">
                    <span>Sarawak Chapters</span>
                </a>
                <a href="#" class="nav-item" data-section="sponsorships">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <span>Sponsorships</span>
                </a>
                <a href="#" class="nav-item" data-section="other-special-olympics">
                    <i class="fa-solid fa-globe"></i>
                    <span>Special Olympics Organization</span>
                </a>
            </div>

            <!-- Settings -->
            <div class="nav-section">
                <div class="nav-section-title">Settings</div>
                <a href="#" class="nav-item" data-section="settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="nav-item" data-section="profile">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <h1 class="page-title">Dashboard</h1>
            </div>

            <div class="header-right"> 
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge"></span>
                </button>

                <div class="user-profile" onclick="toggleUserDropdown()">
                    <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['user'] ?? 'A', 0, 1)); ?></div>
                    <div class="user-info">
                        <span class="user-name" id="headerUserName"><?php echo htmlspecialchars($_SESSION['user'] ?? 'Loading...'); ?></span>
                        <span class="user-role" id="headerUserRole">Administrator</span>
                    </div>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                    
                    <div class="user-dropdown" id="userDropdown">
                        <div class="dropdown-item" onclick="event.stopPropagation(); navigateToSection('profile')">
                            <i class="fas fa-user"></i>
                            <span>Profile Settings</span>
                        </div>
                        <div class="dropdown-item" onclick="event.stopPropagation(); navigateToSection('settings')">
                            <i class="fas fa-cog"></i>
                            <span>Admin Settings</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item logout" onclick="event.stopPropagation(); logout()">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">


            <!-- Dashboard Section -->
            <div class="content-section active" id="dashboard">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Dashboard Overview</h2>
                            <p class="section-subtitle">Welcome to Special Olympics Sarawak Admin Webmaster</p>
                        </div>
                    </div>
                </div>

                <!-- Participants Overview -->
                <div class="dashboard-section">
                    <h3 class="dashboard-section-title">
                        <i class="fas fa-users"></i> Participants Overview (2025)
                    </h3>
                    <div class="stats-grid">
                        <div class="stat-card highlight">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h4 class="stat-value" id="totalParticipants">-</h4>
                                <p class="stat-label">Total Participants</p>
                                <span class="stat-subtitle">All Chapters Combined</span>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="fas fa-running"></i>
                            </div>
                            <div class="stat-content">
                                <h4 class="stat-value" id="totalAthletes">-</h4>
                                <p class="stat-label">Athletes</p>
                                <div class="stat-breakdown">
                                    <span id="athletesMale">-</span> Male • <span id="athletesFemale">-</span> Female
                                </div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div class="stat-content">
                                <h4 class="stat-value" id="totalVolunteers">-</h4>
                                <p class="stat-label">Volunteers</p>
                                <div class="stat-breakdown">
                                    <span id="volunteersMale">-</span> Male • <span id="volunteersFemale">-</span> Female
                                </div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="stat-content">
                                <h4 class="stat-value" id="totalCoaches">-</h4>
                                <p class="stat-label">Coaches</p>
                                <div class="stat-breakdown">
                                    <span id="coachesMale">-</span> Male • <span id="coachesFemale">-</span> Female
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chapters & Events Row -->
                <div class="dashboard-row">
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <h3><i class="fas fa-map-marker-alt"></i> Chapters Status</h3>
                        </div>
                        <div class="dashboard-card-body">
                            <div class="mini-stats-grid">
                                <div class="mini-stat">
                                    <span class="mini-stat-value" id="totalChapters">-</span>
                                    <span class="mini-stat-label">Total Chapters</span>
                                </div>
                                <div class="mini-stat">
                                    <span class="mini-stat-value" id="activeChapters" style="color: #10b981;">-</span>
                                    <span class="mini-stat-label">Active</span>
                                </div>
                                <div class="mini-stat">
                                    <span class="mini-stat-value" id="upcomingChapters" style="color: #f59e0b;">-</span>
                                    <span class="mini-stat-label">Upcoming</span>
                                </div>
                            </div>
                            <div class="chapter-breakdown" id="chapterBreakdown">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <h3><i class="fas fa-calendar-alt"></i> Events</h3>
                            <a href="#" onclick="navigateToSection('events'); return false;" class="view-all-link">View All →</a>
                        </div>
                        <div class="dashboard-card-body">
                            <div class="mini-stats-grid">
                                <div class="mini-stat">
                                    <span class="mini-stat-value" id="totalEvents">-</span>
                                    <span class="mini-stat-label">Total Events</span>
                                </div>
                                <div class="mini-stat">
                                    <span class="mini-stat-value" id="upcomingEvents" style="color: #3b82f6;">-</span>
                                    <span class="mini-stat-label">Upcoming</span>
                                </div>
                                <div class="mini-stat">
                                    <span class="mini-stat-value" id="pastEvents" style="color: #6b7280;">-</span>
                                    <span class="mini-stat-label">Past</span>
                                </div>
                            </div>
                            <div class="next-event" id="nextEvent">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media & Content Row -->
                <div class="dashboard-row">
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <h3><i class="fas fa-photo-video"></i> Media Library</h3>
                        </div>
                        <div class="dashboard-card-body">
                            <div class="media-stats">
                                <div class="media-stat-item">
                                    <i class="fas fa-images" style="color: #8b5cf6;"></i>
                                    <div>
                                        <span class="media-stat-value" id="totalPhotos">-</span>
                                        <span class="media-stat-label">Photos</span>
                                        <small id="photoCollections">- collections</small>
                                    </div>
                                </div>
                                <div class="media-stat-item">
                                    <i class="fas fa-video" style="color: #ef4444;"></i>
                                    <div>
                                        <span class="media-stat-value" id="totalVideos">-</span>
                                        <span class="media-stat-label">Videos</span>
                                        <small id="videoCollections">- collections</small>
                                    </div>
                                </div>
                            </div>
                            <div class="recent-uploads">
                                <p class="recent-label">Recent Uploads (30 days)</p>
                                <div class="recent-badges">
                                    <span class="recent-badge">
                                        <i class="fas fa-image"></i> <span id="recentPhotos">-</span> Photos
                                    </span>
                                    <span class="recent-badge">
                                        <i class="fas fa-video"></i> <span id="recentVideos">-</span> Videos
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <h3><i class="fas fa-newspaper"></i> Content</h3>
                        </div>
                        <div class="dashboard-card-body">
                            <div class="content-stats-grid">
                                <div class="content-stat">
                                    <i class="fas fa-newspaper"></i>
                                    <span class="content-stat-value" id="totalNews">-</span>
                                    <span class="content-stat-label">News Articles</span>
                                </div>
                                <div class="content-stat">
                                    <i class="fas fa-trophy"></i>
                                    <span class="content-stat-value" id="totalSports">-</span>
                                    <span class="content-stat-label">Sports</span>
                                </div>
                                <div class="content-stat">
                                    <i class="fas fa-star"></i>
                                    <span class="content-stat-value" id="totalStateGames">-</span>
                                    <span class="content-stat-label">State Games</span>
                                </div>
                                <div class="content-stat">
                                    <i class="fas fa-hand-holding-heart"></i>
                                    <span class="content-stat-value" id="totalSponsors">-</span>
                                    <span class="content-stat-label">Sponsors</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="dashboard-section">
                    <h3 class="dashboard-section-title">
                        <i class="fas fa-clock"></i> Recent Activities
                    </h3>
                    <div class="activities-list" id="recentActivities">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>

            <!-- Analytics Section -->
            <div class="content-section" id="analytics">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon analytics">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Analytics & Insights</h2>
                            <p class="section-subtitle">Comprehensive data analysis and performance metrics</p>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics Overview -->
                <div class="analytics-section">
                    <h3 class="analytics-section-title">
                        <i class="fas fa-chart-line"></i> Key Performance Indicators
                    </h3>
                    <div class="analytics-kpi-grid">
                        <div class="analytics-kpi-card">
                            <div class="analytics-kpi-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="analytics-kpi-content">
                                <span class="analytics-kpi-value" id="kpiParticipationRate">-</span>
                                <span class="analytics-kpi-label">Avg. Participation per Chapter</span>
                            </div>
                        </div>
                        
                        <div class="analytics-kpi-card">
                            <div class="analytics-kpi-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <div class="analytics-kpi-content">
                                <span class="analytics-kpi-value" id="kpiVolunteerRatio">-</span>
                                <span class="analytics-kpi-label">Volunteer-to-Athlete Ratio</span>
                            </div>
                        </div>
                        
                        <div class="analytics-kpi-card">
                            <div class="analytics-kpi-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="analytics-kpi-content">
                                <span class="analytics-kpi-value" id="kpiEventFrequency">-</span>
                                <span class="analytics-kpi-label">Events per Month (2025)</span>
                            </div>
                        </div>
                        
                        <div class="analytics-kpi-card">
                            <div class="analytics-kpi-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                <i class="fas fa-images"></i>
                            </div>
                            <div class="analytics-kpi-content">
                                <span class="analytics-kpi-value" id="kpiMediaGrowth">-</span>
                                <span class="analytics-kpi-label">Media Items This Month</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gender Distribution & Chapter Comparison -->
                <div class="analytics-row">
                    <div class="analytics-card">
                        <div class="analytics-card-header">
                            <h3><i class="fas fa-venus-mars"></i> Gender Distribution Analysis</h3>
                        </div>
                        <div class="analytics-card-body">
                            <div class="gender-distribution">
                                <div class="gender-category">
                                    <h4>Athletes</h4>
                                    <div class="gender-bars">
                                        <div class="gender-bar-container">
                                            <div class="gender-bar-label">
                                                <i class="fas fa-mars" style="color: #3b82f6;"></i> Male
                                            </div>
                                            <div class="gender-bar-track">
                                                <div class="gender-bar male" id="athletesMaleBar" style="width: 0%"></div>
                                            </div>
                                            <span class="gender-bar-value" id="athletesMalePercent">0%</span>
                                        </div>
                                        <div class="gender-bar-container">
                                            <div class="gender-bar-label">
                                                <i class="fas fa-venus" style="color: #ec4899;"></i> Female
                                            </div>
                                            <div class="gender-bar-track">
                                                <div class="gender-bar female" id="athletesFemaleBar" style="width: 0%"></div>
                                            </div>
                                            <span class="gender-bar-value" id="athletesFemalePercent">0%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gender-category">
                                    <h4>Coaches</h4>
                                    <div class="gender-bars">
                                        <div class="gender-bar-container">
                                            <div class="gender-bar-label">
                                                <i class="fas fa-mars" style="color: #3b82f6;"></i> Male
                                            </div>
                                            <div class="gender-bar-track">
                                                <div class="gender-bar male" id="coachesMaleBar" style="width: 0%"></div>
                                            </div>
                                            <span class="gender-bar-value" id="coachesMalePercent">0%</span>
                                        </div>
                                        <div class="gender-bar-container">
                                            <div class="gender-bar-label">
                                                <i class="fas fa-venus" style="color: #ec4899;"></i> Female
                                            </div>
                                            <div class="gender-bar-track">
                                                <div class="gender-bar female" id="coachesFemaleBar" style="width: 0%"></div>
                                            </div>
                                            <span class="gender-bar-value" id="coachesFemalePercent">0%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gender-category">
                                    <h4>Volunteers</h4>
                                    <div class="gender-bars">
                                        <div class="gender-bar-container">
                                            <div class="gender-bar-label">
                                                <i class="fas fa-mars" style="color: #3b82f6;"></i> Male
                                            </div>
                                            <div class="gender-bar-track">
                                                <div class="gender-bar male" id="volunteersMaleBar" style="width: 0%"></div>
                                            </div>
                                            <span class="gender-bar-value" id="volunteersMalePercent">0%</span>
                                        </div>
                                        <div class="gender-bar-container">
                                            <div class="gender-bar-label">
                                                <i class="fas fa-venus" style="color: #ec4899;"></i> Female
                                            </div>
                                            <div class="gender-bar-track">
                                                <div class="gender-bar female" id="volunteersFemaleBar" style="width: 0%"></div>
                                            </div>
                                            <span class="gender-bar-value" id="volunteersFemalePercent">0%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="analytics-card">
                        <div class="analytics-card-header">
                            <h3><i class="fas fa-chart-bar"></i> Chapter Performance Comparison</h3>
                        </div>
                        <div class="analytics-card-body">
                            <div class="chapter-comparison" id="chapterComparison">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event & Media Analytics -->
                <div class="analytics-row">
                    <div class="analytics-card">
                        <div class="analytics-card-header">
                            <h3><i class="fas fa-calendar-alt"></i> Event Type Distribution</h3>
                        </div>
                        <div class="analytics-card-body">
                            <div class="event-type-chart" id="eventTypeChart">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>

                    <div class="analytics-card">
                        <div class="analytics-card-header">
                            <h3><i class="fas fa-photo-video"></i> Media Library Growth</h3>
                        </div>
                        <div class="analytics-card-body">
                            <div class="media-growth-stats">
                                <div class="media-growth-item">
                                    <div class="media-growth-header">
                                        <i class="fas fa-images" style="color: #8b5cf6;"></i>
                                        <span>Photo Collections</span>
                                    </div>
                                    <div class="media-growth-value" id="photoCollectionsCount">-</div>
                                    <div class="media-growth-detail">
                                        Total Photos: <strong id="totalPhotosCount">-</strong>
                                    </div>
                                    <div class="media-growth-bar">
                                        <div class="media-growth-progress photos" id="photosProgress"></div>
                                    </div>
                                </div>
                                
                                <div class="media-growth-item">
                                    <div class="media-growth-header">
                                        <i class="fas fa-video" style="color: #ef4444;"></i>
                                        <span>Video Collections</span>
                                    </div>
                                    <div class="media-growth-value" id="videoCollectionsCount">-</div>
                                    <div class="media-growth-detail">
                                        Total Videos: <strong id="totalVideosCount">-</strong>
                                    </div>
                                    <div class="media-growth-bar">
                                        <div class="media-growth-progress videos" id="videosProgress"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Performing Chapters & Content Activity -->
                <div class="analytics-row">
                    <div class="analytics-card">
                        <div class="analytics-card-header">
                            <h3><i class="fas fa-medal"></i> Top Performing Chapters</h3>
                        </div>
                        <div class="analytics-card-body">
                            <div class="leaderboard" id="chapterLeaderboard">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>

                    <div class="analytics-card">
                        <div class="analytics-card-header">
                            <h3><i class="fas fa-newspaper"></i> Content Publication Activity</h3>
                        </div>
                        <div class="analytics-card-body">
                            <div class="content-activity-grid">
                                <div class="content-activity-item">
                                    <i class="fas fa-newspaper"></i>
                                    <div>
                                        <span class="content-activity-value" id="newsArticlesCount">-</span>
                                        <span class="content-activity-label">News Articles</span>
                                    </div>
                                </div>
                                <div class="content-activity-item">
                                    <i class="fas fa-trophy"></i>
                                    <div>
                                        <span class="content-activity-value" id="sportsCount">-</span>
                                        <span class="content-activity-label">Sports Categories</span>
                                    </div>
                                </div>
                                <div class="content-activity-item">
                                    <i class="fas fa-star"></i>
                                    <div>
                                        <span class="content-activity-value" id="stateGamesCount">-</span>
                                        <span class="content-activity-label">State Games</span>
                                    </div>
                                </div>
                                <div class="content-activity-item">
                                    <i class="fas fa-hand-holding-heart"></i>
                                    <div>
                                        <span class="content-activity-value" id="sponsorsCount">-</span>
                                        <span class="content-activity-label">Active Sponsors</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="content-recent-activity">
                                <h4>Recent Content Updates</h4>
                                <p class="recent-content-info" id="recentContentInfo">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Insights & Recommendations -->
                <div class="analytics-section">
                    <h3 class="analytics-section-title">
                        <i class="fas fa-lightbulb"></i> Insights & Recommendations
                    </h3>
                    <div class="insights-grid" id="insightsGrid">
                        <!-- Populated by JS with dynamic insights -->
                    </div>
                </div>
            </div>

            <div class="content-section" id="posters">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon posters">
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Posters Management</h2>
                            <p class="section-subtitle">Upload and manage posters for Special Olympics Sarawak</p>  
                        </div>
                    </div>
                </div>

                <div class="management-container">
                    <h3>Add a Posters</h3>
                    <form id="posterForm" action="../admin/handler/admin_poster_handler.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" id="posterId" name="id">
                        <input type="hidden" id="currentPosterImage" name="currentImage">
                        <div class="form-group">
                            <label for="posterImage">Upload Image:</label>
                            <label for="posterImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="posterImage" name="posterImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deletePosterImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="posterImageStatus">No file selected.</span>
                            <img id="posterImagePreview" src="" alt="Poster Image Preview"
                                style="max-width: 100%; max-height: 100%; margin-top: 10px; display: none;">
                        </div>
                        <button type="submit" class="form-submit-btn" id="submitPosterBtn">Publish</button>

                        <div class="published-container">
                            <div class="published-title">
                                <h3>Published Posters</h3>
                            </div>
                            <!-- Fetch the published posters from the database -->
                            <!-- Below is just a hard-coded structure sample, not connected to the database -->
                            <div id="publishedPoster">
                                <div class="p-poster-container">
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Special Olympics National Games 2026">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Healthy Athletes Program Poster">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 3">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 4">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 5">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 6">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 7">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 8">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 9">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 10">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 11">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Events Section -->
            <div class="content-section" id="events">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Events Calendar Management</h2>
                        <p class="section-subtitle">Create and manage events calendar</p>
                    </div>
                    <button class="add-event-btn" onclick="openEventModal()">
                        <i class="fas fa-plus"></i> Add Event
                    </button>
                </div>

                <!-- Events Statistics Overview -->
                <div class="events-stats-grid">
                    <div class="events-stat-card">
                        <div class="events-stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="events-stat-content">
                            <h4 class="events-stat-value" id="totalEventsCount">0</h4>
                            <p class="events-stat-label">Total Events</p>
                        </div>
                    </div>
                    <div class="events-stat-card">
                        <div class="events-stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="events-stat-content">
                            <h4 class="events-stat-value" id="specialEventsCount">0</h4>
                            <p class="events-stat-label">Special Events</p>
                        </div>
                    </div>
                    <div class="events-stat-card">
                        <div class="events-stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <div class="events-stat-content">
                            <h4 class="events-stat-value" id="trainingEventsCount">0</h4>
                            <p class="events-stat-label">Training Sessions</p>
                        </div>
                    </div>
                    <div class="events-stat-card">
                        <div class="events-stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="events-stat-content">
                            <h4 class="events-stat-value" id="upcomingEventsCount">0</h4>
                            <p class="events-stat-label">Upcoming Events</p>
                        </div>
                    </div>
                </div>

                <!-- Filter and Sort Controls -->
                <div class="events-controls">
                    <div class="events-filters">
                        <div class="filter-group">
                            <label for="filterEventType">
                                <i class="fas fa-filter"></i> Filter by Type
                            </label>
                            <select id="filterEventType" class="events-filter-select">
                                <option value="all">All Events</option>
                                <option value="special">Special Event</option>
                                <option value="training">Training</option>
                                <option value="fundraiser">Fundraiser</option>
                                <option value="social">Social</option>
                                <option value="ceremony">Ceremony</option>
                                <option value="meeting">Meeting</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="filterEventCity">
                                <i class="fas fa-map-marker-alt"></i> Filter by City
                            </label>
                            <select id="filterEventCity" class="events-filter-select">
                                <option value="all">All Cities</option>
                                <option value="Bintulu">Bintulu</option>
                                <option value="Kuching">Kuching</option>
                                <option value="Miri">Miri</option>
                                <option value="Samarahan">Samarahan</option>
                                <option value="Sibu">Sibu</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="sortEvents">
                                <i class="fas fa-sort"></i> Sort by
                            </label>
                            <select id="sortEvents" class="events-filter-select">
                                <option value="date_desc">Newest First</option>
                                <option value="date_asc">Oldest First</option>
                                <option value="title_asc">Title (A-Z)</option>
                                <option value="title_desc">Title (Z-A)</option>
                            </select>
                        </div>
                    </div>
                    <div class="events-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchEvents" placeholder="Search events..." class="events-search-input">
                    </div>
                </div>

                <div class="event-management-container">
                    <!-- Event Form Modal -->
                    <div class="event-modal" id="eventModal">
                        <div class="event-modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Add New Event</h3>
                                <span class="modal-close" onclick="closeEventModal()">&times;</span>
                            </div>
                            <form id="eventForm" action="handler/admin_event_handler.php" method="POST"
                                enctype="multipart/form-data">
                        <input type="hidden" id="eventId" name="id">
                        <input type="hidden" id="currentEventImage" name="currentImage">
                        <div class="event-form-group">
                            <label for="eventImage">Upload Image:</label>
                            <!-- <input type="file" id="eventImage" name="eventImage" accept="image/*"> <!-- Change the code here -->
                            <!-- New style for Browse & Delete Image button -->
                            <label for="eventImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="eventImage" name="eventImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deleteEventImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="eventImageStatus">No file selected.</span>
                            <img id="eventImagePreview" src="" alt="Event Image Preview"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="event-form-group">
                            <label for="eventTitle">Title:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventTitle"
                                name="eventTitle" placeholder="Enter event title" required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventDescription">Description:</label>
                            <textarea style="font-family: 'Inter', sans-serif;" id="eventDescription"
                                name="eventDescription" placeholder="Enter event description" required></textarea>
                        </div>
                        <div class="event-form-group">
                            <label for="eventLocation">Location:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventLocation"
                                name="eventLocation" placeholder="Enter event location" required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventCity">City:</label>
                            <select style="font-family: 'Inter', sans-serif;" id="eventCity" name="eventCity" required>
                                <option value="">Select City</option>
                                <option value="Bintulu">Bintulu</option>
                                <option value="Kuching">Kuching</option>
                                <option value="Miri">Miri</option>
                                <option value="Samarahan">Samarahan</option>
                                <option value="Sibu">Sibu</option>
                            </select>
                        </div>
                        <div class="event-form-group">
                            <label for="eventDate">Date:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="date" id="eventDate" name="eventDate"
                                required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventTime">Time:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventTime" name="eventTime"
                                placeholder="e.g., 10:00 AM - 12:00 PM" required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventType">Type:</label>
                            <select style="font-family: 'Inter', sans-serif;" id="eventType" name="eventType" required>
                                <option value="">Select Event Type</option>
                                <option value="special">Special Event</option>
                                <option value="training">Training</option>
                                <option value="fundraiser">Fundraiser</option>
                                <option value="social">Social</option>
                                <option value="ceremony">Ceremony</option>
                                <option value="meeting">Meeting</option>
                            </select>
                        </div>
                                <button type="submit" class="event-submit-btn" id="submitEventBtn">Add Event</button>
                                <button type="button" class="event-submit-btn" id="cancelEditBtn"
                                    style="display:none; background-color: #6c757d;">Cancel Edit</button>
                            </form>
                        </div>
                    </div>

                    <div class="event-list-admin">
                        <div class="event-list-header">
                            <h3>All Events <span class="event-count-badge" id="displayedEventsCount">0</span></h3>
                            <div class="event-view-toggle">
                                <button class="view-toggle-btn active" data-view="grid" title="Grid View">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="view-toggle-btn" data-view="list" title="List View">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                        <div id="existingEvents" class="events-grid">
                            <!-- Events will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333; grid-column: 1 / -1;">Loading events...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sports Section -->
            <div class="content-section" id="sports">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon sports">
                            <i class="fas fa-running"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Sports Management</h2>
                            <p class="section-subtitle">Manage sports in the Our Sports page.</p>
                        </div>
                    </div>
                    <button class="add-sport-btn" onclick="openSportModal()">
                        <i class="fas fa-plus"></i> Add Sport
                    </button>
                </div>

                <!-- Sports Controls - Search & View Toggle -->
                <div class="sports-controls">
                    <div class="sports-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchSports" placeholder="Search sports by title or description..." class="sports-search-input">
                    </div>
                    <div class="sports-sort">
                        <label for="sortSports">
                            <i class="fas fa-sort"></i> Sort by
                        </label>
                        <select id="sortSports" class="sports-sort-select">
                            <option value="order">Display Order</option>
                            <option value="title_asc">Title (A-Z)</option>
                            <option value="title_desc">Title (Z-A)</option>
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                        </select>
                    </div>
                </div>

                <div class="sport-management-container">
                    <!-- Sport Form Modal -->
                    <div class="sport-modal" id="sportModal">
                        <div class="sport-modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Add New Sport</h3>
                                <span class="modal-close" onclick="closeSportModal()">&times;</span>
                            </div>
                            <form id="sportForm" action="handler/admin_sports_handler.php" method="POST"
                                enctype="multipart/form-data">
                        <input type="hidden" id="sportId" name="id">
                        <input type="hidden" id="currentSportImage" name="currentImage">
                        <div class="sport-form-group">
                            <label for="sportImage">Upload Image:</label>
                            <label for="sportImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="sportImage" name="sportImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deleteSportImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="sportImageStatus">No file selected.</span>
                            <img id="sportImagePreview" src="" alt="Sport Image Preview"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="sport-form-group">
                            <label for="sportTitle">Title:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="sportTitle"
                                name="sportTitle" placeholder="Enter sport title" required>
                        </div>
                        <div class="sport-form-group">
                            <label for="sportDescription">Description:</label>
                            <textarea style="font-family: 'Inter', sans-serif;" id="sportDescription"
                                name="sportDescription" placeholder="Enter sport description" required></textarea>
                        </div>
                        <div class="sport-form-group">
                            <label for="displayOrder">Display Order:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="number" id="displayOrder"
                                name="displayOrder" placeholder="Order (optional)" min="1">
                        </div>
                                <button type="submit" class="sport-submit-btn" id="submitSportBtn">Add Sport</button>
                                <button type="button" class="sport-submit-btn" id="cancelEditSportBtn"
                                    style="display:none; background-color: #6c757d;">Cancel Edit</button>
                            </form>
                        </div>
                    </div>

                    <div class="sport-list-admin">
                        <div class="sport-list-header">
                            <h3>All Sports <span class="sport-count-badge" id="displayedSportsCount">0</span></h3>
                            <div class="sport-view-controls">
                                <div class="drag-mode-info">
                                    <i class="fas fa-grip-vertical"></i>
                                    <span>Drag to reorder</span>
                                </div>
                                <div class="sport-view-toggle">
                                    <button class="view-toggle-btn active" data-view="grid" title="Grid View">
                                        <i class="fas fa-th"></i>
                                    </button>
                                    <button class="view-toggle-btn" data-view="list" title="List View">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="existingSports" class="sports-grid sortable-sports">
                            <!-- Sports will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333; grid-column: 1 / -1;">Loading sports...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Athletes Section -->
            <div class="content-section" id="athletes">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon participants">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Athletes Management</h2>
                            <p class="section-subtitle">Manage athlete registrations and profiles</p>
                        </div>
                    </div>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-users"></i>
                    <h3>Athletes Content</h3>
                    <p>Add your athlete management interface here</p>
                </div>
            </div>

            <!-- Volunteers Section -->
            <div class="content-section" id="volunteers">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon participants">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Volunteers Management</h2>
                            <p class="section-subtitle">Manage volunteer applications and schedules</p>
                        </div>
                    </div>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-hands-helping"></i>
                    <h3>Volunteers Content</h3>
                    <p>Add your volunteer management interface here</p>
                </div>
            </div>

            <!-- Coaches Section -->
            <div class="content-section" id="coaches">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon participants">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Coaches Management</h2>
                            <p class="section-subtitle">Manage coach profiles and certifications</p>
                        </div>
                    </div>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-user-tie"></i>
                    <h3>Coaches Content</h3>
                    <p>Add your coach management interface here</p>
                </div>
            </div>



            <div class="content-section" id="state-games">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">State Games</h2>
                        <p class="section-subtitle">Manage major events displayed on the State Games page</p>
                    </div>
                    <button class="add-state-games-btn" onclick="openStateGamesModal()">
                        <i class="fas fa-plus"></i> Add Event
                    </button>
                </div>

                <!-- State Games Controls -->
                <div class="state-games-controls">
                    <div class="state-games-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchStateGames" placeholder="Search events by title or description..." class="state-games-search-input">
                    </div>
                    <div class="state-games-sort">
                        <label for="sortStateGames">
                            <i class="fas fa-sort"></i> Sort by
                        </label>
                        <select id="sortStateGames" class="state-games-sort-select">
                            <option value="order">Display Order</option>
                            <option value="title_asc">Title (A-Z)</option>
                            <option value="title_desc">Title (Z-A)</option>
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                        </select>
                    </div>
                </div>

                <div class="state-games-management-container">
                    <!-- State Games Form Modal -->
                    <div id="stateGamesModal" class="state-games-modal" style="display: none;">
                        <div class="state-games-modal-backdrop" onclick="closeStateGamesModal()"></div>
                        <div class="state-games-modal-content">
                            <div class="state-games-modal-header">
                                <h3>Add New State Games Event</h3>
                                <span class="state-games-modal-close" onclick="closeStateGamesModal()">&times;</span>
                            </div>
                            <div class="state-games-modal-body">
                                <form id="stateGamesForm" action="handler/admin_state_games_handler.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" id="stateGamesId" name="id">
                                    <input type="hidden" id="currentStateGamesImage" name="currentImage">
                                    
                                    <div class="state-games-form-group">
                                        <label for="stateGamesImage">Upload Image:</label>
                                        <div class="file-upload-container">
                                            <input type="file" id="stateGamesImage" name="stateGamesImage" accept="image/*" style="display: none;" onchange="handleStateGamesFileSelect(this)">
                                            <button type="button" id="stateGamesImageBtn" class="file-upload-btn" onclick="document.getElementById('stateGamesImage').click()">Choose File</button>
                                            <span id="stateGamesImageStatus" class="file-status">No file selected</span>
                                            <button type="button" id="deleteStateGamesImageBtn" class="file-delete-btn" style="display: none;" onclick="removeStateGamesSelectedFile()">Remove</button>
                                        </div>
                                        <div id="stateGamesImagePreview" class="image-preview" style="display: none;">
                                            <img src="" alt="Preview" />
                                        </div>
                                    </div>
                                    
                                    <div class="state-games-form-group">
                                        <label for="stateGameEventTitle">Event Title *</label>
                                        <input type="text" id="stateGameEventTitle" name="eventTitle" placeholder="Enter event title" required>
                                    </div>
                                    
                                    <div class="state-games-form-group">
                                        <label for="stateGameEventDate">Event Date *</label>
                                        <div class="date-input-container">
                                            <input type="text" id="stateGameEventDate" name="eventDate" placeholder="e.g., TBA 2025 or 2-5 May 2025" required>
                                            <div class="date-helper-buttons">
                                                <button type="button" class="date-helper-btn" onclick="setTBADate()">TBA 2025</button>
                                                <button type="button" class="date-helper-btn" onclick="setTBADate('2026')">TBA 2026</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="state-games-form-group">
                                        <label for="stateGameEventDescription">Event Description *</label>
                                        <textarea id="stateGameEventDescription" name="eventDescription" placeholder="Enter event description" rows="4" required></textarea>
                                    </div>
                                    
                                    <div class="state-games-form-group">
                                        <label for="learnMoreLink">Learn More Link (optional)</label>
                                        <input type="url" id="learnMoreLink" name="learnMoreLink" placeholder="https://example.com">
                                    </div>
                                    
                                    <div class="state-games-form-group">
                                        <label for="stateGameDisplayOrder">Display Order</label>
                                        <input type="number" id="stateGameDisplayOrder" name="displayOrder" placeholder="Order (optional)" min="1">
                                    </div>
                                    
                                    <div class="state-games-modal-actions">
                                        <button type="button" class="btn-cancel" onclick="closeStateGamesModal()">Cancel</button>
                                        <button type="submit" class="btn-submit" id="submitStateGamesBtn">Add Event</button>
                                        <button type="button" class="btn-cancel" id="cancelEditStateGamesBtn" style="display:none;">Cancel Edit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="state-games-list-admin">
                        <div class="state-games-list-header">
                            <h3>All Events <span class="state-games-count-badge" id="displayedStateGamesCount">0</span></h3>
                            <div class="state-games-view-controls">
                                <div class="drag-mode-info">
                                    <i class="fas fa-grip-vertical"></i>
                                    <span>Drag to reorder</span>
                                </div>
                                <div class="state-games-view-toggle">
                                    <button class="view-toggle-btn active" data-view="grid" title="Grid View">
                                        <i class="fas fa-th"></i>
                                    </button>
                                    <button class="view-toggle-btn" data-view="list" title="List View">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="existingStateGames" class="state-games-grid sortable-state-games">
                            <!-- State Games events will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333; grid-column: 1 / -1;">Loading state games events...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- News Section -->
            <div class="content-section" id="news">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon articles">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">News Management</h2>
                            <p class="section-subtitle">Create and manage news articles</p>
                        </div>
                    </div>
                    <button id="addNewsBtn" class="add-news-btn">
                        <i class="fas fa-plus"></i> Add News
                    </button>
                </div>

                <!-- News Statistics Overview -->
                <div class="news-stats-grid">
                    <div class="news-stat-card">
                        <div class="news-stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="news-stat-content">
                            <h4 class="news-stat-value" id="totalNewsCount">0</h4>
                            <p class="news-stat-label">Total Articles</p>
                        </div>
                    </div>
                    <div class="news-stat-card">
                        <div class="news-stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="news-stat-content">
                            <h4 class="news-stat-value" id="thisMonthNewsCount">0</h4>
                            <p class="news-stat-label">Published This Month</p>
                        </div>
                    </div>
                    <div class="news-stat-card">
                        <div class="news-stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="news-stat-content">
                            <h4 class="news-stat-value" id="recentNewsCount">0</h4>
                            <p class="news-stat-label">Last 7 Days</p>
                        </div>
                    </div>
                    <div class="news-stat-card">
                        <div class="news-stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                            <i class="fas fa-fire"></i>
                        </div>
                        <div class="news-stat-content">
                            <h4 class="news-stat-value" id="latestNewsDate">-</h4>
                            <p class="news-stat-label">Latest Article</p>
                        </div>
                    </div>
                </div>

                <!-- News Controls -->
                <div class="news-controls">
                    <div class="news-filters">
                        <div class="filter-group">
                            <label for="filterNewsDate">
                                <i class="fas fa-calendar"></i> Date Range
                            </label>
                            <select id="filterNewsDate" class="news-filter-select">
                                <option value="all">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="sortNews">
                                <i class="fas fa-sort"></i> Sort by
                            </label>
                            <select id="sortNews" class="news-filter-select">
                                <option value="date_desc">Newest First</option>
                                <option value="date_asc">Oldest First</option>
                                <option value="title_asc">Title (A-Z)</option>
                                <option value="title_desc">Title (Z-A)</option>
                            </select>
                        </div>
                    </div>
                    <div class="news-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchNews" placeholder="Search news articles..." class="news-search-input">
                    </div>
                </div>

                <div class="news-management-container">
                    <div class="news-list-admin">
                        <div class="news-list-header">
                            <h3>All News Articles <span class="news-count-badge" id="displayedNewsCount">0</span></h3>
                            <div class="news-view-toggle">
                                <button class="view-toggle-btn active" data-view="grid" title="Grid View">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="view-toggle-btn" data-view="list" title="List View">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                        <div id="existingNewsArticles" class="news-grid">
                            <!-- News articles will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333; grid-column: 1 / -1;">Loading news articles...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Athlete Leaderships -->
            <div class="content-section" id="alp">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon articles">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Athlete Leaderships Management</h2>
                            <p class="section-subtitle">Manage Athlete Leaderships Program (ALP) overview articles, resources and the "learn more" page.</p>
                        </div>
                    </div>
                    <button class="add-alp-btn" onclick="openAlpModal()">
                        <i class="fas fa-plus"></i>
                        Add ALP Article
                    </button>
                </div>

                <div class="alp-management-container">
                    <!-- ALP Add Modal -->
                    <div id="alpModal" class="alp-modal" style="display: none;">
                        <div class="alp-modal-backdrop" onclick="closeAlpModal()"></div>
                        <div class="alp-modal-content">
                            <div class="alp-modal-header">
                                <h3>Add New ALP Article</h3>
                                <span class="alp-modal-close" onclick="closeAlpModal()">&times;</span>
                            </div>
                            <div class="alp-modal-body">
                                <form id="alpForm" action="handler/admin_alp_handler.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="add">
                                    
                                    <div class="alp-form-group">
                                        <label for="alpImage">Upload Image:</label>
                                        <div class="file-upload-container">
                                            <input type="file" id="alpImage" name="alpImage" accept="image/*" style="display: none;" onchange="handleAlpFileSelect(this)">
                                            <button type="button" id="alpImageBtn" class="file-upload-btn" onclick="document.getElementById('alpImage').click()">Choose File</button>
                                            <span id="alpImageStatus" class="file-status">No file selected</span>
                                            <button type="button" id="deleteAlpImageBtn" class="file-delete-btn" style="display: none;" onclick="removeAlpSelectedFile()">Remove</button>
                                        </div>
                                        <div id="alpImagePreview" class="image-preview" style="display: none;">
                                            <img src="" alt="Preview" />
                                        </div>
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="alpTitle">Article Title *</label>
                                        <input type="text" id="alpTitle" name="title" placeholder="Enter article title" required>
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="alpCategory">Category *</label>
                                        <select id="alpCategory" name="category" required>
                                            <option value="">Select category</option>
                                            <option value="LEADERSHIP DEVELOPMENT">Leadership Development</option>
                                            <option value="TRAINING PROGRAMS">Training Programs</option>
                                            <option value="ATHLETE SPOTLIGHT">Athlete Spotlight</option>
                                            <option value="SUCCESS STORIES">Success Stories</option>
                                            <option value="COMMUNITY ENGAGEMENT">Community Engagement</option>
                                            <option value="MENTORSHIP">Mentorship</option>
                                        </select>
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="alpDescription">Description *</label>
                                        <textarea id="alpDescription" name="description" placeholder="Enter article description" rows="4" required></textarea>
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="alpLearnMoreLink">Learn More Link (optional)</label>
                                        <input type="url" id="alpLearnMoreLink" name="learnMoreLink" placeholder="https://example.com">
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="alpDisplayOrder">Display Order</label>
                                        <input type="number" id="alpDisplayOrder" name="displayOrder" placeholder="Order (optional)" min="1">
                                    </div>
                                    
                                    <div class="alp-modal-actions">
                                        <button type="button" class="btn-cancel" onclick="closeAlpModal()">Cancel</button>
                                        <button type="submit" class="btn-submit" id="submitAlpBtn">Add Article</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ALP Edit Modal -->
                    <div id="alpEditModal" class="alp-modal alp-edit-modal" style="display: none;">
                        <div class="alp-modal-backdrop" onclick="closeAlpEditModal()"></div>
                        <div class="alp-modal-content">
                            <div class="alp-modal-header edit-modal-header">
                                <h3><i class="fas fa-edit"></i> Edit ALP Article</h3>
                                <span class="alp-modal-close" onclick="closeAlpEditModal()">&times;</span>
                            </div>
                            <div class="alp-modal-body">
                                <form id="alpEditForm" action="handler/admin_alp_handler.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" id="editAlpId" name="id">
                                    <input type="hidden" id="currentEditAlpImage" name="currentImage">
                                    <input type="hidden" name="action" value="update">
                                    
                                    <div class="alp-form-group">
                                        <label for="editAlpImage">Upload New Image:</label>
                                        <div class="file-upload-container">
                                            <input type="file" id="editAlpImage" name="alpImage" accept="image/*" style="display: none;" onchange="handleEditAlpFileSelect(this)">
                                            <button type="button" id="editAlpImageBtn" class="file-upload-btn" onclick="document.getElementById('editAlpImage').click()">Choose New File</button>
                                            <span id="editAlpImageStatus" class="file-status">Current image loaded</span>
                                            <button type="button" id="deleteEditAlpImageBtn" class="file-delete-btn" style="display: none;" onclick="removeEditAlpSelectedFile()">Remove</button>
                                        </div>
                                        <div id="editAlpImagePreview" class="image-preview" style="display: none;">
                                            <img src="" alt="Preview" />
                                        </div>
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="editAlpTitle">Article Title *</label>
                                        <input type="text" id="editAlpTitle" name="title" placeholder="Enter article title" required>
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="editAlpCategory">Category *</label>
                                        <select id="editAlpCategory" name="category" required>
                                            <option value="">Select category</option>
                                            <option value="LEADERSHIP DEVELOPMENT">Leadership Development</option>
                                            <option value="TRAINING PROGRAMS">Training Programs</option>
                                            <option value="ATHLETE SPOTLIGHT">Athlete Spotlight</option>
                                            <option value="SUCCESS STORIES">Success Stories</option>
                                            <option value="COMMUNITY ENGAGEMENT">Community Engagement</option>
                                            <option value="MENTORSHIP">Mentorship</option>
                                        </select>
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="editAlpDescription">Description *</label>
                                        <textarea id="editAlpDescription" name="description" placeholder="Enter article description" rows="4" required></textarea>
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="editAlpLearnMoreLink">Learn More Link (optional)</label>
                                        <input type="url" id="editAlpLearnMoreLink" name="learnMoreLink" placeholder="https://example.com">
                                    </div>
                                    
                                    <div class="alp-form-group">
                                        <label for="editAlpDisplayOrder">Display Order</label>
                                        <input type="number" id="editAlpDisplayOrder" name="displayOrder" placeholder="Order (optional)" min="1">
                                    </div>
                                    
                                    <div class="alp-modal-actions">
                                        <button type="button" class="btn-cancel" onclick="closeAlpEditModal()">Cancel</button>
                                        <button type="submit" class="btn-submit edit-btn-submit" id="submitEditAlpBtn">Update Article</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="alp-list-admin">
                        <div class="published-title">
                            <h3>Published ALP Articles</h3>
                            <p>Manage your Athlete Leadership Program articles</p>
                        </div>
                        <div id="existingAlp" class="existing-alp-container">
                            <!-- ALP articles will be loaded here via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Healthy Athletes -->
            <div class="content-section" id="sohap">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon-wrapper hap-icon-wrapper">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Healthy Athletes Program</h2>
                            <p class="section-subtitle">Manage health screenings, wellness programs, and community impact articles for SOHAP</p>
                        </div>
                    </div>
                    <button class="add-hap-btn" onclick="openHapModal()">
                        <i class="fas fa-plus"></i>
                        Add New Article
                    </button>
                </div>

                <div class="hap-management-container">
                    <!-- HAP Form Modal -->
                    <div id="hapModal" class="hap-modal" style="display: none;">
                        <div class="hap-modal-backdrop" onclick="closeHapModal()"></div>
                        <div class="hap-modal-content">
                            <div class="hap-modal-header">
                                <h3>Add New HAP Article</h3>
                                <span class="hap-modal-close" onclick="closeHapModal()">&times;</span>
                            </div>
                            <div class="hap-modal-body">
                                <form id="hapForm" action="handler/admin_hap_handler.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" id="hapId" name="id">
                                    <input type="hidden" id="currentHapImage" name="currentImage">
                                    
                                    <div class="hap-form-group">
                                        <label for="hapImage">Upload Image:</label>
                                        <div class="file-upload-container">
                                            <input type="file" id="hapImage" name="hapImage" accept="image/*" style="display: none;" onchange="handleHapFileSelect(this)">
                                            <button type="button" id="hapImageBtn" class="file-upload-btn" onclick="document.getElementById('hapImage').click()">Choose File</button>
                                            <span id="hapImageStatus" class="file-status">No file selected</span>
                                            <button type="button" id="deleteHapImageBtn" class="file-delete-btn" style="display: none;" onclick="removeHapSelectedFile()">Remove</button>
                                        </div>
                                        <div id="hapImagePreview" class="image-preview" style="display: none;">
                                            <img src="" alt="Preview" />
                                        </div>
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="hapTitle">Article Title *</label>
                                        <input type="text" id="hapTitle" name="title" placeholder="Enter article title" required>
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="hapCategory">Category *</label>
                                        <select id="hapCategory" name="category" required>
                                            <option value="">Select category</option>
                                            <option value="COMMUNITY IMPACT">Community Impact</option>
                                            <option value="ATHLETES">Athletes</option>
                                            <option value="IN THE NEWS">In The News</option>
                                            <option value="HEALTH SCREENING">Health Screening</option>
                                            <option value="WELLNESS PROGRAM">Wellness Program</option>
                                            <option value="PARTNERSHIP">Partnership</option>
                                        </select>
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="hapDescription">Description *</label>
                                        <textarea id="hapDescription" name="description" placeholder="Enter article description" rows="4" required></textarea>
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="hapLearnMoreLink">Learn More Link (optional)</label>
                                        <input type="url" id="hapLearnMoreLink" name="learnMoreLink" placeholder="https://example.com">
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="hapDisplayOrder">Display Order</label>
                                        <input type="number" id="hapDisplayOrder" name="displayOrder" placeholder="Order (optional)" min="1">
                                    </div>
                                    
                                    <div class="hap-modal-actions">
                                        <button type="button" class="btn-cancel" onclick="closeHapModal()">Cancel</button>
                                        <button type="submit" class="btn-submit" id="submitHapBtn">Add Article</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- HAP Edit Modal -->
                    <div id="hapEditModal" class="hap-modal hap-edit-modal" style="display: none;">
                        <div class="hap-modal-backdrop" onclick="closeHapEditModal()"></div>
                        <div class="hap-modal-content">
                            <div class="hap-modal-header edit-modal-header">
                                <h3><i class="fas fa-edit"></i> Edit HAP Article</h3>
                                <span class="hap-modal-close" onclick="closeHapEditModal()">&times;</span>
                            </div>
                            <div class="hap-modal-body">
                                <form id="hapEditForm" action="handler/admin_hap_handler.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" id="editHapId" name="id">
                                    <input type="hidden" id="currentEditHapImage" name="currentImage">
                                    <input type="hidden" name="action" value="update">
                                    
                                    <div class="hap-form-group">
                                        <label for="editHapImage">Upload New Image:</label>
                                        <div class="file-upload-container">
                                            <input type="file" id="editHapImage" name="hapImage" accept="image/*" style="display: none;" onchange="handleEditHapFileSelect(this)">
                                            <button type="button" id="editHapImageBtn" class="file-upload-btn" onclick="document.getElementById('editHapImage').click()">Choose New File</button>
                                            <span id="editHapImageStatus" class="file-status">Current image loaded</span>
                                            <button type="button" id="deleteEditHapImageBtn" class="file-delete-btn" style="display: none;" onclick="removeEditHapSelectedFile()">Remove</button>
                                        </div>
                                        <div id="editHapImagePreview" class="image-preview" style="display: none;">
                                            <img src="" alt="Preview" />
                                        </div>
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="editHapTitle">Article Title *</label>
                                        <input type="text" id="editHapTitle" name="title" placeholder="Enter article title" required>
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="editHapCategory">Category *</label>
                                        <select id="editHapCategory" name="category" required>
                                            <option value="">Select category</option>
                                            <option value="COMMUNITY IMPACT">Community Impact</option>
                                            <option value="ATHLETES">Athletes</option>
                                            <option value="IN THE NEWS">In The News</option>
                                            <option value="HEALTH SCREENING">Health Screening</option>
                                            <option value="WELLNESS PROGRAM">Wellness Program</option>
                                            <option value="PARTNERSHIP">Partnership</option>
                                        </select>
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="editHapDescription">Description *</label>
                                        <textarea id="editHapDescription" name="description" placeholder="Enter article description" rows="4" required></textarea>
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="editHapLearnMoreLink">Learn More Link (optional)</label>
                                        <input type="url" id="editHapLearnMoreLink" name="learnMoreLink" placeholder="https://example.com">
                                    </div>
                                    
                                    <div class="hap-form-group">
                                        <label for="editHapDisplayOrder">Display Order</label>
                                        <input type="number" id="editHapDisplayOrder" name="displayOrder" placeholder="Order (optional)" min="1">
                                    </div>
                                    
                                    <div class="hap-modal-actions">
                                        <button type="button" class="btn-cancel" onclick="closeHapEditModal()">Cancel</button>
                                        <button type="submit" class="btn-submit edit-btn-submit" id="submitEditHapBtn">Update Article</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="hap-list-admin">
                        <div class="hap-stats-bar">
                            <div class="hap-stat-item">
                                <i class="fas fa-newspaper"></i>
                                <div>
                                    <span class="hap-stat-value" id="hapTotalCount">0</span>
                                    <span class="hap-stat-label">Total Articles</span>
                                </div>
                            </div>
                            <div class="hap-stat-item">
                                <i class="fas fa-users"></i>
                                <div>
                                    <span class="hap-stat-value" id="hapCommunityCount">0</span>
                                    <span class="hap-stat-label">Community Impact</span>
                                </div>
                            </div>
                            <div class="hap-stat-item">
                                <i class="fas fa-stethoscope"></i>
                                <div>
                                    <span class="hap-stat-value" id="hapHealthCount">0</span>
                                    <span class="hap-stat-label">Health Programs</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="published-title">
                            <div>
                                <h3>Published Articles</h3>
                                <p>Drag to reorder • Click to edit</p>
                            </div>
                            <div class="hap-view-controls">
                                <button class="view-toggle-btn active" data-view="grid" onclick="toggleHapView('grid')">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button class="view-toggle-btn" data-view="list" onclick="toggleHapView('list')">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div id="existingHap" class="existing-hap-container hap-grid-view">
                            <!-- HAP articles will be loaded here via JavaScript -->
                            <div class="hap-empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <h3>No Articles Yet</h3>
                                <p>Start building your Healthy Athletes Program content by adding your first article</p>
                                <button class="btn-primary" onclick="openHapModal()">
                                    <i class="fas fa-plus"></i>
                                    Add First Article
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Young Athletes -->
            <div class="content-section" id="yap">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon articles">
                            <i class="fas fa-child"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Young Athletes Program (YAP)</h2>
                            <p class="section-subtitle">Manage YAP overview articles, resources and the "learn more" page.</p>
                        </div>
                    </div>
                    <button class="add-yap-btn" onclick="openYapModal()">
                        <i class="fas fa-edit"></i> Edit YAP Content
                    </button>
                </div>
                
                <!-- YAP Content Display with Admin Friendly Layout -->
                <div class="yap-admin-dashboard">
                    <!-- Key Information Cards -->
                    <div class="yap-cards-grid">
                        <!-- Hero Section Card -->
                        <div class="yap-info-card yap-hero-card">
                            <div class="yap-card-header">
                                <h3><i class="fas fa-image"></i> Hero Section</h3>
                                <span class="yap-card-status" id="heroStatus">Not Set</span>
                            </div>
                            <div class="yap-card-body">
                                <div class="yap-hero-image-container">
                                    <img id="yapHeroImagePreview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='150'%3E%3Crect fill='%23e2e8f0' width='200' height='150'/%3E%3Ctext x='50%25' y='50%25' font-size='14' fill='%2364748b' text-anchor='middle' dominant-baseline='middle'%3ENo Image%3C/text%3E%3C/svg%3E" alt="Hero Image" class="yap-hero-img">
                                </div>
                                <div class="yap-hero-info">
                                    <label>Hero Title</label>
                                    <p id="yapHeroTitleDisplay" class="yap-display-text">Not Set</p>
                                </div>
                            </div>
                        </div>

                        <!-- Description Card -->
                        <div class="yap-info-card yap-description-card">
                            <div class="yap-card-header">
                                <h3><i class="fas fa-align-left"></i> Description</h3>
                                <span class="yap-card-status" id="descriptionStatus">Not Set</span>
                            </div>
                            <div class="yap-card-body">
                                <div class="yap-description-content">
                                    <div id="yapDescriptionDisplay" class="yap-display-content">Not Set</div>
                                    <div class="yap-char-count">
                                        <small id="yapDescriptionCharCount">0 characters</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial Card -->
                        <div class="yap-info-card yap-testimonial-card">
                            <div class="yap-card-header">
                                <h3><i class="fas fa-quote-left"></i> Testimonial</h3>
                                <span class="yap-card-status" id="testimonialStatus">Not Set</span>
                            </div>
                            <div class="yap-card-body">
                                <div id="yapTestimonialDisplay" class="yap-display-content yap-testimonial-text">Not Set</div>
                                <div class="yap-testimonial-meta">
                                    <label>By:</label>
                                    <p id="yapTestimonialAuthorDisplay" class="yap-meta-text">Not Set</p>
                                    <label>Location:</label>
                                    <p id="yapTestimonialLocationDisplay" class="yap-meta-text">Not Set</p>
                                </div>
                            </div>
                        </div>

                        <!-- Resources Card -->
                        <div class="yap-info-card yap-resources-card">
                            <div class="yap-card-header">
                                <h3><i class="fas fa-book"></i> Resources</h3>
                                <span class="yap-card-status" id="resourcesStatus">Not Set</span>
                            </div>
                            <div class="yap-card-body">
                                <div>
                                    <label>Resources Title</label>
                                    <p id="yapResourcesTitleDisplay" class="yap-display-text">Not Set</p>
                                </div>
                                <div>
                                    <label>Resources Description</label>
                                    <div id="yapResourcesDescriptionDisplay" class="yap-display-content">Not Set</div>
                                </div>
                                <div>
                                    <label>Button Text</label>
                                    <p id="yapResourcesButtonTextDisplay" class="yap-display-text">Not Set</p>
                                </div>
                                <div>
                                    <label>Button Link</label>
                                    <a id="yapResourcesButtonLinkDisplay" href="#" class="yap-link" target="_blank">Not Set</a>
                                </div>
                            </div>
                        </div>

                        <!-- Resources Image Card -->
                        <div class="yap-info-card yap-resources-image-card">
                            <div class="yap-card-header">
                                <h3><i class="fas fa-image"></i> Resources Image</h3>
                                <span class="yap-card-status" id="resourcesImageStatus">Not Set</span>
                            </div>
                            <div class="yap-card-body">
                                <div class="yap-resources-image-container">
                                    <img id="yapResourcesImagePreview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='150'%3E%3Crect fill='%23e2e8f0' width='200' height='150'/%3E%3Ctext x='50%25' y='50%25' font-size='14' fill='%2364748b' text-anchor='middle' dominant-baseline='middle'%3ENo Image%3C/text%3E%3C/svg%3E" alt="Resources Image" class="yap-resources-img">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated Info -->
                    <div class="yap-footer-info">
                        <div class="yap-update-info">
                            <small>Last Updated: <span id="yapLastUpdate">Never</span></small>
                        </div>
                        <div class="yap-action-links">
                            <a href="../src/yap.php" target="_blank" class="yap-view-link">
                                <i class="fas fa-external-link-alt"></i> View YAP Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="content-section" id="documents">
                <div class="section-header">
                    <h2 class="section-title">Documents Management</h2>
                    <p class="section-subtitle">Upload and manage documents</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-file-alt"></i>
                    <h3>Documents Content</h3>
                    <p>Add your documents management interface here</p>
                </div>
            </div>

            <!-- Gallery/Photos Section -->
            <div class="content-section" id="photos">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon media">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Photo Management</h2>
                            <p class="section-subtitle">Manage gallery photos and collections</p>
                        </div>
                    </div>
                    <button class="add-photo-btn" onclick="openPhotoModal()">
                        <i class="fas fa-plus"></i> Add Photo
                    </button>
                </div>

                <div class="galphoto-management-container">
                    <!-- Photo Form Modal -->
                    <div class="photo-modal" id="photoModal">
                        <div class="photo-modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Add New Photo</h3>
                                <button class="modal-close" onclick="closePhotoModal()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <form id="galleryPhoto" action="../admin/handler/admin_gallery_photo_handler.php" method="POST"
                                enctype="multipart/form-data">
                        <input type="hidden" id="galleryPhotoId" name="id">
                        <input type="hidden" id="currentGalleryPhotoImage" name="currentImage">
                        <div class="galphoto-form-group">
                            <label for="galleryPhotoImage">Upload Image: <span
                                    style="color: #e53935;">*required</span></label>
                            <label for="galleryPhotoImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="galleryPhotoImage" name="galleryPhotoImage[]" accept="image/*" multiple
                                style="display: none;">
                            <button type="button" id="deleteGalleryPhotoImageBtn"
                                class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="galleryPhotoImageStatus">No file selected.</span>
                            <div style="font-size: 12px; color: #666; margin-top: 5px;">
                                <i class="fa-solid fa-info-circle"></i> Select multiple images to upload in batch. All images are automatically compressed and resized (max 1920x1080) for optimal performance
                            </div>
                            <img id="galleryPhotoImagePreview" src="" alt="Image Preview"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="galphoto-form-group">
                            <label for="galleryPhotoAlbum">Select Existing Collection: <span
                                    style="color: #e53935;">*required</span></label>
                            <select style="font-family: 'Inter', sans-serif;" id="galleryPhotoAlbum"
                                name="galleryPhotoAlbum">
                                <option value="">Fetching data...</option>
                            </select>
                        </div>
                        <div class="galphoto-form-group">
                            <!-- Adds an album / event / category for the admin's dropdown options, and to display to the end-user's interface -->
                            <label for="galleryPhotoNewAlbum">New Collection Name</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoNewAlbum"
                                name="galleryPhotoNewAlbum" placeholder="Healthy Athletes Program">
                        </div>
                        <div class="galphoto-form-group">
                            <!-- Add a description for the end-user's interface -->
                            <label for="galleryPhotoNewAlbumDesc">New Collection Descriptions (recommended)</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoNewAlbumDesc"
                                name="galleryPhotoNewAlbumDesc"
                                placeholder="The Healthy Athletes Program video category showcases content promoting health, fitness, and wellness initiatives for athletes with intellectual disabilities.">
                        </div>
                                <button type="submit" class="galphoto-submit-btn" id="submitGalleryPhotoBtn">Publish</button>
                            </form>
                        </div>
                    </div>

                    <div class="gallery-admin-container">
                        <div class="gallery-admin-title">
                            <h3>Published Photos</h3>
                            <small style="color: #6b7280; margin-left: 10px;">💡 Drag gallery headers to reorder collections, drag photos to reorder within collections</small>
                        </div>
                        <!-- Fetch the published collections from the database -->
                        <!-- Below is just a hard-coded structure sample, not connected to the database -->
                        <div id="publishedGalleryPhoto">
                            <!-- <p style="text-align: center; color: #333;">Fetching videos from the database...</p> -->
                            <!-- Published videos will be loaded here via AJAX, such as -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opens to display collection edit modal, save or discard the changes (Reusable for Photos and Videos) -->
            <div class="galphoto-modal-album" id="galphoto-modal-album" style="display: none;">
                <div class="galphoto-modal-album-content">
                    <div class="gpmac-desc">
                        <div class="gpmac-form-group">
                            <label>Collection Name</label>
                            <!-- Fetch collection name from the database -->
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoAlbumEdit"
                                name="galleryPhotoAlbumEdit">
                        </div>
                        <div class="gpmac-form-group">
                            <label>Descriptions</label>
                            <!-- Fetch descriptions from the database -->
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoAlbumDescEdit"
                                name="galleryPhotoAlbumDescEdit">
                        </div>
                    </div>
                    <div class="gpmac-options">
                        <button class="delete-btn" id="galphoto-modal-album-close">Cancel</button>
                        <button type="edit" class="edit-btn" id="saveGalleryPhotoAlbumEdit">Save</button>
                    </div>
                </div>
            </div>

            <!-- Opens a delete collection modal to prompt an admin for confirmation (Reusable for Photos and Videos) -->
            <div class="gallery-modal-album" id="gallery-modal-delete-album" style="display: none;">
                <div class="gallery-modal-album-content">
                    <div class="gmac-desc">
                        <h3>Delete Collection</h3>
                        <p>Deleting this collection will permanently remove all contents. This action cannot be undone.
                            Are you sure you want to continue?</p>
                        <p>The delete button will be available in 5 second(s).</p>
                    </div>
                    <div class="gmac-options">
                        <button class="cancel-btn" id="gallery-modal-album-close">Cancel</button>
                        <!-- 5 seconds delay before the delete button is clickable -->
                        <button class="delete-btn" id="deleteGalleryAlbum">Delete</button>
                    </div>
                </div>
            </div>

            <!-- Opens a modal to display an image, edit/delete an image (Specifically for Photos) -->
            <div class="galphoto-modal" id="galphoto-modal" style="display: none;">
                <div class="galphoto-modal-content">
                    <span class="modal-close" id="galphoto-modal-close"><i class="fa-solid fa-xmark"></i></span>
                    <img src="../assets/images/yap-lm/YAP PIP 16-9.png" alt="Image Preview" class="galphoto-modal-image"
                        id="galphoto-modal-image">
                    <h3 class="galphoto-modal-title" id="galphoto-modal-title">File Name:</h3>
                    <p class="galphoto-modal-filename" id="galphoto-modal-filename">This is the file name such as
                        photo.jpg</p>
                    <div class="galphoto-modal-options" style="margin-top: 20px;">
                        <button class="delete-btn" id="deleteGalleryPhotoBtn">Delete</button>
                    </div>
                </div>
            </div>

            <!-- Gallery/Videos Section -->
            <div class="content-section" id="videos">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon media">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Video Management</h2>
                            <p class="section-subtitle">Upload and manage videos in the gallery. The recommended maximum
                        video resolution is <strong>1920×1080</strong>, with a <strong>video bitrate between 2–6
                            Mbps</strong> and an <strong>audio bitrate of 128 kbps (AAC)</strong> to help prevent
                        buffering issues. Since the admin webmaster does <strong>not support automatic video
                            compression</strong> like most streaming platforms, you'll need to <strong>manually compress
                            your original video</strong> into the MP4 format before uploading.<br><br>*This video
                        management interface is under development.</p>
                        </div>
                    </div>
                    <button id="addVideoBtn" class="add-video-btn">
                        <i class="fas fa-plus"></i> Add Video
                    </button>
                </div>

                <div class="galvideo-management-container">
                    <div class="gallery-admin-container">
                        <div class="gallery-admin-title">
                            <h3>Published Videos</h3>
                            <small style="color: #6b7280; margin-left: 10px;">💡 Drag gallery headers to reorder collections, drag videos to reorder within collections</small>
                        </div>
                        <div id="publishedGalleryVideo">
                            <!-- Published videos will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333;">Loading videos...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opens a modal to display an image, edit/delete an image (Specifically for Videos) -->
            <div class="galvideo-modal" id="galvideo-modal" style="display: none;">
                <div class="galvideo-modal-content">
                    <span class="modal-close" id="galvideo-modal-close"><i class="fa-solid fa-xmark"></i></span>
                    <div class="galvideo-form-group cover">
                        <!-- Hover on image to display browse -->
                        <img src="../assets/images/yap-lm/YAP PIP 16-9.png" alt="Video Thumbnail"
                            class="galvideo-modal-image" id="galvideo-modal-image">
                        <div class="gvmfg-options">
                            <button class="play-btn"><i class="fa-solid fa-play"
                                    style="margin-right: 12px;"></i>Play</button>
                            <button class="change-btn">Change Video Cover</button>
                        </div>
                    </div>
                    <div class="galvideo-form-group">
                        <label for="galleryVideoTitleEdit">Video Title: </label>
                        <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryVideoTitleEdit"
                            name="galleryVideoTitleEdit" required>
                    </div>
                    <div class="galvideo-form-group">
                        <label for="galleryVideoDescEdit">Descriptions: </label>
                        <!-- Fetch video descriptions from the database to be display here and is editable -->
                        <textarea id="galleryVideoDescEdit" name="galleryVideoDescEdit"></textarea>
                    </div>
                    <div class="galvideo-form-group">
                        <label for="galleryVideoAlbumEdit">Collection: </label>
                        <select id="galleryVideoAlbumEdit" name="galleryVideoAlbumEdit">
                            <!-- Fetch from the existing collections dropdown options here -->
                        </select>
                    </div>
                    <div class="galvideo-modal-options" style="margin-top: 20px;">
                        <button class="delete-btn">Delete</button>
                        <button type="edit" class="save-edit-btn" id="saveGalleryVideoEdit">Save</button>
                    </div>
                </div>
            </div>

            <!-- Sarawak Chapters -->
            <div class="content-section" id="sarawak-chapters">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon-wrapper chapters-icon-wrapper">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Sarawak Chapters</h2>
                            <p class="section-subtitle">Manage regional chapters across Sarawak</p>
                        </div>
                    </div>
                </div>

                <div class="chapters-management-container">
                    <div class="chapters-list-admin">
                        <div class="chapters-stats-bar">
                            <div class="chapter-stat-item">
                                <i class="fas fa-building"></i>
                                <div>
                                    <span class="chapter-stat-value" id="chapterTotalCount">0</span>
                                    <span class="chapter-stat-label">Total Chapters</span>
                                </div>
                            </div>
                            <div class="chapter-stat-item">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <span class="chapter-stat-value" id="chapterActiveCount">0</span>
                                    <span class="chapter-stat-label">Active</span>
                                </div>
                            </div>
                            <div class="chapter-stat-item">
                                <i class="fas fa-users"></i>
                                <div>
                                    <span class="chapter-stat-value" id="chapterLeadersCount">0</span>
                                    <span class="chapter-stat-label">Board Members</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="published-title">
                            <h3>Regional Chapters</h3>
                            <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Click Edit to update chapter information</p>
                        </div>
                        
                        <div id="existingChapters" class="chapters-grid">
                            <!-- Chapters will be loaded here via AJAX -->
                            <div class="chapters-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Loading chapters...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sponsorships -->
            <div class="content-section" id="sponsorships">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon affiliates">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Sponsorships Management</h2>
                            <p class="section-subtitle">Manage sponsors grouped by chapter. Each chapter has its own sponsor list for easy tracking.</p>
                        </div>
                    </div>
                    <button class="add-sponsorship-btn" onclick="openSponsorshipModal()">
                        <i class="fas fa-plus"></i> Add Sponsor
                    </button>
                </div>

                <div class="sponsorship-management-container">
                    <!-- Chapter Tabs Navigation -->
                    <div class="sponsorship-tabs">
                        <button class="sponsorship-tab active" data-chapter="all" onclick="filterSponsorshipsByChapter('all')">
                            <i class="fas fa-globe"></i> All Sponsors
                        </button>
                        <button class="sponsorship-tab" data-chapter="0" onclick="filterSponsorshipsByChapter('0')">
                            <i class="fas fa-star"></i> SO Sarawak
                        </button>
                        <button class="sponsorship-tab" data-chapter="1" onclick="filterSponsorshipsByChapter('1')">
                            <i class="fas fa-map-marker-alt"></i> Kuching
                        </button>
                        <button class="sponsorship-tab" data-chapter="2" onclick="filterSponsorshipsByChapter('2')">
                            <i class="fas fa-map-marker-alt"></i> Samarahan
                        </button>
                        <button class="sponsorship-tab" data-chapter="3" onclick="filterSponsorshipsByChapter('3')">
                            <i class="fas fa-map-marker-alt"></i> Sibu
                        </button>
                        <button class="sponsorship-tab" data-chapter="4" onclick="filterSponsorshipsByChapter('4')">
                            <i class="fas fa-map-marker-alt"></i> Bintulu
                        </button>
                        <button class="sponsorship-tab" data-chapter="5" onclick="filterSponsorshipsByChapter('5')">
                            <i class="fas fa-map-marker-alt"></i> Miri
                        </button>
                    </div>

                    <!-- Sponsorship Statistics Summary -->
                    <div class="sponsorship-stats" id="sponsorshipStats">
                        <div class="stat-card">
                            <span class="stat-number" id="totalSponsorsCount">0</span>
                            <span class="stat-label">Total Sponsors</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number" id="stateSponsorsCount">0</span>
                            <span class="stat-label">State Level</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number" id="chapterSponsorsCount">0</span>
                            <span class="stat-label">Chapter Level</span>
                        </div>
                    </div>

                    <!-- Sponsorship List by Chapter -->
                    <div class="sponsorship-list-admin">
                        <div class="published-title">
                            <h3 id="sponsorshipListTitle">All Sponsors</h3>
                            <span class="sponsor-count" id="currentFilterCount"></span>
                        </div>
                        <div id="currentSponsorship" class="sponsorship-grid">
                            <!-- Sponsors will be loaded here via AJAX grouped by chapter -->
                            <p style="text-align: center; color: #64748b;">Loading sponsors...</p>
                        </div>
                    </div>
                </div>

                <!-- Sponsorship Form Modal -->
                <div class="sponsorship-modal" id="sponsorshipModal" style="display: none;">
                    <div class="sponsorship-modal-backdrop" onclick="closeSponsorshipModal()"></div>
                    <div class="sponsorship-modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Add New Sponsor</h3>
                            <span class="modal-close" onclick="closeSponsorshipModal()">&times;</span>
                        </div>
                        <form id="sponsorshipForm" action="handler/admin_sponsorship_handler.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="sponsorshipId" name="id">
                            <input type="hidden" id="currentSponsorshipImage" name="currentSponsorshipImage">
                            
                            <div class="sponsorship-form-group">
                                <label for="sponsorshipName">Sponsor Name *</label>
                                <input type="text" id="sponsorshipName" name="sponsorshipName" placeholder="Enter sponsor/company name" required>
                            </div>
                            
                            <div class="sponsorship-form-group">
                                <label for="sponsorshipChapter">Chapter Assignment *</label>
                                <select style="font-family: 'Inter', sans-serif;" id="sponsorshipChapter" name="sponsorshipChapter" required>
                                    <option value="">-- Select Chapter --</option>
                                    <option value="0">Special Olympics Sarawak (State Level)</option>
                                    <option value="1">Kuching Chapter</option>
                                    <option value="2">Samarahan Chapter</option>
                                    <option value="3">Sibu Chapter</option>
                                    <option value="4">Bintulu Chapter</option>
                                    <option value="5">Miri Chapter</option>
                                </select>
                            </div>
                            
                            <div class="sponsorship-form-group">
                                <label for="sponsorshipTier">Sponsor Tier</label>
                                <select style="font-family: 'Inter', sans-serif;" id="sponsorshipTier" name="sponsorshipTier">
                                    <option value="supporter">Supporter</option>
                                    <option value="bronze">Bronze</option>
                                    <option value="silver">Silver</option>
                                    <option value="gold">Gold</option>
                                    <option value="platinum">Platinum</option>
                                </select>
                            </div>
                            
                            <div class="sponsorship-form-group">
                                <label for="sponsorshipImage">Sponsor Logo *</label>
                                <div class="file-upload-container">
                                    <input type="file" id="sponsorshipImage" name="sponsorshipImage" accept="image/*" style="display: none;">
                                    <button type="button" class="file-upload-btn" onclick="document.getElementById('sponsorshipImage').click()">
                                        <i class="fas fa-upload"></i> Choose Logo
                                    </button>
                                    <span id="sponsorshipImageStatus" class="file-status">No file selected</span>
                                    <button type="button" id="deleteSponsorshipImageBtn" class="file-delete-btn" style="display: none;">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                                <div id="sponsorshipImagePreview" class="image-preview" style="display: none;">
                                    <img src="" alt="Preview" style="max-width: 150px; max-height: 100px; margin-top: 10px; border-radius: 8px; object-fit: contain;">
                                </div>
                            </div>
                            
                            <div class="sponsorship-form-group">
                                <label for="sponsorshipOrder">Display Order</label>
                                <input type="number" id="sponsorshipOrder" name="sponsorshipOrder" placeholder="Order (lower = first)" min="0" value="0">
                            </div>
                            
                            <div class="sponsorship-modal-actions">
                                <button type="button" class="btn-cancel" onclick="closeSponsorshipModal()">Cancel</button>
                                <button type="submit" class="btn-submit" id="submitSponsorshipBtn">Add Sponsor</button>
                                <button type="button" class="btn-cancel" id="cancelSponsorshipEditBtn" style="display: none;">Cancel Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Other Special Olympics -->
            <div class="content-section" id="other-special-olympics">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon affiliates">
                            <i class="fas fa-globe-americas"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Special Olympics Organizations Management</h2>
                            <p class="section-subtitle">Manage Special Olympics organizations in Malaysia and states</p>
                        </div>
                    </div>
                    <button class="add-other-so-btn" onclick="openOtherSOModal('add')">
                        <i class="fas fa-plus"></i> Add Organization
                    </button>
                </div>

                <!-- Statistics Overview -->
                <div class="other-so-stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="stat-content">
                            <h4 class="stat-value" id="totalOtherSO">0</h4>
                            <p class="stat-label">Total Organizations</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h4 class="stat-value" id="activeOtherSO">0</h4>
                            <p class="stat-label">Active</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-flag"></i>
                        </div>
                        <div class="stat-content">
                            <h4 class="stat-value" id="statesCount">0</h4>
                            <p class="stat-label">States & Territories</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h4 class="stat-value" id="inactiveOtherSO">0</h4>
                            <p class="stat-label">Inactive</p>
                        </div>
                    </div>
                </div>

                <!-- Filter Controls -->
                <div class="other-so-controls">
                    <div class="filter-buttons">
                        <button class="filter-btn active" onclick="filterOtherSOByCategory('all')">
                            <i class="fas fa-globe"></i> All
                        </button>
                        <!-- Removed International filter -->
                        <button class="filter-btn" onclick="filterOtherSOByCategory('malaysia')">
                            <i class="fas fa-star"></i> Malaysia
                        </button>
                        <button class="filter-btn" onclick="filterOtherSOByCategory('state')">
                            <i class="fas fa-map-marked-alt"></i> States
                        </button>
                    </div>
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search organizations..." 
                               onkeyup="searchOtherSO(this.value)">
                    </div>
                </div>

                <!-- Organizations List -->
                <div class="other-so-management-container">
                    <div id="otherSOList" class="other-so-list">
                        <!-- Organizations will be loaded here via JavaScript -->
                        <div class="loading-spinner">Loading organizations...</div>
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="content-section" id="settings">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon settings">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Settings</h2>
                            <p class="section-subtitle">Configure your admin panel settings</p>
                        </div>
                    </div>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-cog"></i>
                    <h3>Settings Content</h3>
                    <p>Add your settings interface </p>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="content-section" id="profile">
                <div class="section-header">
                    <div class="section-header-content">
                        <div class="section-icon settings">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="section-text">
                            <h2 class="section-title">Profile</h2>
                            <p class="section-subtitle">Manage your admin profile and security settings</p>
                        </div>
                    </div>
                </div>

                <div class="profile-container">
                    <!-- Profile Navigation Tabs -->
                    <div class="profile-tabs" style="display: flex; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0;">
                        <button class="profile-tab active" data-tab="information" style="padding: 12px 24px; border: none; background: #3b82f6; color: white; cursor: pointer; border-radius: 8px 8px 0 0; margin-right: 5px; position: relative; z-index: 10; pointer-events: auto;" onclick="
                            console.log('Information tab clicked');
                            document.getElementById('security-tab').style.display = 'none';
                            document.getElementById('information-tab').style.display = 'block';
                            document.querySelector('[data-tab=security]').style.backgroundColor = '#f1f5f9';
                            document.querySelector('[data-tab=security]').style.color = '#475569';
                            this.style.backgroundColor = '#3b82f6';
                            this.style.color = 'white';
                        ">
                            <i class="fas fa-user"></i>
                            Information
                        </button>
                        <button class="profile-tab" data-tab="security" style="padding: 12px 24px; border: none; background: #f1f5f9; color: #475569; cursor: pointer; border-radius: 8px 8px 0 0; position: relative; z-index: 10; pointer-events: auto;" onclick="
                            console.log('Security tab clicked');
                            document.getElementById('information-tab').style.display = 'none';
                            document.getElementById('security-tab').style.display = 'block';
                            document.querySelector('[data-tab=information]').style.backgroundColor = '#f1f5f9';
                            document.querySelector('[data-tab=information]').style.color = '#475569';
                            this.style.backgroundColor = '#3b82f6';
                            this.style.color = 'white';
                        ">
                            <i class="fas fa-lock"></i>
                            Security
                        </button>
                    </div>

                    <!-- Information Tab -->
                    <div class="profile-tab-content active" id="information-tab" style="display: block;">
                        <div class="profile-card">
                            <div class="profile-avatar-section">
                                <div class="profile-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="profile-basic-info">
                                    <h3 id="profileDisplayName">Loading...</h3>
                                    <p id="profileDisplayPosition">Loading...</p>
                                </div>
                            </div>

                            <form id="profileInfoForm" class="profile-form" onsubmit="return false;">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="profileFullName">Full Name</label>
                                        <input type="text" id="profileFullName" name="fullname" placeholder="Loading..." required>
                                    </div>
                                    <div class="form-group">
                                        <label for="profileEmail">Email Address</label>
                                        <input type="email" id="profileEmail" name="email" placeholder="Loading..." required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="profilePhone">Phone Number</label>
                                        <input type="tel" id="profilePhone" name="phone" placeholder="Loading...">
                                    </div>
                                    <div class="form-group">
                                        <label for="profilePosition">Position</label>
                                        <input type="text" id="profilePosition" name="position" placeholder="Loading...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="profileBio">Biography</label>
                                    <textarea id="profileBio" name="bio" rows="4" placeholder="Tell us about yourself..."></textarea>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn-secondary" onclick="resetProfileForm()">Reset</button>
                                    <button type="button" class="btn-primary" onclick="submitProfileForm()">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="profile-tab-content" id="security-tab" style="display: none;">
                        <div class="profile-card">
                            <h4>Change Password</h4>
                            <p class="security-description">Update your password to keep your account secure.</p>
                            
                            <form id="passwordChangeForm" class="profile-form">
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" id="currentPassword" name="currentPassword" required>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" id="newPassword" name="newPassword" required>
                                    <div class="password-requirements">
                                        <small>Password must be at least 8 characters long and contain a mix of letters and numbers.</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm New Password</label>
                                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn-secondary" onclick="resetPasswordForm()">Reset</button>
                                    <button type="submit" class="btn-primary">Update Password</button>
                                </div>
                            </form>

                            <div class="security-info">
                                <div class="security-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <div>
                                        <h5>Account Security</h5>
                                        <p>Your account is protected with secure authentication.</p>
                                    </div>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <h5>Last Password Change</h5>
                                        <p id="lastPasswordChange">Never changed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add News Modal - Only for News Section -->
    <div id="addNewsModal" class="news-modal" style="display: none;">
        <div class="news-modal-backdrop" onclick="closeNewsModal()"></div>
        <div class="news-modal-content">
            <div class="news-modal-header">
                <h3>Add New News Article</h3>
                <span class="news-modal-close" onclick="closeNewsModal()">&times;</span>
            </div>
            <div class="news-modal-body">
                <form id="addNewsForm" action="handler/admin_news_handler.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="newsId" name="id">
                    <input type="hidden" id="currentNewsImage" name="currentImage">
                    <div class="news-form-group">
                        <label for="newsImage">Upload Image:</label>
                        <div class="file-upload-container">
                            <input type="file" id="newsImage" name="newsImage" accept="image/*" style="display: none;" onchange="handleFileSelect(this)">
                            <button type="button" id="newsImageBtn" class="file-upload-btn" onclick="document.getElementById('newsImage').click()">Choose File</button>
                            <span id="newsImageStatus" class="file-status">No file selected</span>
                            <button type="button" id="deleteNewsImageBtn" class="file-delete-btn" style="display: none;" onclick="removeSelectedFile()">Remove</button>
                        </div>
                        <div id="newsImagePreview" class="image-preview" style="display: none;">
                            <img src="" alt="Preview" />
                        </div>
                    </div>
                    <div class="news-form-group">
                        <label for="newsHeadline">Headline *</label>
                        <input type="text" id="newsHeadline" name="newsHeadline" placeholder="Enter news headline" required>
                    </div>
                    <div class="news-form-group">
                        <label for="newsDate">Date *</label>
                        <input type="date" id="newsDate" name="newsDate" required>
                    </div>
                    <div class="news-form-group">
                        <label for="newsDescription">Description *</label>
                        <textarea id="newsDescription" name="newsDescription" placeholder="Enter news description" rows="4" required></textarea>
                    </div>
                    <div class="news-modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeNewsModal()">Cancel</button>
                        <button type="submit" class="btn-submit">Add News Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Video Modal - Only for Videos Section -->
    <div id="addVideoModal" class="video-modal" style="display: none;">
        <div class="video-modal-backdrop" onclick="closeVideoModal()"></div>
        <div class="video-modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Video</h3>
                <button class="modal-close" onclick="closeVideoModal()">&times;</button>
            </div>
            <div class="video-modal-body">
                <form id="galleryVideo" action="handler/admin_gallery_video_handler.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="galleryVideoId" name="id">
                    <input type="hidden" id="currentGalleryVideoImage" name="currentImage">
                    
                    <div class="video-form-group">
                        <label for="galleryVideo">Upload Video <span style="color: #e53935;">*required</span></label>
                        <div class="file-upload-container">
                            <input type="file" id="galleryVideo" name="galleryVideo" accept="video/mp4" style="display: none;">
                            <button type="button" id="galleryVideoBtn" class="file-upload-btn" onclick="document.getElementById('galleryVideo').click()">Choose Video File</button>
                            <span id="galleryVideoStatus" class="file-status">No file selected</span>
                            <button type="button" id="deleteGalleryVideoBtn" class="file-delete-btn" style="display: none;">Remove</button>
                        </div>
                    </div>
                    
                    <div class="video-form-group">
                        <label for="galleryVideoImage">Video Cover Image <span style="color: #e53935;">*required</span></label>
                        <div class="file-upload-container">
                            <input type="file" id="galleryVideoImage" name="galleryVideoImage" accept="image/*" style="display: none;">
                            <button type="button" id="galleryVideoImageBtn" class="file-upload-btn" onclick="document.getElementById('galleryVideoImage').click()">Choose Cover Image</button>
                            <span id="galleryVideoImageStatus" class="file-status">No file selected</span>
                            <button type="button" id="deleteGalleryVideoImageBtn" class="file-delete-btn" style="display: none;">Remove</button>
                        </div>
                        <div id="galleryVideoImagePreview" class="image-preview" style="display: none;">
                            <img src="" alt="Video Cover Preview" />
                        </div>
                    </div>
                    
                    <div class="video-form-group">
                        <label for="galleryVideoTitle">Video Title <span style="color: #e53935;">*required</span></label>
                        <input type="text" id="galleryVideoTitle" name="galleryVideoTitle" placeholder="Enter video title" required>
                    </div>
                    
                    <div class="video-form-group">
                        <label for="galleryVideoDesc">Description</label>
                        <textarea id="galleryVideoDesc" name="galleryVideoDesc" placeholder="Enter video description" rows="4"></textarea>
                    </div>
                    
                    <div class="video-form-group">
                        <label for="galleryVideoAlbum">Select Existing Collection <span style="color: #e53935;">*required</span></label>
                        <select id="galleryVideoAlbum" name="galleryVideoAlbum" required>
                            <option value="">Select Collection</option>
                        </select>
                    </div>
                    
                    <div class="video-form-group">
                        <label for="galleryVideoAddAlbum">New Collection Name</label>
                        <input type="text" id="galleryVideoAddAlbum" name="galleryVideoAddAlbum" placeholder="Enter new collection name">
                    </div>
                    
                    <div class="video-form-group">
                        <label for="galleryVideoAlbumDesc">New Collection Description</label>
                        <input type="text" id="galleryVideoAlbumDesc" name="galleryVideoAlbumDesc" placeholder="Enter collection description for better UX">
                    </div>
                    
                    <div class="video-modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeVideoModal()">Cancel</button>
                        <button type="submit" class="btn-submit" id="submitGalleryVideoBtn">Add Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- YAP Content Management Modal -->
    <div id="yapModal" class="yap-modal" style="display: none;">
        <div class="yap-modal-backdrop" onclick="closeYapModal()"></div>
        <div class="yap-modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit YAP Content</h3>
                <span class="modal-close" onclick="closeYapModal()">&times;</span>
            </div>
            <div class="yap-modal-body">
                <form id="yapForm" enctype="multipart/form-data">
                    <input type="hidden" id="yapId" name="yap_id">
                    
                    <div class="form-group">
                        <label for="yapHeroTitle">Hero Section Title</label>
                        <input type="text" id="yapHeroTitle" name="hero_title" required>
                    </div>

                    <div class="form-group">
                        <label for="yapHeroImage">Hero Background Image</label>
                        <input type="file" id="yapHeroImage" name="hero_image" accept="image/*">
                        <div class="file-status" id="yapHeroImageStatus">No file selected</div>
                        <div id="yapHeroImagePreview" style="display: none; margin-top: 10px;">
                            <img src="" alt="Preview" style="max-width: 300px; max-height: 200px; object-fit: cover; border-radius: 4px;">
                        </div>
                        <button type="button" id="deleteYapHeroImageBtn" onclick="removeYapHeroImage()" style="display: none;">Remove Image</button>
                    </div>

                    <div class="form-group">
                        <label for="yapDescriptionText">Description Content</label>
                        <div class="rich-editor-container">
                            <div class="editor-toolbar">
                                <button type="button" class="editor-btn" onclick="formatText('bold')" title="Bold">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="formatText('italic')" title="Italic">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="formatText('underline')" title="Underline">
                                    <i class="fas fa-underline"></i>
                                </button>
                                <div class="editor-separator"></div>
                                <button type="button" class="editor-btn" onclick="formatText('insertUnorderedList')" title="Bullet List">
                                    <i class="fas fa-list-ul"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="formatText('insertOrderedList')" title="Numbered List">
                                    <i class="fas fa-list-ol"></i>
                                </button>
                                <div class="editor-separator"></div>
                                <button type="button" class="editor-btn" onclick="createLink()" title="Insert Link">
                                    <i class="fas fa-link"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="removeLink()" title="Remove Link">
                                    <i class="fas fa-unlink"></i>
                                </button>
                                <div class="editor-separator"></div>
                                <input type="color" class="color-picker" onchange="changeTextColor(this.value)" title="Text Color" value="#000000">
                                <button type="button" class="editor-btn" onclick="removeFormat()" title="Clear Formatting">
                                    <i class="fas fa-remove-format"></i>
                                </button>
                            </div>
                            <div id="yapDescriptionEditor" class="editor-content" contenteditable="true" placeholder="Enter the main YAP description content. Use the toolbar above for formatting."></div>
                        </div>
                        <textarea id="yapDescriptionText" name="description_text" style="display: none;" required></textarea>
                        <small>Use the toolbar above for rich text formatting including bold, italic, lists, links, and colors.</small>
                    </div>

                    <div class="form-group">
                        <label for="yapTestimonialText">Testimonial Text</label>
                        <div class="rich-editor-container">
                            <div class="editor-toolbar">
                                <button type="button" class="editor-btn" onclick="formatTestimonialText('bold')" title="Bold">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="formatTestimonialText('italic')" title="Italic">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <div class="editor-separator"></div>
                                <input type="color" class="color-picker" onchange="changeTestimonialTextColor(this.value)" title="Text Color" value="#000000">
                                <button type="button" class="editor-btn" onclick="removeTestimonialFormat()" title="Clear Formatting">
                                    <i class="fas fa-remove-format"></i>
                                </button>
                            </div>
                            <div id="yapTestimonialEditor" class="editor-content" contenteditable="true" placeholder="Enter testimonial quote" style="min-height: 120px;"></div>
                        </div>
                        <textarea id="yapTestimonialText" name="testimonial_text" style="display: none;"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="yapTestimonialAuthor">Testimonial Author</label>
                        <input type="text" id="yapTestimonialAuthor" name="testimonial_author" placeholder="e.g., SARAH, MOTHER OF A YOUNG ATHLETE">
                    </div>

                    <div class="form-group">
                        <label for="yapTestimonialLocation">Testimonial Location</label>
                        <input type="text" id="yapTestimonialLocation" name="testimonial_location" placeholder="e.g., KUCHING">
                    </div>

                    <div class="form-group">
                        <label for="yapResourcesTitle">Resources Section Title</label>
                        <input type="text" id="yapResourcesTitle" name="resources_title" required>
                    </div>

                    <div class="form-group">
                        <label for="yapResourcesDescription">Resources Description</label>
                        <textarea id="yapResourcesDescription" name="resources_description" rows="3" placeholder="Brief description of the resources section"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="yapResourcesButtonText">Resources Button Text</label>
                        <input type="text" id="yapResourcesButtonText" name="resources_button_text" required>
                    </div>

                    <div class="form-group">
                        <label for="yapResourcesButtonLink">Resources Button Link</label>
                        <input type="text" id="yapResourcesButtonLink" name="resources_button_link" required placeholder="e.g., ../src/yap-lm.html">
                    </div>

                    <div class="form-group">
                        <label for="yapResourcesBackgroundImage">Resources Background Image</label>
                        <input type="file" id="yapResourcesBackgroundImage" name="resources_background_image" accept="image/*">
                        <div class="file-status" id="yapResourcesImageStatus">No file selected</div>
                        <div id="yapResourcesImagePreview" style="display: none; margin-top: 10px;">
                            <img src="" alt="Preview" style="max-width: 300px; max-height: 200px; object-fit: cover; border-radius: 4px;">
                        </div>
                        <button type="button" id="deleteYapResourcesImageBtn" onclick="removeYapResourcesImage()" style="display: none;">Remove Image</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeYapModal()">Cancel</button>
                        <button type="button" class="btn-submit" id="submitYapBtn" onclick="submitYapContent()">Save YAP Content</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Chapter Edit Modal -->
    <div class="chapter-modal" id="chapterModal" style="display: none;">
        <div class="chapter-modal-backdrop" onclick="closeChapterModal()"></div>
        <div class="chapter-modal-content">
            <div class="chapter-modal-header">
                <h3>Edit Chapter Information</h3>
                <span class="chapter-modal-close" onclick="closeChapterModal()">×</span>
            </div>
            <div class="chapter-modal-body">
                <form id="chapterForm">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <img id="modalChapterLogo" src="" alt="Chapter Logo" style="width: 80px; height: 80px; object-fit: contain; border-radius: 8px; border: 2px solid #e9ecef;">
                    </div>
                    
                    <div class="form-group">
                        <label for="editChairman">Chairman <span class="required">*</span></label>
                        <input type="text" id="editChairman" name="chairman" placeholder="Enter chairman name">
                    </div>
                    
                    <div class="form-group">
                        <label for="editViceChairman">Vice Chairman <span class="required">*</span></label>
                        <input type="text" id="editViceChairman" name="vice_chairman" placeholder="Enter vice chairman name">
                    </div>
                    
                    <div class="form-group">
                        <label for="editSecretary">Secretary <span class="required">*</span></label>
                        <input type="text" id="editSecretary" name="secretary" placeholder="Enter secretary name">
                    </div>
                    
                    <div class="form-group">
                        <label for="editTreasurer">Treasurer <span class="required">*</span></label>
                        <input type="text" id="editTreasurer" name="treasurer" placeholder="Enter treasurer name">
                    </div>
                    
                    <div class="form-group">
                        <label for="editStatus">Status <span class="required">*</span></label>
                        <select id="editStatus" name="status">
                            <option value="active">Active</option>
                            <option value="upcoming">Upcoming</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="chapter-modal-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeChapterModal()">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveChapterChanges()">Update Chapter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Other Special Olympics Modal -->
    <div id="otherSOModal" class="other-so-modal" style="display: none;">
        <div class="other-so-modal-backdrop" onclick="closeOtherSOModal()"></div>
        <div class="other-so-modal-content">
            <div class="other-so-modal-header">
                <h3>Add New Organization</h3>
                <span class="other-so-modal-close" onclick="closeOtherSOModal()">&times;</span>
            </div>
            <div class="other-so-modal-body">
                <form id="otherSOForm" onsubmit="submitOtherSOForm(event)" enctype="multipart/form-data">
                    <div class="other-so-form-group">
                        <label for="otherSOName">Organization Name <span class="required">*</span></label>
                        <input type="text" id="otherSOName" name="name" required 
                               placeholder="e.g., Special Olympics Johor">
                    </div>

                    <div class="other-so-form-row">
                        <div class="other-so-form-group">
                            <label for="otherSOCategory">Category <span class="required">*</span></label>
                            <select id="otherSOCategory" name="category" required>
                                <option value="">Select Category</option>
                                <option value="malaysia">Malaysia</option>
                                <option value="state">State / Federal Territory</option>
                            </select>
                        </div>

                        <div class="other-so-form-group">
                            <label for="otherSOWebsite">Website URL</label>
                            <input type="url" id="otherSOWebsite" name="website_url" 
                                   placeholder="https://example.com">
                        </div>
                    </div>

                    <div class="other-so-form-row">
                        <div class="other-so-form-group">
                            <label for="otherSOOrder">Display Order</label>
                            <input type="number" id="otherSOOrder" name="display_order" 
                                   value="0" min="0" step="10">
                            <small class="form-hint">Lower numbers appear first</small>
                        </div>

                        <div class="other-so-form-group">
                            <label for="otherSOStatus">Status</label>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" id="otherSOStatus" name="is_active" checked>
                                <label for="otherSOStatus" class="checkbox-label">Active (Visible on website)</label>
                            </div>
                        </div>
                    </div>

                    <div class="other-so-form-group">
                        <label for="otherSODesktopLogo">Desktop Logo (Square) <span class="required">*</span></label>
                        <div class="file-upload-container">
                            <input type="file" id="otherSODesktopLogo" name="logo_desktop" 
                                   accept="image/*" style="display: none;" onchange="previewOtherSODesktopLogo(this)">
                            <button type="button" class="file-upload-btn" onclick="document.getElementById('otherSODesktopLogo').click()">
                                Choose File
                            </button>
                            <span id="otherSODesktopStatus" class="file-status">No file selected</span>
                            <button type="button" id="deleteOtherSODesktopBtn" class="file-delete-btn" style="display: none;" onclick="removeOtherSODesktopLogo()">Remove</button>
                        </div>
                        <small class="form-hint">Recommended: Square format (500x500px)</small>
                        <div id="otherSODesktopPreview" class="image-preview" style="display: none;">
                            <img src="" alt="Desktop Logo Preview" />
                        </div>
                    </div>

                    <div class="other-so-form-group">
                        <label for="otherSOMobileLogo">Mobile Logo (Horizontal)</label>
                        <div class="file-upload-container">
                            <input type="file" id="otherSOMobileLogo" name="logo_mobile" 
                                   accept="image/*" style="display: none;" onchange="previewOtherSOMobileLogo(this)">
                            <button type="button" class="file-upload-btn" onclick="document.getElementById('otherSOMobileLogo').click()">
                                Choose File
                            </button>
                            <span id="otherSOMobileStatus" class="file-status">No file selected</span>
                            <button type="button" id="deleteOtherSOMobileBtn" class="file-delete-btn" style="display: none;" onclick="removeOtherSOMobileLogo()">Remove</button>
                        </div>
                        <small class="form-hint">Recommended: Horizontal format (800x300px)</small>
                        <div id="otherSOMobilePreview" class="image-preview" style="display: none;">
                            <img src="" alt="Mobile Logo Preview" />
                        </div>
                    </div>

                    <div class="other-so-modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeOtherSOModal()">Cancel</button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Save Organization
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SortableJS for drag-and-drop functionality -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <script src="../scripts/admin-components/navigation-functionality.js"></script>
    <script src="../scripts/admin-components/event-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/news-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/gallery-photo-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/gallery-video-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    
    <!-- Modal Functionality Script -->
    <script>
        // Global modal functions
        function openNewsModal() {
            const modal = document.getElementById('addNewsModal');
            if (modal) {
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeNewsModal() {
            const modal = document.getElementById('addNewsModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
                
                // Use the resetNewsModal function to properly reset the form
                if (typeof resetNewsModal === 'function') {
                    resetNewsModal();
                } else {
                    // Fallback reset if resetNewsModal is not yet loaded
                    const form = document.getElementById('addNewsForm');
                    if (form) form.reset();
                    
                    const fileStatus = document.getElementById('newsImageStatus');
                    const deleteBtn = document.getElementById('deleteNewsImageBtn');
                    const preview = document.getElementById('newsImagePreview');
                    
                    if (fileStatus) fileStatus.textContent = 'No file selected';
                    if (deleteBtn) deleteBtn.style.display = 'none';
                    if (preview) preview.style.display = 'none';
                    
                    // Clear hidden fields
                    document.getElementById('newsId').value = '';
                    document.getElementById('currentNewsImage').value = '';
                }
            }
        }
        
        // Photo modal functions
        function openPhotoModal() {
            const modal = document.getElementById('photoModal');
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                
                // Add click outside to close
                modal.onclick = function(e) {
                    if (e.target === modal) {
                        closePhotoModal();
                    }
                };
            }
        }
        
        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
                
                // Reset form
                const form = document.getElementById('galleryPhoto');
                if (form) {
                    form.reset();
                }
                
                // Reset file upload
                const fileStatus = document.getElementById('galleryPhotoImageStatus');
                const deleteBtn = document.getElementById('deleteGalleryPhotoImageBtn');
                const preview = document.getElementById('galleryPhotoImagePreview');
                
                if (fileStatus) fileStatus.textContent = 'No file selected';
                if (deleteBtn) deleteBtn.style.display = 'none';
                if (preview) preview.style.display = 'none';
                
                // Reset dropdowns
                const albumSelect = document.getElementById('galleryPhotoAlbum');
                if (albumSelect) albumSelect.selectedIndex = 0;
            }
        }
        
        // Event Modal Functions
        function openEventModal() {
            const modal = document.getElementById('eventModal');
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                
                modal.onclick = function(e) {
                    if (e.target === modal) {
                        closeEventModal();
                    }
                };
            }
        }
        
        function closeEventModal() {
            const modal = document.getElementById('eventModal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
                
                const form = document.getElementById('eventForm');
                if (form) form.reset();
            }
        }
        
        // Sponsorship Modal Functions
        function openSponsorshipModal() {
            const modal = document.getElementById('sponsorshipModal');
            if (modal) {
                // Reset to "Add" mode
                resetSponsorshipModal();
                
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                
                modal.onclick = function(e) {
                    if (e.target === modal) {
                        closeSponsorshipModal();
                    }
                };
            }
        }
        
        function closeSponsorshipModal() {
            const modal = document.getElementById('sponsorshipModal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
                
                resetSponsorshipModal();
            }
        }
        
        function resetSponsorshipModal() {
            // Reset form
            const form = document.getElementById('sponsorshipForm');
            if (form) form.reset();
            
            // Reset hidden fields
            document.getElementById('sponsorshipId').value = '';
            document.getElementById('currentSponsorshipImage').value = '';
            
            // Reset image preview and status
            const preview = document.getElementById('sponsorshipImagePreview');
            const status = document.getElementById('sponsorshipImageStatus');
            const deleteBtn = document.getElementById('deleteSponsorshipImageBtn');
            
            if (preview) preview.style.display = 'none';
            if (status) status.textContent = 'No file selected.';
            if (deleteBtn) deleteBtn.style.display = 'none';
            
            // Reset modal title and button
            const title = document.querySelector('#sponsorshipModal .modal-title');
            const submitBtn = document.getElementById('submitSponsorshipBtn');
            const cancelBtn = document.getElementById('cancelEditBtn');
            
            if (title) title.textContent = 'Add New Sponsorship';
            if (submitBtn) {
                submitBtn.textContent = 'Add Sponsorship';
                submitBtn.name = '';
                submitBtn.value = '';
            }
            if (cancelBtn) cancelBtn.style.display = 'none';
        }
        
        // Video Modal Functions
        function openVideoModal() {
            const modal = document.getElementById('addVideoModal');
            if (modal) {
                resetVideoModal();
                modal.classList.add('show');
                modal.style.display = 'flex';
            }
        }
        
        function closeVideoModal() {
            const modal = document.getElementById('addVideoModal');
            if (modal) {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
        }
        
        function resetVideoModal() {
            // Reset form
            const form = document.getElementById('galleryVideo');
            if (form) form.reset();
            
            // Reset hidden fields
            document.getElementById('galleryVideoId').value = '';
            document.getElementById('currentGalleryVideoImage').value = '';
            
            // Reset video file status
            const videoStatus = document.getElementById('galleryVideoStatus');
            const videoDeleteBtn = document.getElementById('deleteGalleryVideoBtn');
            if (videoStatus) videoStatus.textContent = 'No file selected';
            if (videoDeleteBtn) videoDeleteBtn.style.display = 'none';
            
            // Reset image preview and status
            const preview = document.getElementById('galleryVideoImagePreview');
            const imageStatus = document.getElementById('galleryVideoImageStatus');
            const imageDeleteBtn = document.getElementById('deleteGalleryVideoImageBtn');
            
            if (preview) preview.style.display = 'none';
            if (imageStatus) imageStatus.textContent = 'No file selected';
            if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
            
            // Reset modal title and button
            const title = document.querySelector('#addVideoModal .modal-title');
            const submitBtn = document.getElementById('submitGalleryVideoBtn');
            
            if (title) title.textContent = 'Add New Video';
            if (submitBtn) {
                submitBtn.textContent = 'Add Video';
                submitBtn.className = 'btn-submit';
            }
        }
        
        // Sport Modal Functions
        function openSportModal() {
            const modal = document.getElementById('sportModal');
            if (modal) {
                resetSportModal();
                modal.classList.add('show');
                modal.style.display = 'flex';
            }
        }
        
        function closeSportModal() {
            const modal = document.getElementById('sportModal');
            if (modal) {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
        }
        
        function resetSportModal() {
            // Reset form
            const form = document.getElementById('sportForm');
            if (form) form.reset();
            
            // Reset hidden fields
            document.getElementById('sportId').value = '';
            document.getElementById('currentSportImage').value = '';
            
            // Reset image preview and status
            const preview = document.getElementById('sportImagePreview');
            const imageStatus = document.getElementById('sportImageStatus');
            const imageDeleteBtn = document.getElementById('deleteSportImageBtn');
            
            if (preview) preview.style.display = 'none';
            if (imageStatus) imageStatus.textContent = 'No file selected';
            if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
            
            // Reset modal title and button
            const title = document.querySelector('#sportModal .modal-title');
            const submitBtn = document.getElementById('submitSportBtn');
            
            if (title) title.textContent = 'Add New Sport';
            if (submitBtn) {
                submitBtn.textContent = 'Add Sport';
                submitBtn.className = 'btn-submit';
            }
        }
        
        // State Games Modal Functions
        function openStateGamesModal(mode = 'add') {
            const modal = document.getElementById('stateGamesModal');
            if (modal) {
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                // Only reset form to "Add New" state if we're adding (not editing)
                if (mode === 'add') {
                    resetStateGamesModal();
                }
            }
        }
        
        function closeStateGamesModal() {
            const modal = document.getElementById('stateGamesModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
                resetStateGamesModal();
            }
        }
        
        function resetStateGamesModal() {
            // Reset form
            const form = document.getElementById('stateGamesForm');
            if (form) form.reset();
            
            // Reset hidden fields
            const stateGamesId = document.getElementById('stateGamesId');
            const currentImage = document.getElementById('currentStateGamesImage');
            if (stateGamesId) stateGamesId.value = '';
            if (currentImage) currentImage.value = '';
            
            // Reset image preview and status
            const preview = document.getElementById('stateGamesImagePreview');
            const imageStatus = document.getElementById('stateGamesImageStatus');
            const imageDeleteBtn = document.getElementById('deleteStateGamesImageBtn');
            const previewImg = document.querySelector('#stateGamesImagePreview img');
            
            if (preview) preview.style.display = 'none';
            if (imageStatus) imageStatus.textContent = 'No file selected';
            if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
            
            // Reset modal title and button
            const title = document.querySelector('#stateGamesModal h3');
            const submitBtn = document.getElementById('submitStateGamesBtn');
            const cancelEditBtn = document.getElementById('cancelEditStateGamesBtn');
            
            if (title) title.textContent = 'Add New State Games Event';
            if (submitBtn) {
                submitBtn.textContent = 'Add Event';
                submitBtn.className = 'btn-submit';
            }
            if (cancelEditBtn) cancelEditBtn.style.display = 'none';
        }
        
        // Rich Text Editor Functions for YAP
        function formatText(command) {
            document.execCommand(command, false, null);
            document.getElementById('yapDescriptionEditor').focus();
        }
        
        function createLink() {
            const url = prompt('Enter the URL:');
            if (url) {
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    const range = selection.getRangeAt(0);
                    const selectedText = range.toString();
                    
                    if (selectedText) {
                        document.execCommand('createLink', false, url);
                    } else {
                        const linkText = prompt('Enter link text:');
                        if (linkText) {
                            const link = document.createElement('a');
                            link.href = url;
                            link.textContent = linkText;
                            link.target = '_blank';
                            range.insertNode(link);
                        }
                    }
                }
            }
            document.getElementById('yapDescriptionEditor').focus();
        }
        
        function removeLink() {
            document.execCommand('unlink', false, null);
            document.getElementById('yapDescriptionEditor').focus();
        }
        
        function changeTextColor(color) {
            document.execCommand('foreColor', false, color);
            document.getElementById('yapDescriptionEditor').focus();
        }
        
        function removeFormat() {
            document.execCommand('removeFormat', false, null);
            document.getElementById('yapDescriptionEditor').focus();
        }
        
        // Rich Text Editor Functions for Testimonial
        function formatTestimonialText(command) {
            document.execCommand(command, false, null);
            document.getElementById('yapTestimonialEditor').focus();
        }
        
        function changeTestimonialTextColor(color) {
            document.execCommand('foreColor', false, color);
            document.getElementById('yapTestimonialEditor').focus();
        }
        
        function removeTestimonialFormat() {
            document.execCommand('removeFormat', false, null);
            document.getElementById('yapTestimonialEditor').focus();
        }
        
        // Update hidden textareas when content changes
        function syncEditorContent() {
            const descriptionEditor = document.getElementById('yapDescriptionEditor');
            const descriptionTextarea = document.getElementById('yapDescriptionText');
            const testimonialEditor = document.getElementById('yapTestimonialEditor');
            const testimonialTextarea = document.getElementById('yapTestimonialText');
            
            if (descriptionEditor && descriptionTextarea) {
                descriptionTextarea.value = descriptionEditor.innerHTML;
            }
            
            if (testimonialEditor && testimonialTextarea) {
                testimonialTextarea.value = testimonialEditor.innerHTML;
            }
        }
        
        // YAP Modal Functions
        function openYapModal() {
            const modal = document.getElementById('yapModal');
            if (modal) {
                resetYapModal();
                loadYapContent();
                modal.classList.add('show');
                // Initialize rich text editors after modal is shown
                setTimeout(() => {
                    if (typeof initializeRichTextEditors === 'function') {
                        initializeRichTextEditors();
                    }
                }, 100);
            }
        }
        
        function closeYapModal() {
            const modal = document.getElementById('yapModal');
            if (modal) {
                modal.classList.remove('show');
                resetYapModal();
            }
        }
        
        function resetYapModal() {
            // Reset form
            const form = document.getElementById('yapForm');
            if (form) form.reset();
            
            // Reset hidden fields
            document.getElementById('yapId').value = '';
            
            // Reset rich text editors
            const descriptionEditor = document.getElementById('yapDescriptionEditor');
            const testimonialEditor = document.getElementById('yapTestimonialEditor');
            if (descriptionEditor) descriptionEditor.innerHTML = '';
            if (testimonialEditor) testimonialEditor.innerHTML = '';
            
            // Reset image previews and status
            const heroPreview = document.getElementById('yapHeroImagePreview');
            const heroStatus = document.getElementById('yapHeroImageStatus');
            const heroDeleteBtn = document.getElementById('deleteYapHeroImageBtn');
            
            const resourcesPreview = document.getElementById('yapResourcesImagePreview');
            const resourcesStatus = document.getElementById('yapResourcesImageStatus');
            const resourcesDeleteBtn = document.getElementById('deleteYapResourcesImageBtn');
            
            if (heroPreview) heroPreview.style.display = 'none';
            if (heroStatus) heroStatus.textContent = 'No file selected';
            if (heroDeleteBtn) heroDeleteBtn.style.display = 'none';
            
            if (resourcesPreview) resourcesPreview.style.display = 'none';
            if (resourcesStatus) resourcesStatus.textContent = 'No file selected';
            if (resourcesDeleteBtn) resourcesDeleteBtn.style.display = 'none';
        }
        
        function loadYapContent() {
            fetch('handler/admin_yap_handler.php?action=get_yap_content')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        const yapData = data.data;
                        
                        // Populate form fields
                        document.getElementById('yapId').value = yapData.id || '';
                        document.getElementById('yapHeroTitle').value = yapData.hero_title || '';
                        document.getElementById('yapTestimonialAuthor').value = yapData.testimonial_author || '';
                        document.getElementById('yapTestimonialLocation').value = yapData.testimonial_location || '';
                        document.getElementById('yapResourcesTitle').value = yapData.resources_title || '';
                        document.getElementById('yapResourcesDescription').value = yapData.resources_description || '';
                        document.getElementById('yapResourcesButtonText').value = yapData.resources_button_text || '';
                        document.getElementById('yapResourcesButtonLink').value = yapData.resources_button_link || '';
                        
                        // Populate rich text editors
                        const descriptionEditor = document.getElementById('yapDescriptionEditor');
                        const testimonialEditor = document.getElementById('yapTestimonialEditor');
                        if (descriptionEditor) {
                            descriptionEditor.innerHTML = yapData.description_text || '';
                        }
                        if (testimonialEditor) {
                            testimonialEditor.innerHTML = yapData.testimonial_text || '';
                        }
                        
                        // Update hidden textareas
                        document.getElementById('yapDescriptionText').value = yapData.description_text || '';
                        document.getElementById('yapTestimonialText').value = yapData.testimonial_text || '';
                        
                        // Update preview in main section
                        updateYapPreview(yapData);
                    }
                })
                .catch(error => {
                    console.error('Error loading YAP content:', error);
                    showNotification('Error loading YAP content', 'error');
                });
        }
        
        function submitYapContent() {
            // Sync editor content to hidden textareas before submission
            syncEditorContent();
            
            const form = document.getElementById('yapForm');
            const formData = new FormData(form);
            formData.append('action', 'update_yap_content');
            
            // Show loading state
            const submitBtn = document.getElementById('submitYapBtn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Saving...';
            submitBtn.disabled = true;
            
            fetch('handler/admin_yap_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeYapModal();
                    loadYapPreview(); // Reload the preview
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error saving YAP content:', error);
                showNotification('Error saving YAP content', 'error');
            })
            .finally(() => {
                // Reset button state
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        }
        
        function loadYapPreview() {
            fetch('handler/admin_yap_handler.php?action=get_yap_content')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        updateYapPreview(data.data);
                    }
                })
                .catch(error => {
                    console.error('Error loading YAP preview:', error);
                });
        }
        
        function updateYapPreview(yapData) {
            const previewContainer = document.getElementById('yapContentPreview');
            if (previewContainer) {
                previewContainer.innerHTML = `
                    <div style="margin-bottom: 15px;">
                        <strong>Hero Title:</strong> ${yapData.hero_title || 'Not set'}
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong>Hero Image:</strong> ${yapData.hero_image ? `<img src="${yapData.hero_image}" style="max-width: 200px; margin-left: 10px; border-radius: 4px;">` : 'Default image'}
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong>Description:</strong> ${yapData.description_text ? (yapData.description_text.substring(0, 150) + '...') : 'Not set'}
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong>Testimonial:</strong> ${yapData.testimonial_text ? (yapData.testimonial_text.substring(0, 100) + '...') : 'Not set'}
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong>Resources Title:</strong> ${yapData.resources_title || 'Not set'}
                    </div>
                `;
            }
        }
        
        function removeYapHeroImage() {
            const yapId = document.getElementById('yapId').value;
            if (!yapId) {
                showNotification('Please save the content first before removing images', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'delete_hero_image');
            formData.append('id', yapId);
            
            fetch('handler/admin_yap_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    // Reset image preview and input
                    document.getElementById('yapHeroImage').value = '';
                    document.getElementById('yapHeroImageStatus').textContent = 'No file selected';
                    document.getElementById('yapHeroImagePreview').style.display = 'none';
                    document.getElementById('deleteYapHeroImageBtn').style.display = 'none';
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error removing hero image:', error);
                showNotification('Error removing hero image', 'error');
            });
        }
        
        function removeYapResourcesImage() {
            const yapId = document.getElementById('yapId').value;
            if (!yapId) {
                showNotification('Please save the content first before removing images', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'delete_resources_bg_image');
            formData.append('id', yapId);
            
            fetch('handler/admin_yap_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    // Reset image preview and input
                    document.getElementById('yapResourcesBackgroundImage').value = '';
                    document.getElementById('yapResourcesImageStatus').textContent = 'No file selected';
                    document.getElementById('yapResourcesImagePreview').style.display = 'none';
                    document.getElementById('deleteYapResourcesImageBtn').style.display = 'none';
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error removing resources image:', error);
                showNotification('Error removing resources image', 'error');
            });
        }
        
        // Dashboard Data Loading
        function loadDashboardData() {
            console.log('Loading dashboard data...');
            
            fetch('handler/admin_dashboard_handler.php?action=fetch_all')
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Raw data received:', data);
                    if (data.success) {
                        console.log('Dashboard data loaded successfully');
                        populateDashboard(data);
                    } else {
                        console.error('Failed to load dashboard data:', data.message);
                        showDashboardError();
                    }
                })
                .catch(error => {
                    console.error('Error loading dashboard:', error);
                    showDashboardError();
                });
        }
        
        function populateDashboard(data) {
            console.log('Populating dashboard with data...');
            
            // Participants Stats
            if (data.participants && data.participants.totals) {
                const totals = data.participants.totals;
                console.log('Participants totals:', totals);
                
                const totalParticipantsEl = document.getElementById('totalParticipants');
                console.log('totalParticipants element:', totalParticipantsEl);
                
                if (totalParticipantsEl) {
                    totalParticipantsEl.textContent = totals.total_participants || '0';
                }
                
                const el1 = document.getElementById('totalAthletes');
                if (el1) el1.textContent = totals.athletes_total || '0';
                
                const el2 = document.getElementById('athletesMale');
                if (el2) el2.textContent = totals.athletes_male || '0';
                
                const el3 = document.getElementById('athletesFemale');
                if (el3) el3.textContent = totals.athletes_female || '0';
                
                const el4 = document.getElementById('totalVolunteers');
                if (el4) el4.textContent = totals.volunteers_total || '0';
                
                const el5 = document.getElementById('volunteersMale');
                if (el5) el5.textContent = totals.volunteers_male || '0';
                
                const el6 = document.getElementById('volunteersFemale');
                if (el6) el6.textContent = totals.volunteers_female || '0';
                
                const el7 = document.getElementById('totalCoaches');
                if (el7) el7.textContent = totals.coaches_total || '0';
                
                const el8 = document.getElementById('coachesMale');
                if (el8) el8.textContent = totals.coaches_male || '0';
                
                const el9 = document.getElementById('coachesFemale');
                if (el9) el9.textContent = totals.coaches_female || '0';
                
                console.log('Participants stats populated');
            } else {
                console.error('No participants data found');
            }
            
            // Chapter Breakdown
            if (data.participants && data.participants.by_chapter) {
                const container = document.getElementById('chapterBreakdown');
                container.innerHTML = data.participants.by_chapter.map(chapter => `
                    <div class="chapter-item">
                        <div class="chapter-item-header">
                            <span class="chapter-name">${chapter.chapter_name}</span>
                            <span class="chapter-total">${chapter.total_participants}</span>
                        </div>
                        <div class="chapter-details">
                            Athletes: ${chapter.athletes_total} • Coaches: ${chapter.coaches_total} • Volunteers: ${chapter.volunteers_total}
                        </div>
                    </div>
                `).join('');
            }
            
            // Chapters Stats
            if (data.chapters) {
                document.getElementById('totalChapters').textContent = data.chapters.total || '0';
                document.getElementById('activeChapters').textContent = data.chapters.active || '0';
                document.getElementById('upcomingChapters').textContent = data.chapters.upcoming || '0';
            }
            
            // Events Stats
            if (data.events) {
                document.getElementById('totalEvents').textContent = data.events.total || '0';
                document.getElementById('upcomingEvents').textContent = data.events.upcoming || '0';
                document.getElementById('pastEvents').textContent = data.events.past || '0';
                
                // Next Event
                const nextEventContainer = document.getElementById('nextEvent');
                if (data.events.next_event) {
                    const event = data.events.next_event;
                    const eventDate = new Date(event.event_date);
                    const options = { year: 'numeric', month: 'short', day: 'numeric' };
                    nextEventContainer.innerHTML = `
                        <div class="next-event">
                            <div class="next-event-label">Next Event</div>
                            <div class="next-event-title">${event.title}</div>
                            <div class="next-event-details">
                                <span><i class="fas fa-calendar"></i> ${eventDate.toLocaleDateString('en-US', options)}</span>
                                <span><i class="fas fa-map-marker-alt"></i> ${event.location}</span>
                            </div>
                        </div>
                    `;
                } else {
                    nextEventContainer.innerHTML = `
                        <div class="next-event">
                            <div class="next-event-label">No Upcoming Events</div>
                            <div class="next-event-title">No events scheduled</div>
                        </div>
                    `;
                }
            }
            
            // Media Stats
            if (data.media) {
                document.getElementById('totalPhotos').textContent = data.media.photos.total || '0';
                document.getElementById('photoCollections').textContent = `${data.media.photos.collections || '0'} collections`;
                document.getElementById('recentPhotos').textContent = data.media.photos.recent || '0';
                document.getElementById('totalVideos').textContent = data.media.videos.total || '0';
                document.getElementById('videoCollections').textContent = `${data.media.videos.collections || '0'} collections`;
                document.getElementById('recentVideos').textContent = data.media.videos.recent || '0';
            }
            
            // Content Stats
            if (data.content) {
                document.getElementById('totalNews').textContent = data.content.news || '0';
                document.getElementById('totalSports').textContent = data.content.sports || '0';
                document.getElementById('totalStateGames').textContent = data.content.state_games || '0';
            }
            
            // Sponsors Stats
            if (data.sponsors) {
                document.getElementById('totalSponsors').textContent = data.sponsors.total || '0';
            }
            
            // Recent Activities
            if (data.recent_activities) {
                const container = document.getElementById('recentActivities');
                if (data.recent_activities.length > 0) {
                    container.innerHTML = data.recent_activities.map(activity => {
                        const date = new Date(activity.created_at);
                        const timeAgo = getTimeAgo(date);
                        const iconClass = activity.type === 'news' ? 'news' : 'event';
                        const icon = activity.type === 'news' ? 'fa-newspaper' : 'fa-calendar-alt';
                        
                        return `
                            <div class="activity-item">
                                <div class="activity-icon ${iconClass}">
                                    <i class="fas ${icon}"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">${activity.title}</div>
                                    <div class="activity-type">${activity.type === 'news' ? 'News Article' : 'Event'}</div>
                                </div>
                                <div class="activity-date">${timeAgo}</div>
                            </div>
                        `;
                    }).join('');
                } else {
                    container.innerHTML = `
                        <div class="activity-item">
                            <div class="activity-content" style="text-align: center; width: 100%; color: #94a3b8;">
                                No recent activities
                            </div>
                        </div>
                    `;
                }
            }
        }
        
        function getTimeAgo(date) {
            const seconds = Math.floor((new Date() - date) / 1000);
            const intervals = {
                year: 31536000,
                month: 2592000,
                week: 604800,
                day: 86400,
                hour: 3600,
                minute: 60
            };
            
            for (const [unit, secondsInUnit] of Object.entries(intervals)) {
                const interval = Math.floor(seconds / secondsInUnit);
                if (interval >= 1) {
                    return `${interval} ${unit}${interval > 1 ? 's' : ''} ago`;
                }
            }
            return 'Just now';
        }
        
        function showDashboardError() {
            const statCards = document.querySelectorAll('.stat-value, .mini-stat-value, .media-stat-value, .content-stat-value');
            statCards.forEach(card => {
                if (card.textContent === '-') {
                    card.textContent = 'Error';
                    card.style.color = '#ef4444';
                }
            });
        }
        
        // Analytics Data Loading
        function loadAnalyticsData() {
            console.log('Loading analytics data...');
            
            fetch('handler/admin_dashboard_handler.php?action=fetch_all')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Analytics data loaded:', data);
                        populateAnalytics(data);
                    } else {
                        console.error('Failed to load analytics data:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading analytics:', error);
                });
        }
        
        function populateAnalytics(data) {
            console.log('Populating analytics with data...');
            
            // KPI Calculations
            if (data.participants && data.chapters && data.events && data.media) {
                const totals = data.participants.totals;
                const chapters = data.chapters;
                
                console.log('Analytics - Participants:', totals);
                console.log('Analytics - Chapters:', chapters);
                
                // Avg Participation per Chapter
                const avgParticipation = chapters.total > 0 ? Math.round(totals.total_participants / chapters.total) : 0;
                const el1 = document.getElementById('kpiParticipationRate');
                if (el1) {
                    el1.textContent = avgParticipation;
                    console.log('Set kpiParticipationRate to:', avgParticipation);
                } else {
                    console.error('Element kpiParticipationRate not found');
                }
                
                // Volunteer-to-Athlete Ratio
                const ratio = totals.athletes_total > 0 ? (totals.volunteers_total / totals.athletes_total).toFixed(2) : '0.00';
                const el2 = document.getElementById('kpiVolunteerRatio');
                if (el2) {
                    el2.textContent = `1:${ratio}`;
                    console.log('Set kpiVolunteerRatio to:', `1:${ratio}`);
                } else {
                    console.error('Element kpiVolunteerRatio not found');
                }
                
                // Event Frequency (events per month in 2025)
                const eventsPerMonth = data.events.total > 0 ? (data.events.total / 12).toFixed(1) : '0.0';
                const el3 = document.getElementById('kpiEventFrequency');
                if (el3) {
                    el3.textContent = eventsPerMonth;
                    console.log('Set kpiEventFrequency to:', eventsPerMonth);
                } else {
                    console.error('Element kpiEventFrequency not found');
                }
                
                // Media Growth This Month
                const mediaThisMonth = (data.media.photos.recent || 0) + (data.media.videos.recent || 0);
                const el4 = document.getElementById('kpiMediaGrowth');
                if (el4) {
                    el4.textContent = mediaThisMonth;
                    console.log('Set kpiMediaGrowth to:', mediaThisMonth);
                } else {
                    console.error('Element kpiMediaGrowth not found');
                }
            } else {
                console.error('Missing data for KPI calculations');
            }
            
            // Gender Distribution
            if (data.participants && data.participants.totals) {
                const totals = data.participants.totals;
                
                // Athletes
                const athletesTotal = totals.athletes_total || 1;
                const athletesMalePercent = Math.round((totals.athletes_male / athletesTotal) * 100);
                const athletesFemalePercent = 100 - athletesMalePercent;
                document.getElementById('athletesMaleBar').style.width = athletesMalePercent + '%';
                document.getElementById('athletesFemaleBar').style.width = athletesFemalePercent + '%';
                document.getElementById('athletesMalePercent').textContent = athletesMalePercent + '%';
                document.getElementById('athletesFemalePercent').textContent = athletesFemalePercent + '%';
                
                // Coaches
                const coachesTotal = totals.coaches_total || 1;
                const coachesMalePercent = Math.round((totals.coaches_male / coachesTotal) * 100);
                const coachesFemalePercent = 100 - coachesMalePercent;
                document.getElementById('coachesMaleBar').style.width = coachesMalePercent + '%';
                document.getElementById('coachesFemaleBar').style.width = coachesFemalePercent + '%';
                document.getElementById('coachesMalePercent').textContent = coachesMalePercent + '%';
                document.getElementById('coachesFemalePercent').textContent = coachesFemalePercent + '%';
                
                // Volunteers
                const volunteersTotal = totals.volunteers_total || 1;
                const volunteersMalePercent = Math.round((totals.volunteers_male / volunteersTotal) * 100);
                const volunteersFemalePercent = 100 - volunteersMalePercent;
                document.getElementById('volunteersMaleBar').style.width = volunteersMalePercent + '%';
                document.getElementById('volunteersFemaleBar').style.width = volunteersFemalePercent + '%';
                document.getElementById('volunteersMalePercent').textContent = volunteersMalePercent + '%';
                document.getElementById('volunteersFemalePercent').textContent = volunteersFemalePercent + '%';
            }
            
            // Chapter Comparison
            if (data.participants && data.participants.by_chapter) {
                const chapters = data.participants.by_chapter;
                const maxParticipants = Math.max(...chapters.map(c => c.total_participants));
                const container = document.getElementById('chapterComparison');
                
                container.innerHTML = chapters.map(chapter => {
                    const percentage = maxParticipants > 0 ? (chapter.total_participants / maxParticipants) * 100 : 0;
                    return `
                        <div class="chapter-comparison-item">
                            <div class="chapter-comparison-header">
                                <span class="chapter-comparison-name">${chapter.city}</span>
                                <span class="chapter-comparison-total">${chapter.total_participants}</span>
                            </div>
                            <div class="chapter-comparison-bar">
                                <div class="chapter-comparison-fill" style="width: ${percentage}%"></div>
                            </div>
                            <div class="chapter-comparison-details">
                                A: ${chapter.athletes_total} • C: ${chapter.coaches_total} • V: ${chapter.volunteers_total}
                            </div>
                        </div>
                    `;
                }).join('');
            }
            
            // Event Type Distribution
            if (data.events && data.events.by_type) {
                const eventTypes = data.events.by_type;
                const totalEvents = Object.values(eventTypes).reduce((a, b) => a + b, 0);
                const container = document.getElementById('eventTypeChart');
                const colors = {
                    special: 'linear-gradient(90deg, #667eea 0%, #764ba2 100%)',
                    training: 'linear-gradient(90deg, #f093fb 0%, #f5576c 100%)',
                    meeting: 'linear-gradient(90deg, #4facfe 0%, #00f2fe 100%)',
                    competition: 'linear-gradient(90deg, #fa709a 0%, #fee140 100%)'
                };
                
                container.innerHTML = Object.entries(eventTypes).map(([type, count]) => {
                    const percentage = totalEvents > 0 ? (count / totalEvents) * 100 : 0;
                    return `
                        <div class="event-type-item">
                            <div class="event-type-icon" style="background: ${colors[type] || colors.special};">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="event-type-content">
                                <div class="event-type-name">${type}</div>
                                <div class="event-type-bar">
                                    <div class="event-type-fill" style="width: ${percentage}%; background: ${colors[type] || colors.special};"></div>
                                </div>
                            </div>
                            <div class="event-type-count">${count}</div>
                        </div>
                    `;
                }).join('');
            }
            
            // Media Growth
            if (data.media) {
                document.getElementById('photoCollectionsCount').textContent = data.media.photos.collections || '0';
                document.getElementById('totalPhotosCount').textContent = data.media.photos.total || '0';
                document.getElementById('videoCollectionsCount').textContent = data.media.videos.collections || '0';
                document.getElementById('totalVideosCount').textContent = data.media.videos.total || '0';
                
                const totalMedia = data.media.total_media || 1;
                const photosPercent = (data.media.photos.total / totalMedia) * 100;
                const videosPercent = (data.media.videos.total / totalMedia) * 100;
                document.getElementById('photosProgress').style.width = photosPercent + '%';
                document.getElementById('videosProgress').style.width = videosPercent + '%';
            }
            
            // Leaderboard
            if (data.participants && data.participants.by_chapter) {
                const sorted = [...data.participants.by_chapter].sort((a, b) => b.total_participants - a.total_participants);
                const container = document.getElementById('chapterLeaderboard');
                
                container.innerHTML = sorted.map((chapter, index) => {
                    const rankClass = index === 0 ? 'gold' : index === 1 ? 'silver' : index === 2 ? 'bronze' : 'other';
                    const medal = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : (index + 1);
                    
                    return `
                        <div class="leaderboard-item">
                            <div class="leaderboard-rank ${rankClass}">${medal}</div>
                            <div class="leaderboard-content">
                                <div class="leaderboard-name">${chapter.chapter_name}</div>
                                <div class="leaderboard-details">
                                    ${chapter.athletes_total} Athletes • ${chapter.coaches_total} Coaches • ${chapter.volunteers_total} Volunteers
                                </div>
                            </div>
                            <div class="leaderboard-score">${chapter.total_participants}</div>
                        </div>
                    `;
                }).join('');
            }
            
            // Content Activity
            if (data.content) {
                document.getElementById('newsArticlesCount').textContent = data.content.news || '0';
                document.getElementById('sportsCount').textContent = data.content.sports || '0';
                document.getElementById('stateGamesCount').textContent = data.content.state_games || '0';
            }
            
            if (data.sponsors) {
                document.getElementById('sponsorsCount').textContent = data.sponsors.total || '0';
            }
            
            if (data.content && data.content.recent_news !== undefined) {
                const recentInfo = data.content.recent_news > 0 
                    ? `${data.content.recent_news} news article${data.content.recent_news > 1 ? 's' : ''} published in the last 30 days`
                    : 'No new articles in the last 30 days';
                document.getElementById('recentContentInfo').textContent = recentInfo;
            }
            
            // Generate Insights
            generateInsights(data);
        }
        
        function generateInsights(data) {
            const insights = [];
            
            if (data.participants && data.participants.totals) {
                const totals = data.participants.totals;
                const ratio = totals.athletes_total > 0 ? totals.volunteers_total / totals.athletes_total : 0;
                
                // Volunteer ratio insight
                if (ratio >= 0.4) {
                    insights.push({
                        type: 'positive',
                        icon: 'fa-check-circle',
                        title: 'Excellent Volunteer Support',
                        description: `You have a strong volunteer-to-athlete ratio (1:${ratio.toFixed(2)}), ensuring good support for all programs.`
                    });
                } else if (ratio < 0.3) {
                    insights.push({
                        type: 'warning',
                        icon: 'fa-exclamation-triangle',
                        title: 'Volunteer Recruitment Needed',
                        description: `Consider recruiting more volunteers. Current ratio is 1:${ratio.toFixed(2)}, aim for 1:0.4 or better.`
                    });
                }
                
                // Gender balance insight
                const athleteGenderGap = Math.abs(totals.athletes_male - totals.athletes_female);
                const genderBalancePercent = (athleteGenderGap / totals.athletes_total) * 100;
                
                if (genderBalancePercent < 20) {
                    insights.push({
                        type: 'positive',
                        icon: 'fa-balance-scale',
                        title: 'Balanced Athlete Participation',
                        description: 'Your athlete gender distribution is well balanced, promoting inclusive participation.'
                    });
                }
            }
            
            if (data.chapters) {
                if (data.chapters.upcoming > 0) {
                    insights.push({
                        type: 'info',
                        icon: 'fa-map-marker-alt',
                        title: 'Chapter Expansion',
                        description: `${data.chapters.upcoming} chapter${data.chapters.upcoming > 1 ? 's are' : ' is'} in development. Focus on building strong foundations.`
                    });
                }
            }
            
            if (data.events) {
                if (data.events.upcoming >= 3) {
                    insights.push({
                        type: 'positive',
                        icon: 'fa-calendar-check',
                        title: 'Active Event Schedule',
                        description: `${data.events.upcoming} upcoming events scheduled. Great engagement momentum!`
                    });
                } else if (data.events.upcoming === 0) {
                    insights.push({
                        type: 'warning',
                        icon: 'fa-calendar-times',
                        title: 'Plan More Events',
                        description: 'No upcoming events scheduled. Consider planning activities to keep participants engaged.'
                    });
                }
            }
            
            if (data.media) {
                const recentMedia = (data.media.photos.recent || 0) + (data.media.videos.recent || 0);
                if (recentMedia >= 10) {
                    insights.push({
                        type: 'positive',
                        icon: 'fa-camera',
                        title: 'Great Media Documentation',
                        description: `${recentMedia} new media items this month. Excellent documentation of activities!`
                    });
                }
            }
            
            if (data.content && data.content.recent_news > 0) {
                insights.push({
                    type: 'positive',
                    icon: 'fa-newspaper',
                    title: 'Active Communication',
                    description: `${data.content.recent_news} news update${data.content.recent_news > 1 ? 's' : ''} published recently. Keep stakeholders informed!`
                });
            }
            
            // Render insights
            const container = document.getElementById('insightsGrid');
            if (insights.length > 0) {
                container.innerHTML = insights.map(insight => `
                    <div class="insight-card ${insight.type}">
                        <div class="insight-icon">
                            <i class="fas ${insight.icon}"></i>
                        </div>
                        <div class="insight-title">${insight.title}</div>
                        <p class="insight-description">${insight.description}</p>
                    </div>
                `).join('');
            } else {
                container.innerHTML = `
                    <div class="insight-card info">
                        <div class="insight-icon"><i class="fas fa-info-circle"></i></div>
                        <div class="insight-title">System Running Smoothly</div>
                        <p class="insight-description">All metrics look good. Keep up the great work!</p>
                    </div>
                `;
            }
        }
        
        // Cancel Edit button functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Load dashboard data when page loads
            loadDashboardData();
            
            // Setup navigation click handlers
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sectionId = this.getAttribute('data-section');
                    if (sectionId) {
                        navigateToSection(sectionId);
                    }
                });
            });
            
            const cancelBtn = document.getElementById('cancelEditBtn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    closeSponsorshipModal();
                });
            }
            
            // Sponsorship image preview
            const sponsorshipImageInput = document.getElementById('sponsorshipImage');
            if (sponsorshipImageInput) {
                sponsorshipImageInput.addEventListener('change', function() {
                    const statusSpan = document.getElementById('sponsorshipImageStatus');
                    const preview = document.getElementById('sponsorshipImagePreview');
                    const deleteBtn = document.getElementById('deleteSponsorshipImageBtn');
                    
                    if (this.files && this.files[0]) {
                        statusSpan.textContent = this.files[0].name;
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(this.files[0]);
                        if (deleteBtn) deleteBtn.style.display = 'inline-block';
                    } else {
                        // Check if we're in edit mode
                        const currentImage = document.getElementById('currentSponsorshipImage').value;
                        if (currentImage) {
                            statusSpan.textContent = 'Current image loaded. Select new image to change.';
                            preview.src = currentImage;
                            preview.style.display = 'block';
                            if (deleteBtn) deleteBtn.style.display = 'inline-block';
                        } else {
                            statusSpan.textContent = 'No file selected.';
                            preview.style.display = 'none';
                            if (deleteBtn) deleteBtn.style.display = 'none';
                        }
                    }
                });
            }
            
            // Delete sponsorship image button
            const deleteSponsorshipImageBtn = document.getElementById('deleteSponsorshipImageBtn');
            if (deleteSponsorshipImageBtn) {
                deleteSponsorshipImageBtn.addEventListener('click', function() {
                    const imageInput = document.getElementById('sponsorshipImage');
                    const preview = document.getElementById('sponsorshipImagePreview');
                    const statusSpan = document.getElementById('sponsorshipImageStatus');
                    const currentImage = document.getElementById('currentSponsorshipImage');
                    
                    imageInput.value = '';
                    preview.src = '';
                    preview.style.display = 'none';
                    
                    // If in edit mode, clear current image reference
                    if (currentImage.value) {
                        currentImage.value = '';
                        statusSpan.textContent = 'Image removed. Select new image to add.';
                    } else {
                        statusSpan.textContent = 'No file selected.';
                    }
                    
                    deleteSponsorshipImageBtn.style.display = 'none';
                });
            }
            
            // YAP Hero Image Preview
            const yapHeroImageInput = document.getElementById('yapHeroImage');
            if (yapHeroImageInput) {
                yapHeroImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const preview = document.getElementById('yapHeroImagePreview');
                    const status = document.getElementById('yapHeroImageStatus');
                    const deleteBtn = document.getElementById('deleteYapHeroImageBtn');
                    const previewImg = preview.querySelector('img');
                    
                    if (file) {
                        status.textContent = file.name;
                        deleteBtn.style.display = 'inline-block';
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        status.textContent = 'No file selected';
                        deleteBtn.style.display = 'none';
                        preview.style.display = 'none';
                    }
                });
            }
            
            // YAP Resources Background Image Preview
            const yapResourcesImageInput = document.getElementById('yapResourcesBackgroundImage');
            if (yapResourcesImageInput) {
                yapResourcesImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const preview = document.getElementById('yapResourcesImagePreview');
                    const status = document.getElementById('yapResourcesImageStatus');
                    const deleteBtn = document.getElementById('deleteYapResourcesImageBtn');
                    const previewImg = preview.querySelector('img');
                    
                    if (file) {
                        status.textContent = file.name;
                        deleteBtn.style.display = 'inline-block';
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        status.textContent = 'No file selected';
                        deleteBtn.style.display = 'none';
                        preview.style.display = 'none';
                    }
                });
            }
            
            // Rich Text Editor Event Listeners for auto-sync
            const descriptionEditor = document.getElementById('yapDescriptionEditor');
            if (descriptionEditor) {
                descriptionEditor.addEventListener('input', syncEditorContent);
                descriptionEditor.addEventListener('paste', function() {
                    setTimeout(syncEditorContent, 10); // Small delay to ensure paste content is processed
                });
            }
            
            const testimonialEditor = document.getElementById('yapTestimonialEditor');
            if (testimonialEditor) {
                testimonialEditor.addEventListener('input', syncEditorContent);
                testimonialEditor.addEventListener('paste', function() {
                    setTimeout(syncEditorContent, 10);
                });
            }
        });
        
        function handleFileSelect(input) {
            const fileStatus = document.getElementById('newsImageStatus');
            const deleteBtn = document.getElementById('deleteNewsImageBtn');
            const preview = document.getElementById('newsImagePreview');
            const previewImg = document.querySelector('#newsImagePreview img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Update status
                if (fileStatus) fileStatus.textContent = file.name;
                if (deleteBtn) deleteBtn.style.display = 'inline-block';
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        if (preview) preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeSelectedFile() {
            const fileInput = document.getElementById('newsImage');
            const fileStatus = document.getElementById('newsImageStatus');
            const deleteBtn = document.getElementById('deleteNewsImageBtn');
            const preview = document.getElementById('newsImagePreview');
            const previewImg = document.querySelector('#newsImagePreview img');
            
            if (fileInput) fileInput.value = '';
            if (fileStatus) fileStatus.textContent = 'No file selected';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
            if (preview) preview.style.display = 'none';
        }
        
        // State Games Modal File Handling Functions
        function handleStateGamesFileSelect(input) {
            const fileStatus = document.getElementById('stateGamesImageStatus');
            const deleteBtn = document.getElementById('deleteStateGamesImageBtn');
            const preview = document.getElementById('stateGamesImagePreview');
            const previewImg = document.querySelector('#stateGamesImagePreview img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Update status
                if (fileStatus) fileStatus.textContent = file.name;
                if (deleteBtn) deleteBtn.style.display = 'inline-block';
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        if (preview) preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeStateGamesSelectedFile() {
            const fileInput = document.getElementById('stateGamesImage');
            const fileStatus = document.getElementById('stateGamesImageStatus');
            const deleteBtn = document.getElementById('deleteStateGamesImageBtn');
            const preview = document.getElementById('stateGamesImagePreview');
            const previewImg = document.querySelector('#stateGamesImagePreview img');
            
            if (fileInput) fileInput.value = '';
            if (fileStatus) fileStatus.textContent = 'No file selected';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
            if (preview) preview.style.display = 'none';
        }
        
        // TBA Date Helper Function
        function setTBADate(year = '2025') {
            const eventDateInput = document.getElementById('stateGameEventDate');
            if (eventDateInput) {
                eventDateInput.value = `TBA ${year}`;
                eventDateInput.focus();
            }
        }

        // SONG 26 Modal Functions
        function openSong26Modal(mode = 'add') {
            const modal = document.getElementById('song26Modal');
            if (modal) {
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                if (mode === 'add') {
                    resetSong26Modal();
                }
            }
        }
        
        function closeSong26Modal() {
            const modal = document.getElementById('song26Modal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
                resetSong26Modal();
            }
        }
        
        function resetSong26Modal() {
            const form = document.getElementById('song26Form');
            if (form) form.reset();
            
            const song26Id = document.getElementById('song26Id');
            const currentImage = document.getElementById('currentSong26Image');
            if (song26Id) song26Id.value = '';
            if (currentImage) currentImage.value = '';
            
            removeSong26SelectedFile();
            
            const submitBtn = document.getElementById('submitSong26Btn');
            const cancelEditBtn = document.getElementById('cancelEditSong26Btn');
            if (submitBtn) submitBtn.textContent = 'Add Event';
            if (submitBtn) submitBtn.classList.remove('edit-mode');
            if (cancelEditBtn) cancelEditBtn.style.display = 'none';
        }
        
        function handleSong26FileSelect(input) {
            const fileStatus = document.getElementById('song26ImageStatus');
            const deleteBtn = document.getElementById('deleteSong26ImageBtn');
            const preview = document.getElementById('song26ImagePreview');
            const previewImg = document.querySelector('#song26ImagePreview img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                if (fileStatus) fileStatus.textContent = file.name;
                if (deleteBtn) deleteBtn.style.display = 'inline-block';
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        if (preview) preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeSong26SelectedFile() {
            const fileInput = document.getElementById('song26Image');
            const fileStatus = document.getElementById('song26ImageStatus');
            const deleteBtn = document.getElementById('deleteSong26ImageBtn');
            const preview = document.getElementById('song26ImagePreview');
            const previewImg = document.querySelector('#song26ImagePreview img');
            
            if (fileInput) fileInput.value = '';
            if (fileStatus) fileStatus.textContent = 'No file selected';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
            if (preview) preview.style.display = 'none';
        }
        
        function setSong26TBADate(year = '2026') {
            const eventDateInput = document.getElementById('song26EventDate');
            if (eventDateInput) {
                eventDateInput.value = `TBA ${year}`;
                eventDateInput.focus();
            }
        }
        
        // HAP Modal Functions
        function openHapModal() {
            const modal = document.getElementById('hapModal');
            if (modal) {
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                resetHapModal();
            }
        }
        
        function closeHapModal() {
            const modal = document.getElementById('hapModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
                resetHapModal();
            }
        }
        
        function resetHapModal() {
            // Reset form
            const form = document.getElementById('hapForm');
            if (form) form.reset();
            
            // Reset hidden fields
            const hapId = document.getElementById('hapId');
            const currentImage = document.getElementById('currentHapImage');
            if (hapId) hapId.value = '';
            if (currentImage) currentImage.value = '';
            
            // Reset image preview and status
            const preview = document.getElementById('hapImagePreview');
            const imageStatus = document.getElementById('hapImageStatus');
            const imageDeleteBtn = document.getElementById('deleteHapImageBtn');
            const previewImg = document.querySelector('#hapImagePreview img');
            
            if (preview) preview.style.display = 'none';
            if (imageStatus) imageStatus.textContent = 'No file selected';
            if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
        }
        
        // HAP Edit Modal Functions - defined in admin panel for direct access
        function openHapEditModal() {
            const modal = document.getElementById('hapEditModal');
            if (modal) {
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeHapEditModal() {
            const modal = document.getElementById('hapEditModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
                resetHapEditModal();
            }
        }
        
        function resetHapEditModal() {
            // Reset edit form
            const form = document.getElementById('hapEditForm');
            if (form) form.reset();
            
            // Reset hidden fields
            const hapId = document.getElementById('editHapId');
            const currentImage = document.getElementById('currentEditHapImage');
            if (hapId) hapId.value = '';
            if (currentImage) currentImage.value = '';
            
            // Reset image preview and status
            const preview = document.getElementById('editHapImagePreview');
            const imageStatus = document.getElementById('editHapImageStatus');
            const imageDeleteBtn = document.getElementById('deleteEditHapImageBtn');
            const previewImg = document.querySelector('#editHapImagePreview img');
            
            if (preview) preview.style.display = 'none';
            if (imageStatus) imageStatus.textContent = 'Current image loaded';
            if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
        }
        
        // Edit HAP File Handling Functions
        function handleEditHapFileSelect(input) {
            const fileStatus = document.getElementById('editHapImageStatus');
            const deleteBtn = document.getElementById('deleteEditHapImageBtn');
            const preview = document.getElementById('editHapImagePreview');
            const previewImg = document.querySelector('#editHapImagePreview img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Update status
                if (fileStatus) fileStatus.textContent = file.name;
                if (deleteBtn) deleteBtn.style.display = 'inline-block';
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        if (preview) preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeEditHapSelectedFile() {
            const fileInput = document.getElementById('editHapImage');
            const fileStatus = document.getElementById('editHapImageStatus');
            const deleteBtn = document.getElementById('deleteEditHapImageBtn');
            const preview = document.getElementById('editHapImagePreview');
            const previewImg = document.querySelector('#editHapImagePreview img');
            
            if (fileInput) fileInput.value = '';
            if (fileStatus) fileStatus.textContent = 'Current image loaded';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
            if (preview) preview.style.display = 'none';
        }
        
        // ALP Modal Functions
        function openAlpModal() {
            const modal = document.getElementById('alpModal');
            if (modal) {
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                resetAlpModal();
            }
        }
        
        function closeAlpModal() {
            const modal = document.getElementById('alpModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
                resetAlpModal();
            }
        }
        
        function resetAlpModal() {
            // Reset form
            const form = document.getElementById('alpForm');
            if (form) form.reset();
            
            // Reset image preview and status
            const preview = document.getElementById('alpImagePreview');
            const imageStatus = document.getElementById('alpImageStatus');
            const imageDeleteBtn = document.getElementById('deleteAlpImageBtn');
            const previewImg = document.querySelector('#alpImagePreview img');
            
            if (preview) preview.style.display = 'none';
            if (imageStatus) imageStatus.textContent = 'No file selected';
            if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
        }
        
        // ALP Edit Modal Functions
        function openAlpEditModal() {
            const modal = document.getElementById('alpEditModal');
            if (modal) {
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeAlpEditModal() {
            const modal = document.getElementById('alpEditModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
                resetAlpEditModal();
            }
        }
        
        function resetAlpEditModal() {
            // Reset edit form
            const form = document.getElementById('alpEditForm');
            if (form) form.reset();
            
            // Reset hidden fields
            const alpId = document.getElementById('editAlpId');
            const currentImage = document.getElementById('currentEditAlpImage');
            if (alpId) alpId.value = '';
            if (currentImage) currentImage.value = '';
            
            // Reset image preview and status
            const preview = document.getElementById('editAlpImagePreview');
            const imageStatus = document.getElementById('editAlpImageStatus');
            const imageDeleteBtn = document.getElementById('deleteEditAlpImageBtn');
            const previewImg = document.querySelector('#editAlpImagePreview img');
            
            if (preview) preview.style.display = 'none';
            if (imageStatus) imageStatus.textContent = 'Current image loaded';
            if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
        }
        
        // ALP File Handling Functions
        function handleAlpFileSelect(input) {
            const fileStatus = document.getElementById('alpImageStatus');
            const deleteBtn = document.getElementById('deleteAlpImageBtn');
            const preview = document.getElementById('alpImagePreview');
            const previewImg = document.querySelector('#alpImagePreview img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Update status
                if (fileStatus) fileStatus.textContent = file.name;
                if (deleteBtn) deleteBtn.style.display = 'inline-block';
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        if (preview) preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeAlpSelectedFile() {
            const fileInput = document.getElementById('alpImage');
            const fileStatus = document.getElementById('alpImageStatus');
            const deleteBtn = document.getElementById('deleteAlpImageBtn');
            const preview = document.getElementById('alpImagePreview');
            const previewImg = document.querySelector('#alpImagePreview img');
            
            if (fileInput) fileInput.value = '';
            if (fileStatus) fileStatus.textContent = 'No file selected';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
            if (preview) preview.style.display = 'none';
        }
        
        // Edit ALP File Handling Functions
        function handleEditAlpFileSelect(input) {
            const fileStatus = document.getElementById('editAlpImageStatus');
            const deleteBtn = document.getElementById('deleteEditAlpImageBtn');
            const preview = document.getElementById('editAlpImagePreview');
            const previewImg = document.querySelector('#editAlpImagePreview img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Update status
                if (fileStatus) fileStatus.textContent = file.name;
                if (deleteBtn) deleteBtn.style.display = 'inline-block';
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        if (preview) preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeEditAlpSelectedFile() {
            const fileInput = document.getElementById('editAlpImage');
            const fileStatus = document.getElementById('editAlpImageStatus');
            const deleteBtn = document.getElementById('deleteEditAlpImageBtn');
            const preview = document.getElementById('editAlpImagePreview');
            const previewImg = document.querySelector('#editAlpImagePreview img');
            
            if (fileInput) fileInput.value = '';
            if (fileStatus) fileStatus.textContent = 'Current image loaded';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
            if (preview) preview.style.display = 'none';
        }
        
        // HAP File Handling Functions
        function handleHapFileSelect(input) {
            const fileStatus = document.getElementById('hapImageStatus');
            const deleteBtn = document.getElementById('deleteHapImageBtn');
            const preview = document.getElementById('hapImagePreview');
            const previewImg = document.querySelector('#hapImagePreview img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Update status
                if (fileStatus) fileStatus.textContent = file.name;
                if (deleteBtn) deleteBtn.style.display = 'inline-block';
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        if (preview) preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeHapSelectedFile() {
            const fileInput = document.getElementById('hapImage');
            const fileStatus = document.getElementById('hapImageStatus');
            const deleteBtn = document.getElementById('deleteHapImageBtn');
            const preview = document.getElementById('hapImagePreview');
            const previewImg = document.querySelector('#hapImagePreview img');
            
            if (fileInput) fileInput.value = '';
            if (fileStatus) fileStatus.textContent = 'No file selected';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (previewImg) previewImg.src = '';
            if (preview) preview.style.display = 'none';
        }
        
        // Initialize when DOM loads
        document.addEventListener('DOMContentLoaded', function() {
            // Load YAP preview on page load
            loadYapPreview();
            
            const addNewsBtn = document.getElementById('addNewsBtn');
            if (addNewsBtn) {
                addNewsBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openNewsModal();
                });
            }
            
            const addVideoBtn = document.getElementById('addVideoBtn');
            if (addVideoBtn) {
                addVideoBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openVideoModal();
                });
            }
            
            const addSportBtn = document.getElementById('addSportBtn');
            if (addSportBtn) {
                addSportBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openSportModal();
                });
            }
            
            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeNewsModal();
                    closeUserDropdown();
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.user-profile')) {
                    closeUserDropdown();
                }
            });
        });
        
        // User dropdown functions
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            const profile = document.querySelector('.user-profile');
            
            if (dropdown.classList.contains('show')) {
                closeUserDropdown();
            } else {
                dropdown.classList.add('show');
                profile.classList.add('active');
            }
        }
        
        function closeUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            const profile = document.querySelector('.user-profile');
            
            if (dropdown) {
                dropdown.classList.remove('show');
            }
            if (profile) {
                profile.classList.remove('active');
            }
        }
        
        function navigateToSection(sectionId) {
            // Remove active class from all nav items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Hide all content sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show the target section
            const targetSection = document.getElementById(sectionId);
            const navItem = document.querySelector(`[data-section="${sectionId}"]`);
            
            if (targetSection) {
                targetSection.classList.add('active');
            }
            if (navItem) {
                navItem.classList.add('active');
            }
            
            // Update page title
            const pageTitle = document.querySelector('.page-title');
            if (pageTitle) {
                const sectionTitle = targetSection?.querySelector('.section-title')?.textContent || 
                                  navItem?.querySelector('span')?.textContent || 'Dashboard';
                pageTitle.textContent = sectionTitle;
            }
            
            // Load profile data when navigating to profile section
            if (sectionId === 'profile') {
                console.log('Navigating to profile section, loading data...');
                setTimeout(() => {
                    if (typeof loadProfileData === 'function') {
                        loadProfileData();
                    }
                }, 100);
            }
            
            // Load analytics data when navigating to analytics section
            if (sectionId === 'analytics') {
                console.log('Navigating to analytics section, loading data...');
                setTimeout(() => {
                    if (typeof loadAnalyticsData === 'function') {
                        loadAnalyticsData();
                    }
                }, 100);
            }
            
            // Load analytics data when navigating to analytics section
            if (sectionId === 'analytics') {
                console.log('Navigating to analytics section, loading data...');
                setTimeout(() => {
                    if (typeof loadAnalyticsData === 'function') {
                        loadAnalyticsData();
                    }
                }, 100);
            }
            
            closeUserDropdown();
        }
        
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                // Clear all sessions and redirect
                fetch('logout.php', { 
                    method: 'POST',
                    credentials: 'same-origin'
                }).then(() => {
                    // Force clear any cached data
                    sessionStorage.clear();
                    localStorage.clear();
                    // Redirect to login
                    window.location.replace('login_page_v1.php');
                }).catch(() => {
                    // Even if fetch fails, still logout
                    window.location.replace('login_page_v1.php');
                });
            }
        }
        
    </script>
    

    <script src="../scripts/admin-components/sponsorship-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/photo-management.js"></script>
    <script src="../scripts/admin-components/video-management.js"></script>
    <script src="../scripts/admin-components/sports-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/state-games-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/hap-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/alp-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/yap-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/chapters-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/other-so-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script>
        // Force load chapters when needed
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Setting up chapters loading...');
            
            // Try loading chapters when Sarawak Chapters nav is clicked
            const sarawakNav = document.querySelector('[data-section="sarawak-chapters"]');
            if (sarawakNav) {
                sarawakNav.addEventListener('click', function() {
                    setTimeout(function() {
                        window.loadChapters();
                    }, 200);
                });
            }
        });
        
        // REMOVED forceLoadChapters - using chapters-management.js instead
    </script>

    <!-- Direct sortable implementation -->
    <script>
        // Standardized Global Notification System
        function showNotification(message, type = 'success') {
            // Create notification container if it doesn't exist
            let container = document.querySelector('.notification-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'notification-container';
                document.body.appendChild(container);
            }

            // Create notification toast
            const notification = document.createElement('div');
            notification.className = `notification-toast ${type}`;
            
            // Icon mapping
            const icons = {
                success: '<i class="fas fa-check-circle"></i>',
                error: '<i class="fas fa-times-circle"></i>',
                warning: '<i class="fas fa-exclamation-triangle"></i>',
                info: '<i class="fas fa-info-circle"></i>'
            };
            
            notification.innerHTML = `
                <span class="notification-icon">${icons[type] || icons.success}</span>
                <span class="notification-message">${message}</span>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Add to container
            container.appendChild(notification);
            
            // Auto-remove after 3 seconds with fade animation
            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                    // Remove container if empty
                    if (container.children.length === 0) {
                        container.remove();
                    }
                }, 300);
            }, 3000);
        }

        // Gallery Collections Sortable
        window.initializeGallerySortable = function() {
            const container = document.getElementById('publishedGalleryPhoto');
            
            if (!container || typeof Sortable === 'undefined') return;

            // Destroy any existing sortable first
            if (container.gallerySortableInstance) {
                container.gallerySortableInstance.destroy();
            }

            const sortable = Sortable.create(container, {
                animation: 150,
                ghostClass: 'gallery-sortable-ghost',
                chosenClass: 'gallery-sortable-chosen',
                dragClass: 'gallery-sortable-drag',
                handle: '.gallery-admin-info',
                onEnd: function(evt) {
                    const newOrder = Array.from(container.children).map((item, index) => ({
                        collection_id: item.dataset.collectionId,
                        sort_order: index + 1
                    }));
                    
                    // Save to backend
                    const formData = new FormData();
                    formData.append('action', 'update_gallery_order');
                    formData.append('order_data', JSON.stringify(newOrder));

                    fetch('handler/admin_gallery_photo_handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Gallery order updated successfully', 'success');
                        } else {
                            showNotification('Failed to update gallery order', 'error');
                        }
                    })
                    .catch(() => {
                        showNotification('Error updating gallery order', 'error');
                    });
                }
            });
            
            container.gallerySortableInstance = sortable;
        };

        window.initializePhotoCardsSortable = function() {
            const galleryGrids = document.querySelectorAll('.gallery-admin-grid');
            
            galleryGrids.forEach(grid => {
                const categoryContainer = grid.closest('.gallery-admin-category');
                if (!categoryContainer) return;
                
                const collectionId = categoryContainer.dataset.collectionId;
                if (!collectionId || typeof Sortable === 'undefined') return;

                // Destroy any existing sortable first
                if (grid.photoSortableInstance) {
                    grid.photoSortableInstance.destroy();
                }

                const sortable = Sortable.create(grid, {
                    animation: 150,
                    ghostClass: 'photo-card-sortable-ghost',
                    chosenClass: 'photo-card-sortable-chosen',
                    dragClass: 'photo-card-sortable-drag',
                    onEnd: function(evt) {
                        const newOrder = Array.from(grid.children).map((card, index) => ({
                            photo_id: card.dataset.photoId,
                            sort_order: index + 1
                        }));
                        
                        // Save to backend
                        const formData = new FormData();
                        formData.append('action', 'update_photo_order');
                        formData.append('collection_id', collectionId);
                        formData.append('order_data', JSON.stringify(newOrder));

                        fetch('handler/admin_gallery_photo_handler.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification('Photo order updated successfully', 'success');
                            } else {
                                showNotification('Failed to update photo order', 'error');
                            }
                        })
                        .catch(() => {
                            showNotification('Error updating photo order', 'error');
                        });
                    }
                });
                
                grid.photoSortableInstance = sortable;
            });
        };

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for galleries to load, then initialize
            setTimeout(() => {
                if (typeof window.initializeGallerySortable === 'function') {
                    window.initializeGallerySortable();
                }
                if (typeof window.initializePhotoCardsSortable === 'function') {
                    window.initializePhotoCardsSortable();
                }
            }, 2000);
        });
    </script>

    <!-- Inline debug functions -->
    <script>
    function testInlineHandler() {
        const result = document.getElementById('inlineTestResult');
        result.innerHTML = 'Testing handler...';
        
        fetch('handler/admin_event_handler.php?action=test&t=' + Date.now())
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status + ': ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                result.innerHTML = '<span style="color: green;">✅ Handler works: ' + JSON.stringify(data).substring(0, 100) + '...</span>';
            })
            .catch(error => {
                result.innerHTML = '<span style="color: red;">❌ Handler failed: ' + error.message + '</span>';
            });
    }
    
    function checkFormAction() {
        const form = document.getElementById('eventForm');
        const result = document.getElementById('inlineTestResult');
        if (form) {
            result.innerHTML = '<span style="color: blue;">Form action: ' + form.action + '</span>';
        } else {
            result.innerHTML = '<span style="color: red;">Form not found!</span>';
        }
    } // Close checkFormAction
        
    // Profile functionality
    function initializeProfileTabs() {
        const tabs = document.querySelectorAll('.profile-tab');
        const tabContents = document.querySelectorAll('.profile-tab-content');
        
        console.log('Initializing profile tabs...', tabs.length, 'tabs found');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.dataset.tab;
                    console.log('Switching to tab:', targetTab);
                    
                    // Update tab styles
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.style.backgroundColor = '#f1f5f9';
                        t.style.color = '#475569';
                    });
                    
                    // Update tab content visibility
                    tabContents.forEach(tc => {
                        tc.classList.remove('active');
                        tc.style.display = 'none';
                    });
                    
                    // Activate selected tab
                    this.classList.add('active');
                    this.style.backgroundColor = '#3b82f6';
                    this.style.color = 'white';
                    
                    // Show selected content
                    const targetContent = document.getElementById(targetTab + '-tab');
                    if (targetContent) {
                        targetContent.classList.add('active');
                        targetContent.style.display = 'block';
                        console.log('Successfully switched to:', targetTab);
                    } else {
                        console.error('Target tab content not found:', targetTab + '-tab');
                    }
                });
            });
        }

        // Function to load profile data from server
        function loadProfileData() {
            console.log('==============================================');
            console.log('🔵 loadProfileData() CALLED');
            console.log('==============================================');
            
            // Check if we're in the right section
            const profileSection = document.getElementById('profile');
            if (!profileSection) {
                console.error('✗ Profile section element not found in DOM');
                return;
            }
            
            // Check if section is visible
            const isActive = profileSection.classList.contains('active');
            const displayStyle = window.getComputedStyle(profileSection).display;
            console.log('Profile Section Status:');
            console.log('  - Has "active" class:', isActive ? '✓ Yes' : '✗ No');
            console.log('  - Display style:', displayStyle);
            console.log('  - Is visible:', displayStyle !== 'none' ? '✓ Yes' : '✗ No');
            
            if (!isActive) {
                console.warn('⚠️ Profile section exists but is NOT active - data will load anyway');
            }
            
            console.log('🌐 Making fetch request to handler/admin_profile_handler.php...');
            
            fetch('handler/admin_profile_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_profile_data'
            })
            .then(response => {
                console.log('📡 Response received:');
                console.log('  - Status:', response.status, response.statusText);
                console.log('  - OK:', response.ok ? '✓ Yes' : '✗ No');
                console.log('  - Headers:', {
                    'content-type': response.headers.get('content-type'),
                    'content-length': response.headers.get('content-length')
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('📦 JSON parsed successfully');
                console.log('  - Response structure:', {
                    success: data.success,
                    hasData: !!data.data,
                    hasMessage: !!data.message,
                    dataKeys: data.data ? Object.keys(data.data) : []
                });
                console.log('  - Full response:', data);
                if (data.success && data.data) {
                    const profile = data.data;
                    
                    console.log('✓ API returned profile data:', profile);
                    console.log('=== Starting Field Population ===');
                    
                    // Check if form elements exist before updating
                    const fullNameEl = document.getElementById('profileFullName');
                    const emailEl = document.getElementById('profileEmail');
                    const phoneEl = document.getElementById('profilePhone');
                    const positionEl = document.getElementById('profilePosition');
                    const bioEl = document.getElementById('profileBio');
                    
                    console.log('Field Elements Found:');
                    console.log('  - profileFullName:', fullNameEl ? '✓ Found' : '✗ NOT FOUND');
                    console.log('  - profileEmail:', emailEl ? '✓ Found' : '✗ NOT FOUND');
                    console.log('  - profilePhone:', phoneEl ? '✓ Found' : '✗ NOT FOUND');
                    console.log('  - profilePosition:', positionEl ? '✓ Found' : '✗ NOT FOUND');
                    console.log('  - profileBio:', bioEl ? '✓ Found' : '✗ NOT FOUND');
                    
                    // Update fields with detailed logging
                    if (fullNameEl) {
                        console.log(`Updating fullname: "${fullNameEl.value}" → "${profile.fullname || ''}"`);
                        fullNameEl.value = profile.fullname || '';
                    }
                    if (emailEl) {
                        console.log(`Updating email: "${emailEl.value}" → "${profile.email || ''}"`);
                        emailEl.value = profile.email || '';
                    }
                    if (phoneEl) {
                        console.log(`Updating phone: "${phoneEl.value}" → "${profile.phone || ''}"`);
                        phoneEl.value = profile.phone || '';
                    }
                    if (positionEl) {
                        console.log(`Updating position: "${positionEl.value}" → "${profile.position || ''}"`);
                        positionEl.value = profile.position || '';
                    }
                    if (bioEl) {
                        const oldBio = bioEl.value.substring(0, 50) + '...';
                        const newBio = (profile.bio || '').substring(0, 50) + '...';
                        console.log(`Updating bio: "${oldBio}" → "${newBio}"`);
                        bioEl.value = profile.bio || '';
                    }
                    
                    // Update display info
                    const displayNameEl = document.getElementById('profileDisplayName');
                    const displayPositionEl = document.getElementById('profileDisplayPosition');
                    
                    console.log('Display Elements Found:');
                    console.log('  - profileDisplayName:', displayNameEl ? '✓ Found' : '✗ NOT FOUND');
                    console.log('  - profileDisplayPosition:', displayPositionEl ? '✓ Found' : '✗ NOT FOUND');
                    
                    if (displayNameEl) {
                        console.log(`Updating display name: "${displayNameEl.textContent}" → "${profile.fullname || '(No name)'}"`);
                        displayNameEl.textContent = profile.fullname || '(No name)';
                    }
                    if (displayPositionEl) {
                        console.log(`Updating display position: "${displayPositionEl.textContent}" → "${profile.position || '(No position)'}"`);
                        displayPositionEl.textContent = profile.position || '(No position)';
                    }
                    
                    // Update header user info
                    const headerNameEl = document.getElementById('headerUserName');
                    const headerRoleEl = document.getElementById('headerUserRole');
                    if (headerNameEl) {
                        console.log(`Updating header name: "${headerNameEl.textContent}" → "${profile.fullname}"`);
                        headerNameEl.textContent = profile.fullname || 'User';
                    }
                    if (headerRoleEl && profile.position) {
                        console.log(`Updating header role: "${headerRoleEl.textContent}" → "${profile.position}"`);
                        headerRoleEl.textContent = profile.position;
                    }
                    
                    console.log('✓✓✓ Profile data loaded and populated successfully ✓✓✓');
                } else {
                    console.error('Failed to load profile data:', data.message);
                    
                    // Check if session expired
                    if (data.message && data.message.includes('Session expired')) {
                        alert('Your session has expired. Please log in again.');
                        window.location.href = 'login_page_v1.php?error=session_expired';
                    }
                }
            })
            .catch(error => {
                console.error('Error loading profile data:', error);
                if (typeof showNotification === 'function') {
                    showNotification('Failed to load profile data. Please refresh the page.', 'error');
                }
            });
        }

        function resetProfileForm() {
            // Reload profile data from server to reset form
            loadProfileData();
        }

        function submitProfileForm() {
            const profileForm = document.getElementById('profileInfoForm');
            if (!profileForm) return;
            
            // Get form values
            const fullName = document.getElementById('profileFullName').value;
            const email = document.getElementById('profileEmail').value;
            const phone = document.getElementById('profilePhone').value;
            const position = document.getElementById('profilePosition').value;
            const bio = document.getElementById('profileBio').value;
            
            // Validate required fields
            if (!fullName.trim() || !email.trim()) {
                showNotification('Full name and email are required!', 'error');
                return;
            }
            
            // Update display info
            document.getElementById('profileDisplayName').textContent = fullName;
            document.getElementById('profileDisplayPosition').textContent = position;
            
            // Update header info
            const headerNameEl = document.getElementById('headerUserName');
            const headerRoleEl = document.getElementById('headerUserRole');
            if (headerNameEl) headerNameEl.textContent = fullName;
            if (headerRoleEl) headerRoleEl.textContent = position;
            
            // Send data to server
            const formData = new FormData();
            formData.append('action', 'update_profile_info');
            formData.append('fullname', fullName);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('position', position);
            formData.append('bio', bio);
            
            fetch('handler/admin_profile_handler.php', { 
                method: 'POST', 
                body: formData 
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification('Profile updated successfully!', 'success');
                } else {
                    showNotification('Error: ' + data.message, 'error');
                    
                    // Check if session expired
                    if (data.message && data.message.includes('Session expired')) {
                        setTimeout(() => {
                            window.location.href = 'login_page_v1.php?error=session_expired';
                        }, 2000);
                    }
                }
            })
            .catch(error => {
                console.error('Profile update error:', error);
                showNotification('Network error. Please try again.', 'error');
            });
        }

        function resetPasswordForm() {
            const form = document.getElementById('passwordChangeForm');
            if (form) {
                form.reset();
            }
        }

        // Direct tab switching function
        function switchToSecurityTab() {
            console.log('Switching to security tab...');
            
            // Hide information tab
            const infoTab = document.getElementById('information-tab');
            const securityTab = document.getElementById('security-tab');
            const infoBtn = document.querySelector('[data-tab="information"]');
            const securityBtn = document.querySelector('[data-tab="security"]');
            
            if (infoTab) {
                infoTab.style.display = 'none';
                infoTab.classList.remove('active');
            }
            
            if (securityTab) {
                securityTab.style.display = 'block';
                securityTab.classList.add('active');
            }
            
            if (infoBtn) {
                infoBtn.style.backgroundColor = '#f1f5f9';
                infoBtn.style.color = '#475569';
                infoBtn.classList.remove('active');
            }
            
            if (securityBtn) {
                securityBtn.style.backgroundColor = '#3b82f6';
                securityBtn.style.color = 'white';
                securityBtn.classList.add('active');
            }
            
            console.log('Security tab activated');
        }
        
        function switchToInformationTab() {
            console.log('Switching to information tab...');
            
            // Hide security tab
            const infoTab = document.getElementById('information-tab');
            const securityTab = document.getElementById('security-tab');
            const infoBtn = document.querySelector('[data-tab="information"]');
            const securityBtn = document.querySelector('[data-tab="security"]');
            
            if (securityTab) {
                securityTab.style.display = 'none';
                securityTab.classList.remove('active');
            }
            
            if (infoTab) {
                infoTab.style.display = 'block';
                infoTab.classList.add('active');
            }
            
            if (securityBtn) {
                securityBtn.style.backgroundColor = '#f1f5f9';
                securityBtn.style.color = '#475569';
                securityBtn.classList.remove('active');
            }
            
            if (infoBtn) {
                infoBtn.style.backgroundColor = '#3b82f6';
                infoBtn.style.color = 'white';
                infoBtn.classList.add('active');
            }
            
            console.log('Information tab activated');
        }

        // Initialize profile functionality when DOM loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing profile functionality...');
            initializeProfileTabs();
            
            // Only load profile data if profile section is already visible
            const profileSection = document.getElementById('profile');
            if (profileSection && profileSection.classList.contains('active')) {
                console.log('Profile section is active on page load, loading data...');
                setTimeout(() => {
                    loadProfileData();
                }, 500);
            } else {
                console.log('Profile section not active, data will load on navigation');
            }
            
            // Check if analytics section is visible on page load
            const analyticsSection = document.getElementById('analytics');
            if (analyticsSection && analyticsSection.classList.contains('active')) {
                console.log('Analytics section is active on page load, loading data...');
                setTimeout(() => {
                    loadAnalyticsData();
                }, 500);
            } else {
                console.log('Analytics section not active, data will load on navigation');
            }

            
            // Password form submission
            const passwordForm = document.getElementById('passwordChangeForm');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const newPassword = document.getElementById('newPassword').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;
                    
                    if (newPassword !== confirmPassword) {
                        showNotification('Passwords do not match!', 'error');
                        return;
                    }
                    
                    if (newPassword.length < 8) {
                        showNotification('Password must be at least 8 characters long!', 'error');
                        return;
                    }
                    
                    // Update last password change date
                    const now = new Date();
                    document.getElementById('lastPasswordChange').textContent = now.toLocaleDateString();
                    
                    // Send password change to server
                    const formData = new FormData(this);
                    formData.append('action', 'change_password');
                    
                    fetch('handler/admin_profile_handler.php', { 
                        method: 'POST', 
                        body: formData 
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update last password change date
                            const now = new Date();
                            document.getElementById('lastPasswordChange').textContent = now.toLocaleDateString();
                            
                            showNotification('Password updated successfully!', 'success');
                            resetPasswordForm();
                        } else {
                            showNotification('Error: ' + data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showNotification('Network error. Please try again.', 'error');
                    });
                });
            }
        }); // Close DOMContentLoaded
        
        // Let external JS handle everything
    </script>
</body>
</html>
