<?php

return array(
    // User
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    //Site
    'site/sort/([1-6])' => 'site/sort/$1', // sorting
    'page-([0-9]+)' => 'site/index/$1', // actionIndex in SiteController   
    'create' => 'site/create', // actionCreate в SiteController
    'edit/([0-9]+)' => 'site/edit/$1',
    // Main page
    'index.php' => 'site/index', // actionIndex в SiteController
    '' => 'site/index', // actionIndex в SiteController
);
