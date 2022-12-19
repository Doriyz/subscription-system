

<?php
// include this file in the pages you want to add the icon
// include 'subscription-system/pages/icon.php';
echo'
<style>
    .icon{
        width: 35px;
        height: 35px;
        margin: 10px 10px;
        text-decoration: none;
        font-size: large;
        display: inline-block;
    }
    .icon:hover{
        text-decoration: none;
    }
</style>


<div>
    <!-- add a icon to jump to homepage -->
    <a href="javascript:history.back()" title="return back"><img src="/subscription-system/images/return.png" class="icon"></img></a>
    <a href="/subscription-system/pages/index.php" title="jump to home page"><img src="/subscription-system/images/homeicon.png" class="icon"></img></a>
</div>
'

?>


