# **Laravel Social Login Package**

Easily integrate social login functionality into your Laravel application using this package.

## **Installation Guide**

### **1️⃣ Install the Package via Composer**

Run the following command to install the package:

```sh
composer require adeelmemon/sociallogin:dev-main
```

### **2️⃣ Run Database Migrations**

Your package requires additional fields like `provider`, `provider_id`, and `avatar` in the `users` table.\
Run the migrations to update your database:

```sh
php artisan migrate
```

### **3️⃣ Publish Configuration**

To publish the package configuration files, use the following command:

```sh
php artisan vendor:publish --tag=config
```

### **4️⃣ Install the Package**

Run the installer to update your `User` model automatically:

```sh
php artisan sociallogin:install
```

## **Usage Guide**

### **Redirect Users to Provider**

Use the following route to redirect users to their selected OAuth provider:

```php
Route::get('/auth/{provider}', function ($provider) {
    return \App\Models\User::redirectToProvider($provider);
})->name('social.redirect');
```

### **Handle Provider Callback**

Handle the provider callback and authenticate the user:

```php
Route::get('/auth/{provider}/callback', function ($provider) {
    return \App\Models\User::handleProviderCallback($provider);
})->name('social.callback');
```

## **Supported Providers**

✅ Google\
✅ GitHub\
✅ More coming soon...

## **License**

This package is open-source and free to use under the MIT License.

---

🚀 \*\*Developed b[y \*\*](https://github.com/adeelmemon03000)**[Adeel M](https://github.com/adeelmemon03000)****\*\*\*\*****[emon](https://github.com/adeelmemon03000)**

give me these all in the github readfile format

