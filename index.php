<?php
        
       $_SESSION['card_no'] = '4111111111111111';

       
        $sess_data = $_SESSION;
       
        array_walk_recursive($sess_data, function(&$value, $index){
           if (in_array($index,array('card_no','cvv','ccv','cv2','cvc','card_cvv','card_ccv')))
             {  
                 $value =  mask_data($value);
             }
            
        });
            print_r($sess_data);
            
            
        function mask_data($str)
        {
            // Strip 3/4 digit cvv's (Amex/Visa/Mastercard)       
            $new_str = preg_replace_callback('/(^|>|=|"|\'|\s)(\d{3,4})(\'|"|<|&|$)/m', 'obfuscate', $str);
            
            // Strip 13,14,15,16 digit card number (Visa/Mastercard/Discover/Diner's Club/Carte Blanche/AMEX)
            $new_str = preg_replace_callback('/(^\d{6}|[^0-9][2-9][0-9]{5})(\d{3,9})(\d{4}[^0-9]|\d{4}$)/', 'obfuscate', $str);
            
            return $new_str;
        }
        
        function obfuscate($matches) {
            return (preg_match('/[^0-9]20[0-1][0-9]/', $matches[2])) ? $matches[0] : $matches[1] . str_repeat('*', strlen($matches[2])) . $matches[3];
         }
         
?>