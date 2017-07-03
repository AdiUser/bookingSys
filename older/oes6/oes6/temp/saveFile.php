<?php
echo("<h3> Symmetric Encryption </h3>"); 
$key_value = "123@123"; 
$plain_text = "PLAINTEXT"; 
$encrypted_text = mcrypt_ecb(MCRYPT_DES, $key_value, $plain_text, MCRYPT_ENCRYPT); 
echo ("<p><b> Text after encryption : </b>"); 
echo ( $encrypted_text ); 
$decrypted_text = mcrypt_ecb(MCRYPT_DES, $key_value, $encrypted_text, MCRYPT_DECRYPT); 
echo ("<p><b> Text after decryption : </b>"); 
echo ( $decrypted_text ); 
?> 