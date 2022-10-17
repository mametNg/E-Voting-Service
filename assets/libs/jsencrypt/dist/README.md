# PHP-form-RSA-encryption
Encrypt transmitted data with JavaScript with RSA keys, and decrypt on server side. Avoiding man-in-the-middle attack on HTTP network.

# How it works?
  0. Server send server time to JS.
  1. JS calculate time difference since page load and form submit.
  2. Add this time difference to server time.
  3. Encrypt text field with UNIX time stamp to the end with public RSA key.
  4. Server decrypt string with private RSA key.
  5. PHP compare string time with actual server time.
  6. If time is less than 30 seconds, it is ok; If more than 30 seconds, something strange is happening.
