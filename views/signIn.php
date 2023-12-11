<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn Form</title>
</head>
<body>
    <form action="../controllers/filter_input.php" method="POST">
        <input type="text" name="FirstName" placeholder="Enter your FirstName"><br>
        <input type="text" name="LastName" placeholder="Enter your LastName"><br>
        <input type="text" name="email" placeholder="Enter your Email Adress"><br>
        <input type="password" name="password" placeholder="Enter your password"><br>
        <input type="submit" value="submit" name="SubmitSignInForm">
    </form>
</body>
</html>