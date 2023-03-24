<?php

   /*
      clean_input($content)

      Given a string of text, use the str_replace function to find and replace any instance of certain characters and replace them
      with their entity counterparts. Returns the cleaned up version of the string with entities.

      @param $content is a string

      ----------------------deprecated by htmlspecialchar function
   */

   function clean_input($content) {

      $patterns = array();
      $patterns[0] = '/&/';
      $patterns[1] = '/</';
      $patterns[2] = '/>/';
      $patterns[3] = "/'/";
      $patterns[4] = '/"/';

      $replacements = array();
      $replacements[0] = '&amp;';
      $replacements[1] = '&lt;';
      $replacements[2] = '&gt;';
      $replacements[3] = '&apos;';
      $replacements[4] = '&quot;';

      $content = preg_replace($patterns, $replacements, $content);

      return $content;
   }

   /*

   clean_name_input($name);

   Given a string, verify that it is in proper user name form. i.e., made up of alphanumeric chars and _'s, but
   not allowing the name to begin with a number or end in an _. Returns true if the name fits the constraints, false otherwise.

   @param $name is a string with the name that is being tested

   */

   function clean_name_input($name) {

      return preg_match("/^[A-Za-z][\w]{0,38}[A-Za-z0-9]/", $name);
   }

?>