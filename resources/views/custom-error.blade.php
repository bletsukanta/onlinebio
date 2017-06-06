<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<h2>This is custom error page.</h2>';
echo '<h2>'. Session::get('errmsg').' </h2>';

