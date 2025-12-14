<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details - Archiv PHP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .nav {
            text-align: center;
            margin-bottom: 20px;
        }
        .nav a {
            color: #667eea;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 600;
        }
        .nav a:hover {
            text-decoration: underline;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid #667eea;
        }
        .profile-name {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }
        .profile-username {
            color: #667eea;
            font-size: 18px;
        }
        .profile-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .detail-item {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .detail-item.full-width {
            grid-column: 1 / -1;
        }
        .detail-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }
        .detail-value {
            color: #333;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .error {
            background-color: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="index.php">Create Profile</a>
            <a href="view_profile.php">View Profiles</a>
        </div>
        
        <?php
        require_once 'User.php';
        
        if(!isset($_GET['id']) || empty($_GET['id'])) {
            echo '<div class="error">User ID not provided!</div>';
            echo '<a href="view_profile.php" class="btn">Back to Profiles</a>';
            exit;
        }
        
        $user = new User();
        if($user->read($_GET['id'])) {
        ?>
            <div class="profile-header">
                <?php if(!empty($user->profile_picture)): ?>
                    <img src="<?php echo htmlspecialchars($user->profile_picture); ?>" alt="Profile Picture" class="profile-picture">
                <?php else: ?>
                    <img src="https://via.placeholder.com/150?text=No+Image" alt="Profile Picture" class="profile-picture">
                <?php endif; ?>
                <h1 class="profile-name">
                    <?php echo htmlspecialchars($user->first_name ?? '') . ' ' . htmlspecialchars($user->last_name ?? ''); ?>
                </h1>
                <div class="profile-username">@<?php echo htmlspecialchars($user->username); ?></div>
            </div>
            
            <div class="profile-details">
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user->email); ?></div>
                </div>
                
                <?php if(!empty($user->phone)): ?>
                <div class="detail-item">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user->phone); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($user->date_of_birth)): ?>
                <div class="detail-item">
                    <div class="detail-label">Date of Birth</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user->date_of_birth); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($user->city)): ?>
                <div class="detail-item">
                    <div class="detail-label">City</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user->city); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($user->country)): ?>
                <div class="detail-item">
                    <div class="detail-label">Country</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user->country); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($user->address)): ?>
                <div class="detail-item full-width">
                    <div class="detail-label">Address</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user->address); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($user->bio)): ?>
                <div class="detail-item full-width">
                    <div class="detail-label">Bio</div>
                    <div class="detail-value"><?php echo nl2br(htmlspecialchars($user->bio)); ?></div>
                </div>
                <?php endif; ?>
            </div>
            
            <a href="view_profile.php" class="btn">Back to Profiles</a>
        <?php
        } else {
            echo '<div class="error">User not found!</div>';
            echo '<a href="view_profile.php" class="btn">Back to Profiles</a>';
        }
        ?>
    </div>
</body>
</html>
