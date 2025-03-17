<?php
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user = getUserById($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'full_name' => $_POST['full_name']
    ];
    
    // Handle profile picture update
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "assets/images/profiles/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_extension = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
        $profile_picture = "profile_" . time() . "." . $file_extension;
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_dir . $profile_picture);
        $data['profile_picture'] = $profile_picture;
    }
    
    if (updateUserProfile($_SESSION['user_id'], $data)) {
        $success = "Profile updated successfully!";
        $user = getUserById($_SESSION['user_id']); // Refresh user data
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>My Profile</title>
</head>
<body class="bg-gradient-to-r from-blue-100 to-purple-100 min-h-screen">
    <!-- Include your navbar here -->
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="relative inline-block">
                    <img src="<?php echo $user ['profile_picture'] ? 'assets/images/profiles/' . $user['profile_picture'] : 'assets/images/default-avatar.png'; ?>" 
                         alt="Profile Picture"
                         class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover">
                    <label for="profile_picture" 
                           class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-blue-600">
                        <i class="fas fa-camera"></i>
                    </label>
                </div>
                <h2 class="text-3xl font-bold mt-4 text-gray-800"><?php echo htmlspecialchars($user['full_name']); ?></h2>
                <p class="text-gray-500"><?php echo htmlspecialchars($user['role']); ?></p>
            </div>

            <?php if (isset($success)): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <?php echo $success; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <?php echo $error; ?>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label for="username" class="text-sm font-medium text-gray-600 block mb-2">Username</label>
                        <input type="text" 
                               id="username"
                               name="username" 
                               value="<?php echo htmlspecialchars($user['username']); ?>"
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="relative">
                        <label for="email" class="text-sm font-medium text-gray-600 block mb-2">Email</label>
                        <input type="email" 
                               id="email"
                               name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>"
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="relative md:col-span-2">
                        <label for="full_name" class="text-sm font-medium text-gray-600 block mb-2">Full Name</label>
                        <input type="text" 
                               id="full_name"
                               name="full_name" 
                               value="<?php echo htmlspecialchars($user['full_name']); ?>"
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</body>
</html>x