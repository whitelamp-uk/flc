<?php


require __DIR__.'/class/FundraisingLotteryCRM/CCCVerify.class.php';

// Find valid IP addresses for sourcing CRM IDs prefixed with these CCCs
$cccs = ['BB','OBB','PBB'];

foreach ($cccs as $ccc) {
    echo "$ccc => ";
    print_r (\FundraisingLotteryCRM\CCCVerify::ips($ccc));
    // Compare these with the incoming data REMOTE_ADDR
}

