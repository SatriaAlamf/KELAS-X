<?php
include 'functions.php';

// Initialize error array
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_or_email = trim($_POST['username_or_email']);
    $password = trim($_POST['password']);
    
    // Validate input
    if (empty($username_or_email)) {
        $errors['username_or_email'] = 'Username or email is required';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    // Attempt login if no validation errors
    if (empty($errors)) {
        if (login($username_or_email, $password)) {
            header('Location: index.php');
            exit();
        } else {
            $errors['login'] = 'Invalid credentials. Please check your username/email and password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-300 p-4">
    <!-- Back Button -->
    <a href="index.php" class="fixed top-4 left-4 text-gray-600 hover:text-blue-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>Back to Home
    </a>
    

    <div class="relative w-full max-w-sm bg-white p-8 rounded-lg shadow-lg">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto">
                <i class="fas fa-coffee text-white text-2xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-700 mt-3">Welcome Back</h2>
        </div>

        <?php if (!empty($errors['login'])): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?php echo $errors['login']; ?>
        </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4" novalidate>
            <div>
                <div class="relative">
                    <input type="text" 
                           name="username_or_email" 
                           value="<?php echo isset($_POST['username_or_email']) ? htmlspecialchars($_POST['username_or_email']) : ''; ?>"
                           class="w-full p-3 border <?php echo isset($errors['username_or_email']) ? 'border-red-500' : 'border-gray-300'; ?> rounded focus:ring-2 focus:ring-blue-400" 
                           placeholder="Username or Email">
                    <i class="fas fa-user absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                <?php if (isset($errors['username_or_email'])): ?>
                <p class="mt-1 text-sm text-red-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    <?php echo $errors['username_or_email']; ?>
                </p>
                <?php endif; ?>
            </div>

            <div>
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="w-full p-3 border <?php echo isset($errors['password']) ? 'border-red-500' : 'border-gray-300'; ?> rounded focus:ring-2 focus:ring-blue-400" 
                           placeholder="Password">
                    <button type="button" 
                            onclick="togglePassword()" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                <?php if (isset($errors['password'])): ?>
                <p class="mt-1 text-sm text-red-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    <?php echo $errors['password']; ?>
                </p>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-gray-600">
                    <input type="checkbox" class="w-4 h-4 mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    Remember me
                </label>
                <a href="#" class="text-blue-600 hover:text-blue-700">Forgot Password?</a>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded font-semibold transition-colors duration-300">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign In
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            New here? <a href="register.php" class="text-blue-500 hover:underline">Create Account</a>
        </p>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            password.type = password.type === 'password' ? 'text' : 'password';
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>