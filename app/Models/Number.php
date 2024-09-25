<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;

    public static function getEvenOdd($n)
    {
        $details = [];

        for ($i = 1; $i <= $n; $i++) {
            $details[] = [
                'number' => $i,
                'type' => $i % 2 === 0 ? 'Even' : 'Odd',
            ];
        }

        return $details;
    }

    public static function getFibonacciSequence($n)
    {
        $fibonacci = [0, 1];
        for ($i = 2; $i < $n; $i++) {
            $fibonacci[$i] = $fibonacci[$i-1] + $fibonacci[$i-2];
        }
        return $fibonacci;
    }

    public static function getNthFibonacci($n)
    {
        if ($n <= 0) return null;
        if ($n == 1) return 0;
        if ($n == 2) return 1;

        $a = 0;
        $b = 1;
        for ($i = 3; $i <= $n; $i++) {
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
        }
        return $b;
    }

    public static function isFibonacci($num)
    {
        if ($num == 0 || $num == 1) {
            return true;
        }
        
        $a = 0;
        $b = 1;
        while ($b < $num) {
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
        }
        return $b == $num;
    }

    public static function getFibonacciPosition($num)
    {
        if ($num == 0) return 1;
        if ($num == 1) return 2;
        
        $a = 0;
        $b = 1;
        $position = 2;
        while ($b < $num) {
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
            $position++;
        }
        return $b == $num ? $position : null;
    }

    public static function getPrimeSequence($n)
    {
        $primes = [];
        $count = 0;
        $num = 2;
        while (count($primes) < $n) {
            if (self::isPrime($num)) {
                $count++;
                $primes[$count] = $num;
            }
            $num++;
        }
        return $primes;
    }

    public static function getNthPrime($n)
    {
        $count = 0;
        $num = 2;
        while ($count < $n) {
            if (self::isPrime($num)) {
                $count++;
            }
            if ($count == $n) {
                return $num;
            }
            $num++;
        }
    }

    public static function isPrime($n)
    {
        if ($n <= 1) {
            return false;
        }
        for ($i = 2; $i <= sqrt($n); $i++) {
            if ($n % $i == 0) {
                return false;
            }
        }
        return true;
    }

    public static function getPrimePosition($n)
    {
        if (!self::isPrime($n)) {
            return null;
        }
        $count = 0;
        $num = 2;
        while ($num <= $n) {
            if (self::isPrime($num)) {
                $count++;
            }
            if ($num == $n) {
                return $count;
            }
            $num++;
        }
    }
}

function recursiveFibonacci($n) {
    if ($n <= 0) {
        return 0;
    } elseif ($n == 1) {
        return 1;
    } else {
        return recursiveFibonacci($n - 1) + recursiveFibonacci($n - 2);
    }
}

function isPrime($n) {
    // Cek jika $n kurang dari 2, maka bukan prima
    if ($n <= 1) {
        return 'Prime';
    }

    // Cek pembagi dari 2 sampai akar kuadrat dari $n
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) {
            return 'Not Prime'; // Jika ada yang membagi habis, maka bukan prima
        }
    }

    return 'Prime'; // Jika tidak ada yang membagi habis, maka prima
}
