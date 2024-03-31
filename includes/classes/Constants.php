<?php
class Constants {
    // Error messages for form validation
    public const FIRST_NAME_CHARACTERS = "Your first name must be between 2 and 25 characters";
    public const LAST_NAME_CHARACTERS = "Your last name must be between 2 and 25 characters";
    public const USERNAME_CHARACTERS = "Your username must be between 2 and 25 characters";
    public const USERNAME_TAKEN = "Username already in use";
    public const EMAILS_DONT_MATCH = "Your emails don't match";
    public const EMAIL_INVALID = "Invalid email";
    public const EMAIL_TAKEN = "Email already in use";
    public const PASSWORDS_DONT_MATCH = "Passwords don't match";
    public const PASSWORD_LENGTH = "Your password must be between 5 and 25 characters";
    public const LOGIN_FAILED = "Your username or password was incorrect";
    public const PASSWORD_INCORRECT = "Your old password is incorrect";
}
?>
