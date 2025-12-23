<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profiles - Archiv PHP</title>
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
            max-width: 1200px;
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
        .user-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .user-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background: #f9f9f9;
            transition: transform 0.2s;
        }
        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .user-card h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        .user-card p {
            color: #666;
            margin: 5px 0;
            font-size: 14px;
        }
        .user-card .username {
            font-weight: 600;
            color: #333;
        }
        .no-users {
            text-align: center;
            color: #999;
            padding: 40px;
            font-size: 18px;
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
            margin-top: 10px;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profiles</h1>
        <div class="nav">
            <a href="index.php">Create Profile</a>
            <a href="view_profile.php">View Profiles</a>
        </div>
        
        <?php
        require_once 'User.php';
        
        $user = new User();
        $users = $user->getAll();
        
        if(empty($users)) {
            echo '<div class="no-users">No users found. Create your first profile!</div>';
        } else {
            echo '<div class="user-grid">';
            foreach($users as $userData) {
                echo '<div class="user-card">';
                echo '<h3>' . htmlspecialchars($userData['first_name'] ?? '') . ' ' . htmlspecialchars($userData['last_name'] ?? '') . '</h3>';
                echo '<p class="username">@' . htmlspecialchars($userData['username']) . '</p>';
                echo '<p><strong>Email:</strong> ' . htmlspecialchars($userData['email']) . '</p>';
                if(!empty($userData['city'])) {
                    echo '<p><strong>Location:</strong> ' . htmlspecialchars($userData['city']);
                    if(!empty($userData['country'])) {
                        echo ', ' . htmlspecialchars($userData['country']);
                    }
                    echo '</p>';
                }
                echo '<a href="profile_detail.php?id=' . $userData['id'] . '" class="btn">View Details</a>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
