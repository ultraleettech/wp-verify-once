# VerifyOnce
VerifyOnce verification service integration library.

## Usage

Add the library to your project via Composer:

```
composer require ultraleet/verify-once
```

Initialize the library by instantiating the core class:

```php
$verifyOnce = new \Ultraleet\VerifyOnce\VerifyOnce([
    'username' => '', // Integrator username
    'password' => '', // Integrator password
]);
```

To initiate a verification transaction, do the following:

```php
$response = $verifyOnce->initiate();
```

Response will be an object containing 'transactionId' and 'url' properties. You should store the transaction ID along with user info and redirect the user to the given URL for the verification process.

Once the verification is completed, VerifyOnce posts a JWT signed payload containing verification info to your callback URL. To verify the payload, you can use the `verify` method of the library:

```php
$body = file_get_contents('php://input');
$info = $verifyOnce->verify($body);
```

Make sure to catch any exceptions that indicate unsuccessful payload verification.

`$info` will contain verification information. You can get the transaction ID to compare against the value you stored previously to find the user doing the verification from `$info->transaction->id`.

Depending on whether you want to verify user's identity, address, or both, you will need to check `$info->identityVerification` and/or `$info->addressVerification`. If either of them is empty, then it means it has not been successfully verified.

Next, you will want to check verification status, which is the `status` property of either of the above objects. It can contain the following values:
```
  UNINITIATED
  INITIATED
  PENDING
  VERIFIED
  FAILED
  LOCKED
```
These should be pretty self-explanatory.

If the status is `VERIFIED`, you can go ahead and check the values of whatever fields you need in order to confirm that you have the correct user/address.
