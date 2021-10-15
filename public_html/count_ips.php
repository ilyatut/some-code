<?php

/**
 * File lines iterator
 *
 * @param $filename
 * @return Generator
 */
function readFileLines(string $filename)
{
    $f = fopen($filename, 'rb');
    try {
        while ($line = fgets($f)) {
            yield $line;
        }
    } finally {
        fclose($f);
    }
}

/**
 * Finds the most frequent IP in a file
 *
 * @param $fileName
 * @return string
 * @throws Exception
 */
function getMostFrequentIp(string $fileName)
{
    # check if the file exists
    if (!file_exists($fileName)) {
        throw new RuntimeException('File with IPs not found');
    }

    # read the file line by line
    $uniqueIpsList = [];
    foreach (readFileLines($fileName) as $line) {

        # get IP from the string
        [ , , $ipString ] = explode(' ', $line);

        # convert IP string to a number for memory efficiency
        $ipLong = ip2long($ipString);
        if ($ipLong) {
            $uniqueIpsList[ $ipLong ]++;
        }
    }

    # sort the list
    arsort($uniqueIpsList);

    # take the first element
    $firstKey = array_key_first($uniqueIpsList);

    # convert the IP back to the string
    return long2ip($firstKey);
}

/**
 * Finds the most frequent URLs in a file for a given IP
 *
 * @param string $fileName
 * @param string $ip
 * @param int $top
 * @return array
 */
function getMostFrequentUrls(string $fileName, string $ip, int $top = 10)
{
    # check if the file exists
    if (!file_exists($fileName)) {
        throw new RuntimeException('File with IPs not found');
    }

    # read the file line by line
    $uniqueUrlsList = [];
    foreach (readFileLines($fileName) as $line) {

        # get IP and URL from the string
        [ , , $ipString, $urlString ] = explode(' ', $line);

        # convert IP string to a number for memory efficiency
        if ($ipString === $ip) {
            $uniqueUrlsList[ $urlString ]++;
        }
    }

    # sort the list
    arsort($uniqueUrlsList);

    # get the top elements
    if ($top) {
        $uniqueUrlsList = array_slice($uniqueUrlsList, 0, $top);
    }

    # convert the IP back to the string
    return $uniqueUrlsList;
}


try {
    echo 'Most frequent IP: '.getMostFrequentIp('ips.txt') . '<br>';
    echo 'Most frequent URLs: '.var_export(getMostFrequentUrls('ips.txt', '100.0.0.3', 3), true) . '<br>';
}
catch (Exception $e) {
    echo $e->getMessage();
}

/*
    Results:
    ---------------------------------------------------------------------------------
    Most frequent IP: 100.0.0.3
    Most frequent URLs: array ( 'URL5 ' => 7812, 'URL2 ' => 5208, 'URL6 ' => 2604, )
*/
