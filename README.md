# **Laravel Social Login Package**  

## **Installation Guide**  

### **1️⃣ Install the Package via Composer**  
Run the following command to install the package:

```sh
composer require adeelmemon/sociallogin:dev-main
```

### **2️⃣ Run Database Migrations**  
Your package requires a `users` table with additional fields like `provider`, `provider_id`, `avatar`, etc.

Run the following command to update the database:

```sh
php artisan migrate
```

### **3️⃣ Publish Configuration File**  
To publish the package configuration file, run:

```sh
php artisan vendor:publish --tag=config
```

### **4️⃣ Install Social Login in the User Model**  
Run the following command to automatically update the `User` model with the required `HasSocialLogin` trait and fillable properties:

```sh
php artisan sociallogin:install
```

## **User Model Example**

Here is how the `User.php` model should look:

![User Model]((https://github.com/adeelmemon123/sociallogin/blob/c055184d9dafbcc09e44c8ed011426742c59ee89/User.png?raw=true))

## **Usage Guide**  

### **Adding Social Login Buttons in Blade View**  
Place the following code inside your Blade template to allow users to log in via Google, Facebook, or GitHub:

```html
<a href="{{ route('social', 'google') }}" class="social-button btn-danger mb-2">
    <i class="fab fa-google"></i> Login with Google
</a>
<a href="{{ route('social', 'facebook') }}" class="social-button btn-primary mb-2">
    <i class="fab fa-facebook-f"></i> Login with Facebook
</a>
<a href="{{ route('social', 'github') }}" class="social-button btn-dark mb-2">
    <i class="fab fa-github"></i> Login with GitHub
</a>
```

### **Environment Configuration**  
Add the following environment variables in your `.env` file:

```ini
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/oauth/google/callback

GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT_URI=http://127.0.0.1:8000/auth/oauth/github/callback

FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret
FACEBOOK_REDIRECT_URI=http://127.0.0.1:8000/auth/oauth/facebook/callback
```

### **Final Steps**  
- Ensure your `User` model is updated with `HasSocialLogin` and proper `$fillable` properties.
- Make sure you have correctly configured your Google, GitHub, and Facebook apps for OAuth authentication.
- Test the login routes to verify that authentication works as expected.

Now your Laravel Social Login package is ready to use! 🚀

