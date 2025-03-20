<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up</title>
</head>
<body>
    <form method="post" action="/mindStone/app/controllers/UserController.php" id="formSignup">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>
        <label for="lastName">Last name</label>
        <input type="text" name="lastName" id="lastName" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="phone">Phone</label>
        <input type="phone" name="phone" id="phone" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <button type="submit" name="signup">Sign Up</button>
    </form>
</body>
</html>