<?php
// Start session and check authentication
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login_page_v1.php?error=not_logged_in");
    exit();
}

// Check session timeout (30 minutes default)
$session_timeout = $_SESSION['session_timeout'] ?? 1800; // 30 minutes in seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Session expired
    session_unset();
    session_destroy();
    header("Location: login_page_v1.php?error=session_expired");
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Get current user info
$current_user = $_SESSION['user'];
$admin_id = $_SESSION['admin_id'];
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
        
        /* STANDARDIZED MODAL STYLING - Based on News Modal */
        .photo-modal,
        .event-modal,
        .sponsorship-modal {
            display: none !important;
        }
        
        #photoModal,
        #eventModal,
        #sponsorshipModal {
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
        #sponsorshipModal.show {
            display: flex !important;
        }
        
        .photo-modal-content,
        .event-modal-content,
        .sponsorship-modal-content {
            background: white !important;
            border-radius: 12px !important;
            width: 90% !important;
            max-width: 600px !important;
            max-height: 90vh !important;
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
            color: #FF0000 !important;
            background: rgba(255, 0, 0, 0.1) !important;
        }
        
        /* Modal Body Styling */
        .photo-modal-content form,
        .event-modal-content form,
        .sponsorship-modal-content form {
            padding: 32px !important;
            max-height: calc(90vh - 140px) !important;
            overflow-y: auto !important;
        }

        /* User Dropdown Styles */
        .user-profile {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-dropdown {
            position: relative;
        }

        .dropdown-toggle {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .dropdown-toggle:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            min-width: 200px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f9fafb;
            color: #111827;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 8px 0;
            border: 0;
            border-top: 1px solid #e5e7eb;
        }

        .logout-link {
            color: #dc2626 !important;
        }

        .logout-link:hover {
            background-color: #fef2f2 !important;
        }

        /* Basic Profile Styling */

        .preference-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .preference-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
        }

        .preference-header h4 {
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 8px 0;
        }

        .preference-header p {
            color: #64748b;
            font-size: 14px;
            margin: 0 0 20px 0;
        }





        .btn-primary, .btn-secondary, .btn-outline {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .btn-outline {
            background: transparent;
            color: #6b7280;
            border: 1px solid #d1d5db;
        }

        .btn-outline:hover {
            background: #f9fafb;
            color: #374151;
        }

        /* Activity Log Styles */
        .activity-log-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 32px;
            color: white;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .activity-header-content h3 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .activity-header-content p {
            opacity: 0.9;
            margin: 8px 0 0 0;
            font-size: 16px;
        }

        .activity-stats {
            display: flex;
            gap: 24px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.1);
            padding: 16px 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .stat-item i {
            font-size: 24px;
        }

        .stat-number {
            display: block;
            font-size: 24px;
            font-weight: 700;
        }

        .stat-label {
            display: block;
            font-size: 14px;
            opacity: 0.8;
        }

        .activity-controls {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .filter-group {
            display: flex;
            gap: 20px;
            align-items: end;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-item label {
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }

        .activity-container {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .activity-logs-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .activity-log-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }

        .activity-log-item:hover {
            background: #f8fafc;
        }

        .activity-log-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .activity-details {
            flex: 1;
        }

        .activity-action {
            font-weight: 600;
            color: #1e293b;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .activity-description {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .activity-meta {
            display: flex;
            gap: 16px;
            font-size: 12px;
            color: #9ca3af;
        }

        .activity-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .loading-spinner {
            font-size: 32px;
            margin-bottom: 16px;
        }

        .activity-actions {
            padding: 20px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .no-activity {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
            font-style: italic;
        }

        /* Removed theme system - keeping only light theme */

        body.dark-theme .sidebar {
            background-color: #2d2d2d;
            border-right-color: #404040;
            color: #ffffff;
        }

        body.dark-theme .header {
            background-color: #2d2d2d;
            border-bottom-color: #404040;
            color: #ffffff;
        }

        body.dark-theme .main-container {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        body.dark-theme .content-area {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        body.dark-theme .page-title {
            color: #ffffff !important;
        }

        body.dark-theme .preference-card,
        body.dark-theme .activity-container,
        body.dark-theme .activity-controls,
        body.dark-theme .profile-form-card {
            background-color: #4a4a4a;
            border-color: #606060;
            color: #ffffff;
        }

        body.dark-theme .modern-select {
            background-color: #4a4a4a;
            border-color: #606060;
            color: #ffffff;
        }

        body.dark-theme .section-info h3 {
            color: #ffffff !important;
        }

        body.dark-theme .section-info p {
            color: #d0d0d0 !important;
        }

        body.dark-theme .preference-header h4,
        body.dark-theme .activity-action {
            color: #ffffff;
        }

        body.dark-theme .preference-header p,
        body.dark-theme .activity-description {
            color: #d0d0d0;
        }

        body.dark-theme .theme-preview {
            border-color: #d0d0d0;
        }

        body.dark-theme .notification-item {
            background-color: #555555;
            border-color: #606060;
            color: #ffffff;
        }

        body.dark-theme .notification-item h5 {
            color: #ffffff;
        }

        body.dark-theme .notification-item p {
            color: #d0d0d0;
        }

        body.dark-theme .control-group label {
            color: #ffffff;
        }

        body.dark-theme .control-group small {
            color: #d0d0d0;
        }

        body.dark-theme .filter-item label {
            color: #ffffff;
        }

        body.dark-theme .activity-log-item:hover {
            background-color: #555555;
        }

        body.dark-theme .activity-log-item {
            border-bottom-color: #606060;
        }

        body.dark-theme .theme-option span {
            color: #ffffff;
        }

        body.dark-theme h1, body.dark-theme h2, body.dark-theme h3, body.dark-theme h4, body.dark-theme h5 {
            color: #ffffff !important;
        }

        body.dark-theme .nav-item {
            color: #ffffff;
        }

        body.dark-theme .nav-item.active {
            color: #ffffff;
        }

        body.dark-theme .nav-section-title {
            color: #d0d0d0;
        }

        body.dark-theme .user-name {
            color: #ffffff;
        }

        body.dark-theme .user-role {
            color: #d0d0d0;
        }

        /* Global dark theme for ALL content containers */
        body.dark-theme .content-section,
        body.dark-theme .section-card,
        body.dark-theme .card,
        body.dark-theme .modal-content,
        body.dark-theme .photo-modal-content,
        body.dark-theme .event-modal-content,
        body.dark-theme .sponsorship-modal-content,
        body.dark-theme .news-modal-content,
        body.dark-theme .gallery-section,
        body.dark-theme .photo-collection,
        body.dark-theme .collection-header,
        body.dark-theme .published-photos,
        body.dark-theme .photo-management-container,
        body.dark-theme .gallery-container,
        body.dark-theme .container,
        body.dark-theme .content-container,
        body.dark-theme .admin-container,
        body.dark-theme .dashboard-card,
        body.dark-theme .management-section,
        body.dark-theme .form-container,
        body.dark-theme .data-table,
        body.dark-theme .table-container,
        body.dark-theme .stats-container,
        body.dark-theme .overview-card,
        body.dark-theme .analytics-container,
        body.dark-theme .report-section,
        body.dark-theme .section,
        body.dark-theme .panel,
        body.dark-theme .widget,
        body.dark-theme .box {
            background-color: #4a4a4a !important;
            border-color: #606060 !important;
            color: #ffffff !important;
        }

        /* All text elements in dark theme containers */
        body.dark-theme .content-section h1,
        body.dark-theme .content-section h2,
        body.dark-theme .content-section h3,
        body.dark-theme .content-section h4,
        body.dark-theme .content-section h5,
        body.dark-theme .content-section h6,
        body.dark-theme .content-section p,
        body.dark-theme .content-section span,
        body.dark-theme .content-section div,
        body.dark-theme .content-section label,
        body.dark-theme .gallery-section *,
        body.dark-theme .photo-collection *,
        body.dark-theme .published-photos *,
        body.dark-theme .photo-management-container *,
        body.dark-theme .container *,
        body.dark-theme .management-section *,
        body.dark-theme .dashboard-card *,
        body.dark-theme .section * {
            color: #ffffff !important;
        }

        /* Input fields and form elements */
        body.dark-theme input,
        body.dark-theme textarea,
        body.dark-theme select,
        body.dark-theme .form-control,
        body.dark-theme .input-field {
            background-color: #4a4a4a !important;
            border-color: #606060 !important;
            color: #ffffff !important;
        }

        /* Buttons in dark theme */
        body.dark-theme .btn:not(.btn-primary):not(.btn-secondary),
        body.dark-theme button:not(.btn-primary):not(.btn-secondary) {
            background-color: #4a4a4a !important;
            border-color: #606060 !important;
            color: #ffffff !important;
        }

        /* Tables in dark theme */
        body.dark-theme table,
        body.dark-theme .table,
        body.dark-theme .data-table {
            background-color: #4a4a4a !important;
            color: #ffffff !important;
        }

        body.dark-theme th,
        body.dark-theme td {
            border-color: #606060 !important;
            color: #ffffff !important;
        }

        /* Chapter cards and item containers */
        body.dark-theme .chapter-item,
        body.dark-theme .chapter-card,
        body.dark-theme .item-card,
        body.dark-theme .card-body,
        body.dark-theme .card-content,
        body.dark-theme .item-container,
        body.dark-theme .list-item,
        body.dark-theme .data-item,
        body.dark-theme .entry-item,
        body.dark-theme .row-item,
        body.dark-theme .grid-item,
        body.dark-theme .flex-item {
            background-color: #4a4a4a !important;
            border-color: #606060 !important;
            color: #ffffff !important;
        }

        /* Nested content within cards */
        body.dark-theme .chapter-item *,
        body.dark-theme .chapter-card *,
        body.dark-theme .item-card *,
        body.dark-theme .card-body *,
        body.dark-theme .list-item * {
            color: #ffffff !important;
        }

        /* Any divs or spans that might have white backgrounds */
        body.dark-theme div[style*="background"],
        body.dark-theme span[style*="background"],
        body.dark-theme .bg-white,
        body.dark-theme .background-white,
        body.dark-theme .white-bg {
            background-color: #4a4a4a !important;
            color: #ffffff !important;
        }

        /* Fix for any remaining white backgrounds */
        body.dark-theme * {
            border-color: #606060 !important;
        }

        body.dark-theme [style*="background-color: white"],
        body.dark-theme [style*="background-color: #ffffff"],
        body.dark-theme [style*="background-color:#ffffff"],
        body.dark-theme [style*="background: white"],
        body.dark-theme [style*="background: #ffffff"],
        body.dark-theme [class*="white"],
        body.dark-theme [class*="light"] {
            background-color: #4a4a4a !important;
            color: #ffffff !important;
        }

        /* Action buttons keep their original colors in dark theme */
        body.dark-theme .btn-success,
        body.dark-theme .add-btn,
        body.dark-theme .create-btn,
        body.dark-theme [class*="add"],
        body.dark-theme .btn.btn-success {
            background-color: #28a745 !important; /* Green for add/create */
            color: #ffffff !important;
            border-color: #28a745 !important;
        }

        body.dark-theme .btn-primary,
        body.dark-theme .edit-btn,
        body.dark-theme .update-btn,
        body.dark-theme .save-btn,
        body.dark-theme [class*="edit"],
        body.dark-theme .btn.btn-primary {
            background-color: #007bff !important; /* Blue for edit/save */
            color: #ffffff !important;
            border-color: #007bff !important;
        }

        body.dark-theme .btn-danger,
        body.dark-theme .delete-btn,
        body.dark-theme .remove-btn,
        body.dark-theme [class*="delete"],
        body.dark-theme .btn.btn-danger {
            background-color: #dc3545 !important; /* Red for delete */
            color: #ffffff !important;
            border-color: #dc3545 !important;
        }

        /* Action button hover effects - enhance their original colors */
        body.dark-theme .btn-success:hover,
        body.dark-theme .add-btn:hover {
            background-color: #218838 !important; /* Darker green on hover */
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3) !important;
            transform: translateY(-1px);
        }

        body.dark-theme .btn-primary:hover,
        body.dark-theme .edit-btn:hover,
        body.dark-theme .save-btn:hover {
            background-color: #0056b3 !important; /* Darker blue on hover */
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3) !important;
            transform: translateY(-1px);
        }

        body.dark-theme .btn-danger:hover,
        body.dark-theme .delete-btn:hover {
            background-color: #c82333 !important; /* Darker red on hover */
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3) !important;
            transform: translateY(-1px);
        }

        /* General buttons and navigation get red hover */
        body.dark-theme .btn:not(.btn-primary):not(.btn-success):not(.btn-danger):not(.btn-warning):not(.btn-info):hover,
        body.dark-theme button:not(.btn-primary):not(.btn-success):not(.btn-danger):hover,
        body.dark-theme .nav-link:hover,
        body.dark-theme .menu-item:hover,
        body.dark-theme .sidebar-item:hover,
        body.dark-theme .clickable:hover {
            background-color: #dc3545 !important; /* Red for general buttons */
            color: #ffffff !important;
            border-color: #dc3545 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3) !important;
            transition: all 0.3s ease !important;
        }

        /* Card hover effects */
        body.dark-theme .card:hover,
        body.dark-theme .chapter-item:hover,
        body.dark-theme .chapter-card:hover,
        body.dark-theme .item-card:hover {
            border-color: #dc3545 !important;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2) !important;
            transform: translateY(-2px);
            transition: all 0.3s ease !important;
        }

        /* Link hover effects */
        body.dark-theme a:hover,
        body.dark-theme .link:hover {
            color: #dc3545 !important;
            text-decoration: underline;
            transition: color 0.3s ease !important;
        }

        /* Theme selection hover */
        body.dark-theme .theme-option:hover {
            border-color: #dc3545 !important;
            box-shadow: 0 0 10px rgba(220, 53, 69, 0.4) !important;
        }

        /* Fix for gradient backgrounds and weird elements */
        body.dark-theme .gradient,
        body.dark-theme [class*="gradient"],
        body.dark-theme [style*="gradient"] {
            background: #4a4a4a !important;
        }

        /* Fix for activity log gradient */
        body.dark-theme .activity-log-container,
        body.dark-theme .activity-section {
            background: #4a4a4a !important;
            border: 1px solid #606060 !important;
        }

        /* Fix for any bootstrap or framework conflicts */
        body.dark-theme .bg-primary,
        body.dark-theme .bg-secondary,
        body.dark-theme .bg-light,
        body.dark-theme .bg-white {
            background-color: #4a4a4a !important;
            color: #ffffff !important;
        }

        /* Force all elements to have proper dark theme colors */
        body.dark-theme *:not(.btn-primary):not(.btn-success):not(.btn-danger):not(.btn-warning):not(.btn-info) {
            background-color: inherit !important;
        }

        body.dark-theme .white,
        body.dark-theme .light,
        body.dark-theme [bgcolor="white"],
        body.dark-theme [bgcolor="#ffffff"] {
            background-color: #4a4a4a !important;
            color: #ffffff !important;
        }

        /* Smooth transitions for better UX */
        body.dark-theme * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
        }

        body.light-theme {
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .preferences-grid {
                grid-template-columns: 1fr;
            }
            
            .theme-selector {
                grid-template-columns: 1fr;
            }
            
            .activity-log-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .activity-stats {
                justify-content: center;
            }
            
            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .preferences-actions {
                flex-direction: column;
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
                    <span>Other Special Olympics</span>
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
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search...">
                </div>

                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge"></span>
                </button>

                <div class="user-profile">
                    <div class="user-avatar"><?php echo strtoupper(substr($current_user, 0, 1)); ?></div>
                    <div class="user-info">
                        <span class="user-name"><?php echo htmlspecialchars($current_user); ?></span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <div class="user-dropdown">
                        <button class="dropdown-toggle" onclick="toggleUserDropdown()">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="userDropdownMenu">
                            <a href="#" onclick="showProfileTab()" class="dropdown-item">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <a href="#" onclick="showPreferencesTab()" class="dropdown-item">
                                <i class="fas fa-cogs"></i> Settings
                            </a>
                            <hr class="dropdown-divider">
                            <a href="logout.php" class="dropdown-item logout-link">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
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
                    <h2 class="section-title">Dashboard Overview</h2>
                    <p class="section-subtitle">Welcome to Special Olympics Sarawak Admin Webmaster</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-tachometer-alt"></i>
                    <h3>Dashboard Content</h3>
                    <p>Add your dashboard widgets and statistics here</p>
                    <div>
                        <p>Use this space to display key metrics, charts, and quick links to other sections.</p>
                        <ul>

                        </ul>

                    </div>

                </div>
            </div>

            <!-- Analytics Section -->
            <div class="content-section" id="analytics">
                <div class="section-header">
                    <h2 class="section-title">Analytics</h2>
                    <p class="section-subtitle">View detailed analytics and reports</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-chart-line"></i>
                    <h3>Analytics Content</h3>
                    <p>Add your charts, graphs, and analytics data here</p>
                </div>
            </div>

            <div class="content-section" id="posters">
                <div class="section-header">
                    <h2 class="section-title">Posters Management</h2>
                    <p class="section-subtitle">Create and manage the posters for the Index page. The recommended aspect
                        ratio for each poster is 4:5 portrait.<br>*This posters management interface is under
                        development</p>
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
                        <h3>Existing Events</h3>
                        <div id="existingEvents">
                            <!-- Events will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333;">Loading events...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sports Section -->
            <div class="content-section" id="sports">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Sports Management</h2>
                        <p class="section-subtitle">Manage sports in the Our Sports page.</p>
                    </div>
                    <button class="add-sport-btn" onclick="openSportModal()">
                        <i class="fas fa-plus"></i> Add Sport
                    </button>
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
                        <div class="published-title">
                            <h3>Existing Sports <span style="font-size: 14px; color: #666;">(Drag to reorder)</span></h3>
                        </div>
                        <div id="existingSports" class="sortable-sports">
                            <!-- Sports will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333;">Loading sports...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Athletes Section -->
            <div class="content-section" id="athletes">
                <div class="section-header">
                    <h2 class="section-title">Athletes Management</h2>
                    <p class="section-subtitle">Manage athlete registrations and profiles</p>
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
                    <h2 class="section-title">Volunteers Management</h2>
                    <p class="section-subtitle">Manage volunteer applications and schedules</p>
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
                    <h2 class="section-title">Coaches Management</h2>
                    <p class="section-subtitle">Manage coach profiles and certifications</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-user-tie"></i>
                    <h3>Coaches Content</h3>
                    <p>Add your coach management interface here</p>
                </div>
            </div>

            <!-- State Games -->
            <div class="content-section" id="state-games">
                <div class="section-header">
                    <h2 class="section-title">State Games — Special Olympics Major Events Management</h2>
                    <p>Manage event articles on the State Games page content.</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>State Games Event</h3>
                    <p>This section should allows admin to add and manage Special Olympics Major Events articles</p>
                </div>
            </div>

            <!-- Sarawak Chapters Management Section -->
            <div class="content-section" id="sarawak-chapters">
                <div class="section-header">
                    <h2 class="section-title">Sarawak Chapters Management</h2>
                    <p class="section-subtitle">Manage chapter information and leadership details</p>
                </div>

                <div class="chapters-management-container">
                    <div class="chapters-list-admin">
                        <div class="published-title">
                            <h3>Existing Chapters <span style="font-size: 14px; color: #666;">(Click Edit to modify)</span></h3>
                        </div>
                        <div id="existingChapters" class="sortable-chapters">
                            <!-- Chapters will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333;">Loading chapters...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chapter Participants Overview -->
            <div class="content-section" id="participants-overview">
                <div class="section-header">
                    <h2 class="section-title">Participants Overview</h2>
                    <p class="section-subtitle">View and manage participant statistics by chapter</p>
                </div>

                <div class="participants-management-container">
                    <div class="participants-controls">
                        <label for="yearSelect">Year:</label>
                        <select id="yearSelect" onchange="loadParticipantsData()">
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                        </select>
                    </div>
                    
                    <div class="participants-overview-grid" id="participantsOverview">
                        <!-- Participants overview will be loaded here via AJAX -->
                        <p style="text-align: center; color: #333;">Loading participants data...</p>
                    </div>
                </div>
            </div>

            <!-- News Section -->
            <div class="content-section" id="news">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">News Management</h2>
                        <p class="section-subtitle">Create and manage news articles</p>
                    </div>
                    <button id="addNewsBtn" class="add-news-btn">
                        <i class="fas fa-plus"></i> Add News
                    </button>
                </div>

                <div class="news-management-container">
                    <div class="news-list-admin">
                        <h3>Existing News Articles</h3>
                        <div id="existingNewsArticles">
                            <!-- News articles will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333;">Loading news articles...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Athlete Leaderships -->
            <div class="content-section" id="alp">
                <div class="section-header">
                    <h2 class="section-title">Athlete Leaderships Management</h2>
                    <p class="section-subtitle">Manage Athlete Leaderships Program (ALP) overview articles, resources
                        and the "learn more" page.</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>Athlete Leaderships Program</h3>
                    <p>Add your Athlete Leaderships management interface here</p>
                </div>
            </div>

            <!-- Healthy Athletes -->
            <div class="content-section" id="sohap">
                <div class="section-header">
                    <h2 class="section-title">Healthy Athletes Management</h2>
                    <p class="section-subtitle">Manage Healthy Athletes Program (SOHAP) overview articles, resources and
                        the "learn more" page.</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>Healthy Athletes Program</h3>
                    <p>Add your Healthy Athletes management interface here</p>
                </div>
            </div>

            <!-- Young Athletes -->
            <div class="content-section" id="yap">
                <div class="section-header">
                    <h2 class="section-title">Young Athletes Management</h2>
                    <p class="section-subtitle">Manage Young Athletes Program (YAP) overview articles, resources and the
                        "learn more" page.</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>Young Athletes Program</h3>
                    <p>Add your Young Athletes management interface here</p>
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
                    <div>
                        <h2 class="section-title">Photo Management</h2>
                        <p class="section-subtitle">Manage gallery photos and collections</p>
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
                                    style="color: #FF0000;">*required</span></label>
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
                                    style="color: #FF0000;">*required</span></label>
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
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoAlbum"
                                name="galleryPhotoAlbum">
                        </div>
                        <div class="gpmac-form-group">
                            <label>Descriptions</label>
                            <!-- Fetch descriptions from the database -->
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoAlbumDesc"
                                name="galleryPhotoAlbumDesc">
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
                    <h2 class="section-title">Video Management</h2>
                    <p class="section-subtitle">Upload and manage videos in the gallery.<br><br>The recommended maximum
                        video resolution is <strong>1920×1080</strong>, with a <strong>video bitrate between 2–6
                            Mbps</strong> and an <strong>audio bitrate of 128 kbps (AAC)</strong> to help prevent
                        buffering issues. Since the admin webmaster does <strong>not support automatic video
                            compression</strong> like most streaming platforms, you’ll need to <strong>manually compress
                            your original video</strong> into the MP4 format before uploading.<br><br>*This video
                        management interface is under development.</p>
                </div>

                <div class="galvideo-management-container">
                    <h3>Add Video</h3>
                    <form id="galleryVideo" action="../admin/handler/admin_gallery_video_handler.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" id="galleryVideoId" name="id">
                        <input type="hidden" id="currentGalleryVideoImage" name="currentImage">
                        <div class="galvideo-form-group">
                            <label for="galleryVideo">Upload Video: <span
                                    style="color: #FF0000;">*required</span></label>
                            <label for="galleryVideo" class="custom-browse-btn">Browse</label>
                            <input type="file" id="galleryVideo" name="galleryVideo" accept="video/mp4"
                                style="display: none;">
                            <button type="button" id="deleteGalleryVideoBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="galleryVideoStatus">No file selected.</span>
                        </div>
                        <div class="galvideo-form-group">
                            <label for="galleryVideoImage">Video Cover: <span
                                    style="color: #FF0000;">*required</span></label>
                            <label for="galleryVideoImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="galleryVideoImage" name="galleryVideoImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deleteGalleryVideoImageBtn"
                                class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="galleryVideoImageStatus">No file selected.</span>
                            <img id="galleryVideoImagePreview" src="" alt="Video Thumbnail"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="galvideo-form-group">
                            <label for="galleryVideoTitle">Video Title: <span
                                    style="color: #FF0000;">*required</span></label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryVideoTitle"
                                name="galleryVideoTitle" required>
                        </div>
                        <div class="galvideo-form-group">
                            <!-- Not displayed on the gallery but to be fetched to the video playback page -->
                            <label for="galleryVideoDesc">Descriptions:</label>
                            <textarea style="font-family: 'Inter', sans-serif;" id="galleryVideoDesc"
                                name="galleryVideoDesc"></textarea>
                        </div>
                        <div class="galvideo-form-group">
                            <label for="galleryVideoAlbum">Select Existing Collection: <span
                                    style="color: #FF0000;">*required</span></label>
                            <select id="galleryVideoAlbum" name="galleryVideoAlbum" required>
                                <option value="">Fetching data...</option>
                            </select>
                        </div>
                        <div class="galvideo-form-group">
                            <!-- Adds an album / event / category for the admin's dropdown options, and to display to the end-user's interface -->
                            <label for="galleryVideoAddAlbum">New Collection Name</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryVideoAddAlbum"
                                name="galleryVideoAddAlbum" placeholder="Healthy Athletes Program">
                        </div>
                        <div class="galvideo-form-group">
                            <!-- Add a description for the end-user's interface -->
                            <label for="galleryVideoAlbumDesc">Descriptions for the new Collection (recommended for
                                UX)</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryVideoAlbumDesc"
                                name="galleryVideoAlbumDesc"
                                placeholder="The Healthy Athletes Program video category showcases content promoting health, fitness, and wellness initiatives for athletes with intellectual disabilities.">
                        </div>
                        <button type="submit" class="galvideo-submit-btn" id="submitGalleryVideoBtn">Publish</button>
                    </form>

                    <div class="gallery-admin-container">
                        <div class="gallery-admin-title">
                            <h3>Published Videos</h3>
                        </div>
                        <div id="publishedGalleryVideo">
                            <!-- <p style="text-align: center; color: #333;">Fetching videos from the database...</p> -->
                            <!-- Published videos will be loaded here via AJAX, such as -->
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



            <!-- Sponsorships -->
            <div class="content-section" id="sponsorships">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Sponsorships Management</h2>
                        <p class="section-subtitle">Manage Special Olympics Sarawak sponsorships by just simply add, edit and remove images.</p>
                    </div>
                    <button class="add-sponsorship-btn" onclick="openSponsorshipModal()">
                        <i class="fas fa-plus"></i> Add Sponsorship
                    </button>
                </div>

                <div class="sponsorship-management-container">
                    <!-- Sponsorship Form Modal -->
                    <div class="sponsorship-modal" id="sponsorshipModal">
                        <div class="sponsorship-modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Add New Sponsorship</h3>
                                <span class="modal-close" onclick="closeSponsorshipModal()">&times;</span>
                            </div>
                            <form id="sponsorshipForm" action="../admin/handler/admin_sponsorship_handler.php" method="POST"
                                enctype="multipart/form-data">
                        <input type="hidden" id="sponsorshipId" name="id">
                        <input type="hidden" id="currentSponsorshipImage" name="currentSponsorshipImage">
                        <div class="sponsorship-form-group">
                            <label for="sponsorshipImage">Upload Image:</label>
                            <label for="sponsorshipImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="sponsorshipImage" name="sponsorshipImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deleteSponsorshipImageBtn"
                                class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="sponsorshipImageStatus">No file selected.</span>
                            <img id="sponsorshipImagePreview" src="" alt="Sponsorship Image Preview"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="sponsorship-form-group">
                            <label for="sponsorshipChapter">Sponsorship Type:</label>
                            <select style="font-family: 'Inter', sans-serif;" id="sponsorshipChapter"
                                name="sponsorshipChapter" required>
                                <option value="Special Olympics Sarawak">Special Olympics Sarawak</option>
                                <option value="Bintulu Chapter">Bintulu Chapter</option>
                                <option value="Kuching Chapter">Kuching Chapter</option>
                                <option value="Miri Chapter">Miri Chapter</option>
                                <option value="Samarahan Chapter">Samarahan Chapter</option>
                                <option value="Sibu Chapter">Sibu Chapter</option>
                            </select>
                        </div>
                                <button type="submit" class="sponsorship-submit-btn" id="submitSponsorshipBtn">Add
                                    Sponsorship</button>
                                <button type="button" class="sponsorship-submit-btn" id="cancelEditBtn"
                                    style="display: none; background-color: #6c757d;"> Cancel Edit</button>
                            </form>
                        </div>
                    </div>

                    <div class="sponsorship-list-admin">
                        <h3>Current Sponsorships</h3>
                        <div id="currentSponsorship">
                            <!-- Events will be loaded here via AJAX -->
                            <p style="text-align: center; color: #64748b;">Loading sponsorship...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Special Olympics -->
            <div class="content-section" id="other-special-olympics">
                <div class="section-header">
                    <h2 class="section-title">Other Special Olympics Management</h2>
                    <p class="section-subtitle">Manage other Special Olympics.</p>
                </div>

                <div class="content-placeholder">
                    <i class="fa-solid fa-globe"></i>
                    <h3>Other Special Olympics</h3>
                    <p>Add your other Special Olympics management interface here</p>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="content-section" id="settings">
                <div class="section-header">
                    <h2 class="section-title">Settings</h2>
                    <p class="section-subtitle">Configure your admin panel settings</p>
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
                    <h2 class="section-title">Profile</h2>
                    <p class="section-subtitle">Manage your admin profile and security settings</p>
                </div>

                <div class="profile-container">
                    <!-- Profile Navigation Tabs -->
                    <div class="profile-tabs">
                        <button class="profile-tab active" data-tab="information">
                            <i class="fas fa-user"></i>
                            Information
                        </button>
                        <button class="profile-tab" data-tab="security">
                            <i class="fas fa-lock"></i>
                            Security
                        </button>
                    </div>

                    <!-- Information Tab -->
                    <div class="profile-tab-content active" id="information-tab">
                        <div class="profile-card">
                            <div class="profile-avatar-section">
                                <div class="profile-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="profile-basic-info">
                                    <h3 id="profileDisplayName">Admin User</h3>
                                    <p id="profileDisplayPosition">System Administrator</p>
                                </div>
                            </div>

                            <form id="profileInfoForm" class="profile-form">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="profileFullName">Full Name</label>
                                        <input type="text" id="profileFullName" name="fullname" value="Admin User" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="profileEmail">Email Address</label>
                                        <input type="email" id="profileEmail" name="email" value="admin@1234" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="profilePhone">Phone Number</label>
                                        <input type="tel" id="profilePhone" name="phone" value="+60 12-345-6789">
                                    </div>
                                    <div class="form-group">
                                        <label for="profilePosition">Position</label>
                                        <input type="text" id="profilePosition" name="position" value="System Administrator">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="profileBio">Biography</label>
                                    <textarea id="profileBio" name="bio" rows="4" placeholder="Tell us about yourself...">Dedicated administrator managing the Special Olympics Sarawak digital platform and supporting athletes across all programs.</textarea>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn-secondary" onclick="resetProfileForm()">Reset</button>
                                    <button type="submit" class="btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="profile-tab-content" id="security-tab">
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

    <!-- SortableJS for drag-and-drop functionality -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <script src="../scripts/admin-components/navigation-functionality.js"></script>
    <script src="../scripts/admin-components/event-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/news-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/sports-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/chapters-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    
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
                
                // Reset form
                const form = document.getElementById('addNewsForm');
                if (form) {
                    form.reset();
                }
                
                // Reset file upload
                const fileStatus = document.getElementById('newsImageStatus');
                const deleteBtn = document.getElementById('deleteNewsImageBtn');
                const preview = document.getElementById('newsImagePreview');
                
                if (fileStatus) fileStatus.textContent = 'No file selected';
                if (deleteBtn) deleteBtn.style.display = 'none';
                if (preview) preview.style.display = 'none';
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
        

        
        // Cancel Edit button functionality
        document.addEventListener('DOMContentLoaded', function() {
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
        
        // Initialize when DOM loads
        document.addEventListener('DOMContentLoaded', function() {
            const addNewsBtn = document.getElementById('addNewsBtn');
            if (addNewsBtn) {
                addNewsBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openNewsModal();
                });
            }
            
            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeNewsModal();
                }
            });
        });
    </script>
    

    <script src="../scripts/admin-components/sponsorship-management.js?v=<?php echo time() . rand(1000, 9999); ?>"></script>
    <script src="../scripts/admin-components/photo-management.js"></script>
    <script src="../scripts/admin-components/video-management.js"></script>

    <!-- Direct sortable implementation -->
    <script>
        // Gallery Collections Sortable
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; padding: 12px 20px;
                background: ${type === 'success' ? '#10b981' : '#ef4444'};
                color: white; border-radius: 6px; z-index: 10000;
                font-family: 'Inter', sans-serif; font-size: 14px;
                animation: slideIn 0.3s ease;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
        
        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);

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
        
        // Profile functionality
        function initializeProfileTabs() {
            const tabs = document.querySelectorAll('.profile-tab');
            const tabContents = document.querySelectorAll('.profile-tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.dataset.tab;
                    
                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(tc => tc.classList.remove('active'));
                    
                    // Add active class to clicked tab and corresponding content
                    this.classList.add('active');
                    document.getElementById(targetTab + '-tab').classList.add('active');
                });
            });
        }

        function resetProfileForm() {
            const form = document.getElementById('profileInfoForm');
            if (form) {
                form.reset();
                // Reset to original values
                document.getElementById('profileFullName').value = 'Admin User';
                document.getElementById('profileEmail').value = 'admin@1234';
                document.getElementById('profilePhone').value = '+60 12-345-6789';
                document.getElementById('profilePosition').value = 'System Administrator';
                document.getElementById('profileBio').value = 'Dedicated administrator managing the Special Olympics Sarawak digital platform and supporting athletes across all programs.';
            }
        }

        function resetPasswordForm() {
            const form = document.getElementById('passwordChangeForm');
            if (form) {
                form.reset();
            }
        }

        // Initialize profile functionality when DOM loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeProfileTabs();
            
            // Profile form submission
            const profileForm = document.getElementById('profileInfoForm');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Update display info
                    const fullName = document.getElementById('profileFullName').value;
                    const position = document.getElementById('profilePosition').value;
                    
                    document.getElementById('profileDisplayName').textContent = fullName;
                    document.getElementById('profileDisplayPosition').textContent = position;
                    
                    showNotification('Profile updated successfully!', 'success');
                    
                    // Here you would typically send the data to the server
                    // const formData = new FormData(this);
                    // fetch('handler/profile_handler.php', { method: 'POST', body: formData });
                });
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
                    
                    showNotification('Password updated successfully!', 'success');
                    resetPasswordForm();
                    
                    // Here you would typically send the data to the server
                    // const formData = new FormData(this);
                    // fetch('handler/password_handler.php', { method: 'POST', body: formData });
                });
            }
        });
    </script>


</body>
</html>
              
 