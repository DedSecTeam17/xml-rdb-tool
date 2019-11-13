<?php


    class  Message
    {


        static function alertMessage($title, $message)
        {

            return '
            
              <span class="new badge" data-badge-caption="custom caption">
              ' . $message . '
</span>

            
            
            
            ';

        }


    }


?>