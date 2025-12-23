<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Archiv PHP</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 600;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin-top: 10px;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .success {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error {
            background-color: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Create User Profile</h1>
        <div class="nav">
            <a href="index.php">Create Profile</a>
            <a href="view_profile.php">View Profiles</a>
        </div>
        
        <?php
        require_once 'User.php';
        
        $message = '';
        $error = '';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new User();
            
            // Basic validation
            if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
                $error = 'Username, email, and password are required!';
            } else {
                $user->username = htmlspecialchars($_POST['username']);
                $user->email = htmlspecialchars($_POST['email']);
                $user->password = $_POST['password'];
                $user->first_name = htmlspecialchars($_POST['first_name'] ?? '');
                $user->last_name = htmlspecialchars($_POST['last_name'] ?? '');
                $user->bio = htmlspecialchars($_POST['bio'] ?? '');
                $user->phone = htmlspecialchars($_POST['phone'] ?? '');
                $user->address = htmlspecialchars($_POST['address'] ?? '');
                $user->city = htmlspecialchars($_POST['city'] ?? '');
                $user->country = htmlspecialchars($_POST['country'] ?? '');
                $user->profile_picture = htmlspecialchars($_POST['profile_picture'] ?? '');
                $user->date_of_birth = $_POST['date_of_birth'] ?? null;
                
                try {
                    if($user->create()) {
                        $message = 'User profile created successfully!';
                    } else {
                        $error = 'Failed to create user profile.';
                    }
                } catch(Exception $e) {
                    $error = 'Error: ' . $e->getMessage();
                }
            }
        }
        ?>
        
        <?php if($message): ?>
            <div class="success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name">
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name">
            </div>
            
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone">
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address">
            </div>
            
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city">
            </div>
            
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" id="country" name="country">
            </div>
            
            <div class="form-group">
                <label for="profile_picture">Profile Picture URL</label>
                <input type="text" id="profile_picture" name="profile_picture">
            </div>
            
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio"></textarea>
            </div>
            
            <button type="submit" class="btn">Create Profile</button>
        </form>
    </div>
</body>
</html>
