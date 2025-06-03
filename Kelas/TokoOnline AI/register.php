<?php
include 'functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    
    // Validate inputs
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }
    
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // Handle profile picture
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($_FILES['profile_picture']['type'], $allowed_types)) {
            $errors['profile_picture'] = 'Only JPG, JPEG & PNG files are allowed';
        } else {
            $target_dir = "assets/images/profiles/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $file_extension = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
            $profile_picture = "profile_" . time() . "." . $file_extension;
            move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_dir . $profile_picture);
        }
    }

    if (empty($errors)) {
        if (register($username, $password, $email, $full_name, $profile_picture)) {
            header('Location: login.php?registered=true');
            exit();
        } else {
            $errors['register'] = "Registration failed. Username or email may already be taken.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center p-4">
    <!-- Back Button -->
    <a href="index.php" class="fixed top-4 left-4 text-gray-600 hover:text-blue-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>Back to Home
    </a>

    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-600 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                <p class="text-gray-500 text-sm mt-1">Join our coffee community</p>
            </div>

            <!-- Error Message -->
            <?php if (isset($errors['register'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-600 text-sm p-3 mb-4 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i><?php echo $errors['register']; ?>
            </div>
            <?php endif; ?>

            <!-- Register Form -->
            <form method="POST" enctype="multipart/form-data" class="space-y-5">
                <!-- Profile Picture -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <input type="file" 
                           name="profile_picture" 
                           accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                  file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <?php if (isset($errors['profile_picture'])): ?>
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-info-circle mr-1"></i><?php echo $errors['profile_picture']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Username Input -->
                <div>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" 
                               name="username"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                               class="w-full pl-10 pr-4 py-2 border <?php echo isset($errors['username']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Username">
                    </div>
                    <?php if (isset($errors['username'])): ?>
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-info-circle mr-1"></i><?php echo $errors['username']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Full Name Input -->
                <div>
                    <div class="relative">
                        <i class="fas fa-user-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" 
                               name="full_name"
                               value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>"
                               class="w-full pl-10 pr-4 py-2 border <?php echo isset($errors['full_name']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Full Name">
                    </div>
                </div>

                <!-- Email Input -->
                <div>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" 
                               name="email"
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               class="w-full pl-10 pr-4 py-2 border <?php echo isset($errors['email']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Email">
                    </div>
                    <?php if (isset($errors['email'])): ?>
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-info-circle mr-1"></i><?php echo $errors['email']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Password Input -->
                <div>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" 
                               name="password"
                               id="password"
                               class="w-full pl-10 pr-10 py-2 border <?php echo isset($errors['password']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Password">
                        <button type="button" 
                                onclick="togglePassword('password', 'toggleIcon')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-info-circle mr-1"></i><?php echo $errors['password']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" 
                               name="confirm_password"
                               id="confirm_password"
                               class="w-full pl-10 pr-10 py-2 border <?php echo isset($errors['confirm_password']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Confirm Password">
                        <button type="button" 
                                onclick="togglePassword('confirm_password', 'toggleIconConfirm')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIconConfirm"></i>
                        </button>
                    </div>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-info-circle mr-1"></i><?php echo $errors['confirm_password']; ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition-colors">
                    Create Account
                </button>

                <p class="text-center text-gray-600 text-sm">
                    Already have an account? 
                    <a href="login.php" class="text-blue-600 hover:text-blue-700 font-medium">
                        Sign In
                    </a>
                </p>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>