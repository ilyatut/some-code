<?php

/**
 * @param string $inputString
 * @return string
 */
function formatPhone(string $inputString): string
{
    # delete all non-digits
    $inputString = preg_replace('|[\D]+|', '', $inputString);

    # add 7 if it's absent
    if ($inputString[0] !== '7') {
        $inputString = '7'.$inputString;
    }

    # trim the string
    $inputString = substr($inputString, 0, 11);

    # check the result length
    #
    # error handling here depends on additional requirements:
    # we could throw an exeption or keep an error message
    # to show it back to user, or leave the input untouched
    if (strlen($inputString) < 11) {
        return '-- not enough digits --';
    }

    # make the final string formatting
    return preg_replace('|(\d)(\d)(\d{2})(\d{3})(\d{4})|', '+$1-$2-$3-$4-$5', $inputString);
}


// Quick test
$numbers = [
    '1223334444',
    '(1223)334444',
    '+71223334444',
    '71223-33-44-44',
    '+7-12233-34-444',
    '(1223) 33-4444',
    '122(3334)444',
    '7 1 223 33 44 44',
    '122 3334 444',
    '1234',
];

echo '<table>';
foreach ($numbers as $number)
{
    if ($number) {
        echo '
            <tr>
                <td>'.$number.'</td>
                <td>'.formatPhone($number).'</td>
            </tr>
        ';
    }
}
echo '</table>';


/*
    Results:
    ------------------------------------------------
    1223334444	        +7-1-22-333-4444
    (1223)334444	    +7-1-22-333-4444
    +71223334444	    +7-1-22-333-4444
    71223-33-44-44	    +7-1-22-333-4444
    +7-12233-34-444	    +7-1-22-333-4444
    (1223) 33-4444	    +7-1-22-333-4444
    122(3334)444	    +7-1-22-333-4444
    7 1 223 33 44 44	+7-1-22-333-4444
    122 3334 444	    +7-1-22-333-4444
    1234	            -- not enough digits --
*/
