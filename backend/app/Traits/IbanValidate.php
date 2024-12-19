<?php

namespace App\Traits;

use App\Enums\IbanCountryLength;
use RuntimeException;

trait IbanValidate
{
    // List of IBAN lengths by country
    protected array $countryLengths = [
        'AL' => 28, 'AD' => 24, 'AT' => 20, 'AZ' => 28, 'BH' => 22,
        'BE' => 16, 'BA' => 20, 'BG' => 22, 'HR' => 21, 'CY' => 28,
        'CZ' => 24, 'DK' => 18, 'DO' => 28, 'EE' => 20, 'FI' => 18,
        'FR' => 27, 'GE' => 22, 'DE' => 22, 'GR' => 27, 'GL' => 18,
        'GT' => 28, 'HU' => 28, 'IS' => 26, 'IE' => 22, 'IL' => 23,
        'IT' => 27, 'KZ' => 20, 'KW' => 30, 'LV' => 21, 'LB' => 28,
        'LI' => 21, 'LT' => 20, 'LU' => 20, 'MT' => 31, 'MR' => 27,
        'MU' => 30, 'MD' => 24, 'MC' => 27, 'ME' => 22, 'NL' => 18,
        'NO' => 15, 'PK' => 24, 'PL' => 28, 'PT' => 25, 'QA' => 29,
        'RO' => 24, 'SM' => 27, 'SA' => 24, 'RS' => 22, 'SK' => 24,
        'SI' => 19, 'ES' => 24, 'SD' => 18, 'SE' => 24, 'CH' => 21,
        'TN' => 24, 'TR' => 26, 'AE' => 23, 'GB' => 22, 'VG' => 24
    ];

    /**
     * Validate the given IBAN.
     *
     * @param string $iban
     * @return bool
     */
    public function isValidIban(string $iban): bool
    {
        $iban = str_replace(' ', '', strtoupper($iban));

        if (!preg_match('/^[A-Z]{2}\d{2}[A-Z0-9]{1,30}$/', $iban)) {
            return false;
        }
        $countryCode = substr($iban, 0, 2);

        // check if the country code and length are valid
        if (!array_key_exists($countryCode, $this->countryLengths) ||
            strlen($iban) !== $this->countryLengths[$countryCode]) {
            return false;
        }

        // rearrange iban
        $rearrangedIban = substr($iban, 4) . substr($iban, 0, 4);

        //  Convert letters to numbers (A=10, B=11, ..., Z=35)
        $numericIban = '';
        for ($i = 0; $i < strlen($rearrangedIban); $i++) {
            $char = $rearrangedIban[$i];
            if (ctype_alpha($char)) {
                $numericIban .= (ord(strtoupper($char)) - 55);
            } else {
                $numericIban .= $char;
            }
        }

        return (int) bcmod($numericIban, '97') === 1;
    }

    /**
     * Format IBAN with spaces for readability
     *
     * @param string $iban
     * @return string
     */
    public function formatIban(string $iban): string
    {
        $iban = str_replace(' ', '', strtoupper($iban));
        return trim(chunk_split($iban, 4, ' '));
    }
}
