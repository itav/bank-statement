<?php

namespace App\Finance\Bank;

class ImportParser
{

    const SOURCE_CA = 'ca';
    const SOURCE_IDEA = 'idea';

    /**
     * 
     * @param array $data
     * @return \App\Finance\Bank\Record
     */
    public static function parseIdea($data)
    {
        if (!self::validateIdea($data)) {
            return null;
        }
        $ownNo = '33195000012006050650750002';
        $senderAccount = preg_replace('/[^\d]/', '', $data[1]);
        $type = ($senderAccount == $ownNo) ? Record::TYPE_MINUS : Record::TYPE_PLUS;
        $amount = preg_replace('/[^\d\.]/', '', $data[7]);
//        0 => string '﻿Nadawca' (length=10)
//        1 => string 'Rachunek nadawcy' (length=16)
//        2 => string 'Tytułem' (length=8)
//        3 => string 'Odbiorca' (length=8)
//        4 => string 'Rachunek odbiorcy' (length=17)
//        5 => string 'Data złożenia dyspozycji' (length=26)
//        6 => string 'Data waluty' (length=11)
//        7 => string 'Kwota operacji' (length=14)
//        8 => string 'Saldo po operacji' (length=17)        
        $record = new Record();
        $record
            ->setSender($data[0])
            ->setSenderBankAccount($senderAccount)
            ->setDesctiption($data[2])
            ->setReceiver($data[3])
            ->setReceiverBankAccount(preg_replace('/[^\d]/', '', $data[4]))
            ->setDate((new \DateTime($data[6])))
            ->setAmount($amount)
            ->setType($type);
        return $record;
    }

    /**
     * 
     * @param array $data
     * @return \App\Finance\Bank\Record
     */
    public static function parseCa($data)
    {
        if (!self::validateIdea($data)) {
            return null;
        }
//        0 => string 'Data' (length=4)
//        1 => string 'Operacja' (length=8)
//        2 => string 'Kwota' (length=5)
//        3 => string 'Saldo po operacji' (length=17) 
        // od pola 4 do 21 sa pary etykieta opis
        //mozliwe etykiety:
//        'Nadawca'
//        'Rachunek nadawcy'
//        'Odbiorca'
//        'Tytuł przelewu'
//        'Rachunek odbiorcy'
//        'Tytuł wpłaty'
//        'Kanał'
//        'Nazwa akceptanta'
//        'Miasto akceptanta'
//        'Kraj akceptanta'
//        'Karta'
//        'Data transakcji'
//        'Agent rozliczeniowy (Acquirer)'
//        'Kwota transakcji'
//        'Waluta'
//        'Operacja'
//        'Rachunek operacji'
//        'Kwota prowizji'
        //pola od 4 do 21 zamieniamy na tablice 'etykieta' => 'opis'
        $add = [];
        for ($i = 4; $i < count($data); $i++) {
            if (0 === $i % 2) {
                $key = $data[$i];
                continue;
            }
            $add[$key] = $data[$i];
        }
        $data = array_merge(array_slice($data, 0, 4), $add);
        $amount = preg_replace('/[^\d\.\-]/', '', $data[2]);
        $type = (0 === strpos($amount, '-')) ? Record::TYPE_MINUS : Record::TYPE_PLUS;
        $title = $data[1];
        $title .= isset($data['Tytuł przelewu']) ? $data['Tytuł przelewu'] : ((isset($data['Tytuł wpłaty'])) ? $data['Tytuł wpłaty'] : null);
        $record = new Record();
        $record
            ->setSender(isset($data['Nadawca']) ? $data['Nadawca'] : null)
            ->setSenderBankAccount(isset($data['Rachunek nadawcy']) ? $data['Rachunek nadawcy'] : null)
            ->setDesctiption($title)
            ->setReceiver(isset($data['Odbiorca']) ? $data['Odbiorca'] : null)
            ->setReceiverBankAccount(isset($data['Rachunek odbiorcy']) ? $data['Rachunek odbiorcy'] : null)
            ->setDate(new \DateTime($data[0]))
            ->setAmount(str_replace('-', '', $amount))
            ->setType($type);
        return $record;
    }

    private static function validateIdea($data)
    {
        if (!is_array($data)) {
            return false;
        }
        return true;
    }

    private static function validateCa($data)
    {
        if (!is_array($data)) {
            return false;
        }
        return true;
    }

    public static function getImportSettings($source)
    {
        switch ($source) {
            case self::SOURCE_CA:
                return [
                    'delimiter' => ',',
                    'enclosure' => '"',
                    'encoding' => 'CP1250',
                    'parser' => 'parseCa',
                ];
            case self::SOURCE_IDEA:
                return [
                    'delimiter' => ';',
                    'enclosure' => '"',
                    'encoding' => 'UTF-8',
                    'parser' => 'parseIdea',
                ];
        }
    }
    
    /**
     * 
     * @param string $filename
     * @param int $source
     * @return Record[]
     */
    public static function getRecordsFromFile($filename, $source)
    {
        $handle = fopen($filename, 'r');
        $i = 0;
        $records = [];
        $set = self::getImportSettings($source);
        while ($line = fgets($handle)) {
            if (0 === $i++) {
                continue;
            }
            if ('UTF-8' !== $set['encoding']) {
                $line = iconv($set['encoding'], 'UTF-8', $line);
            }
            $data = str_getcsv($line, $set['delimiter'], $set['enclosure']);

            if (null === ( $record = ImportParser::{$set['parser']}($data) )) {
                continue;
            }
            $records[] = $record;
        }
        fclose($handle);
        return $records;
    }

}
