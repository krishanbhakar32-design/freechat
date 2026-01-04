<?php
// Get connection string from Render Environment
$db_url = getenv('DATABASE_URL');

try {
    // Connect to Neon PostgreSQL
    $pdo = new PDO($db_url);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch staff sorted by Rank Level
    $stmt = $pdo->query("SELECT * FROM staff ORDER BY rank_level DESC, username ASC");
    $staff_members = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = "Database Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ACN Style Chat Sidebar</title>
    <style>
        body { background: #0b0b0b; color: #eee; font-family: 'Segoe UI', Arial, sans-serif; margin: 0; }
        
        /* Sidebar container inspired by adultchat.net */
        .sidebar {
            width: 260px;
            background: #141414;
            height: 100vh;
            border-left: 1px solid #252525;
            position: fixed;
            right: 0;
            padding: 15px;
        }

        .section-title {
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            border-bottom: 1px solid #222;
            padding-bottom: 5px;
        }

        .user-row {
            display: flex;
            align-items: center;
            padding: 6px 0;
            cursor: pointer;
            transition: 0.2s;
        }

        .user-row:hover { background: #1c1c1c; }

        .rank-icon {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            border-radius: 3px;
        }

        .username {
            font-size: 14px;
            font-weight: 600;
        }

        .rank-label {
            font-size: 10px;
            margin-left: auto;
            opacity: 0.6;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="section-title">Management</div>
    
    <?php if (isset($error)): ?>
        <p style="color: red; font-size: 12px;"><?php echo $error; ?></p>
    <?php else: ?>
        <?php foreach ($staff_members as $user): ?>
            <div class="user-row">
                <img src="<?php echo $user['icon_url']; ?>" class="rank-icon" alt="">
                <span class="username" style="color: <?php echo $user['rank_color']; ?>;">
                    <?php echo htmlspecialchars($user['username']); ?>
                </span>
                <span class="rank-label"><?php echo $user['rank_name']; ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
