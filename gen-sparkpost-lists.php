#!/usr/bin/env php
<?php
// Generate random suppressions CSV file
//Copyright  2016 SparkPost

//Licensed under the Apache License, Version 2.0 (the "License");
//you may not use this file except in compliance with the License.
//You may obtain a copy of the License at
//
//    http://www.apache.org/licenses/LICENSE-2.0
//
//Unless required by applicable law or agreed to in writing, software
//distributed under the License is distributed on an "AS IS" BASIS,
//WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//See the License for the specific language governing permissions and
//limitations under the License.

//
// Author: Steve Tuck (August 2016)
//
$countDefault = 10;                             // Default number of suppressions
$domainDefault = "sedemo.sink.sparkpostmail.com";      // Safe default

function printHelp()
{
    global $argv, $countDefault, $domainDefault;

    $progName = $argv[0];
    $shortProgName = basename($progName);
    echo "\nNAME\n";
    echo "   " . $progName . "\n";
    echo "   Generate a random, SparkPost-compatible Recipient- or Suppression-List for .CSV import.\n\n";
    echo "SYNOPSIS\n";
    echo "  ./" . $shortProgName . " recip|supp|help [count [domain]]\n\n";
    echo "OPTIONAL PARAMETERS\n";
    echo "    count = number of records to generate (default " . $countDefault . ")\n";
    echo "    domain = recipient domain to generate records for (default " . $domainDefault . ")\n";
}

function randomRecip($domain, $digits, &$ensureUnique)
{
    do {
        $localpartnum = rand(0, pow(10, $digits)-1);
    } while(!empty($ensureUnique[$localpartnum]) );     // If already had this number, then pick another one

    $ensureUnique[$localpartnum] = true;
                                                        // Pad the number out to a fixed length of digits
    return( "anon" . str_pad($localpartnum, $digits, "0", STR_PAD_LEFT) . "@" . $domain);
}

function randomMeta()
{
    return('{"foo": "bar"}');
}

function randomSubData()
{
    return('{"member": "Platinum", "region": "US"}');
}

function randomName()
{
    return('Fred Bloggs');
}

// -----------------------------------------------------------------------------------------
// Main code
// -----------------------------------------------------------------------------------------

$count = $countDefault;
$domain = $domainDefault;

// Check argument count, otherwise accessing beyond array bounds throws an error in PHP 5.5+
if($argc >= 2) {
    switch($argv[1]) {
       case "supp" : {
            $listType = "supp";
            break;
        }
       case "recip" : {
            $listType = "recip";
            break;
        }
       default:
       case "help" : {
                printHelp();
                exit(0);
       }
    }
}
else {
    printHelp();
    exit(0);
}

// Check optional parameters
if($argc >= 3) {
        $count = $argv[2];
}

if($argc >=4 ) {
        $domain = $argv[3];
}

$uniqFlags = array();                       // Mark numbers as we use them, to ensure uniqueness .. this does use a lot of memory
$numDigits = 8;                             // Number of random local-part digits to generate (max)

if($count > 1000000) {
    echo "Too big for a single table";
    exit(1);
}

switch($listType) {
    case "supp": {
        $headerRow = [
            "recipient",
            "transactional",
            "non_transactional",
            "description",
            "subaccount_id"
        ];
        $handle = fopen("php://output", "w");
        fputcsv($handle, $headerRow);

        // Generate the file on stdout
        for ($i = 1; $i <= $count; $i++) {
            $dataRow[0] = randomRecip($domain, $numDigits, $uniqFlags);
            $dataRow[1] = "true";                   // Transactional flag - Change this as needed
            $dataRow[2] = "true";                   // Non-Transactional flag - Change this as needed
            $dataRow[3] = "Example data import";
            $dataRow[4] = "0";                      // 0 = Master account
            fputcsv($handle, $dataRow);
        }
        fclose($handle);
        break;
    }
    case "recip": {
        $headerRow = [
            "email",
            "name",
            "return_path",
            "metadata",
            "substitution_data",
            "tags"
        ];
        $handle = fopen("php://output", "w");
        fputcsv($handle, $headerRow);

        // Generate the file on stdout
        for ($i = 1; $i <= $count; $i++) {
            $dataRow[0] = randomRecip($domain, $numDigits, $uniqFlags);
            $dataRow[1] = randomName();
            $dataRow[2] = "bounce@" . $domain;      // simple fixed value for testing
            $dataRow[3] = randomMeta();
            $dataRow[4] = randomSubData();
            $dataRow[5] = "";                       // Tags not currently filled
            fputcsv($handle, $dataRow);
        }
        fclose($handle);
        break;
    }
    default:
        echo "Invalid option - stopping.\n";
        break;
}
exit(0);