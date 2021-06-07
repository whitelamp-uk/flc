<?php

namespace FundraisingLotteryCRM;

class CCCVerify {

    public static function ips ($ccc) {
        $ips = [];
        // FLC standards URL for JSON
        $flc = 'https://www.whitelamp.com/flc/json';
        $tmp = '/tmp/ccc.'.getmypid().'.tmp';
        exec ("wget -q -O $tmp $flc?$ccc");
        $records = json_decode (file_get_contents($tmp));
        foreach ($records as $record) {
            if ($record->ccc!=$ccc) {
                continue;
            }
            $txts = dns_get_record ($record->domain,DNS_TXT);
            foreach ($txts as $txt) {
                $match = [];
                preg_match ('<^\s*v=flc1\s+([A-z]+)\s(.*)$>',$txt['txt'],$match);
                if (strtoupper($match[1])!=$ccc) {
                    continue;
                }
                $hosts = explode (' ',trim($match[2]));
                foreach ($hosts as $h) {
                    if (!$h) {
                        continue;
                    }
                    $ips[] = gethostbyname ($h);
                }
            }
            break;
        }
        return $ips;
    }

}

