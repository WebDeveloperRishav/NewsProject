<?php
function printarray($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
};


function changepage($page)
{
    header("Location: http://localhost/phpcrud/news-template/admin/{$page}");
};
