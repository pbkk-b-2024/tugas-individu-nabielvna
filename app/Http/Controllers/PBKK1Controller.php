<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Number;

class PBKK1Controller extends Controller
{
    
    public function evenOdd(Request $request){
        $numberDetails = [];
        $singleResult = null;
        
        if ($request->has('n')) {
            $validatedData = $request->validate([
                'n' => 'required|integer|min:1',
                'mode' => 'required|in:sequence,single'
            ]);
    
            $n = $validatedData['n'];
            $mode = $validatedData['mode'];
    
            if ($mode === 'sequence') {
                $numberDetails = Number::getEvenOdd($n);
            } else {
                $singleResult = [
                    'number' => $n,
                    'type' => $n % 2 === 0 ? 'Even' : 'Odd'
                ];
            }
        }
        
        return view('PBKK1.even-odd', compact('numberDetails', 'singleResult'));
    }

    public function fibonacci(Request $request){
        $fibonacciSequence = [];
        $nthFibonacci = null;
        $isFibonacci = null;
        $position = null;
        
        if ($request->has('n')) {
            $validatedData = $request->validate([
                'n' => 'required|integer|min:0',
                'mode' => 'required|in:sequence,nth,check'
            ]);

            $n = $validatedData['n'];
            $mode = $validatedData['mode'];

            switch ($mode) {
                case 'sequence':
                    $fibonacciSequence = Number::getFibonacciSequence($n);
                    break;
                case 'nth':
                    $nthFibonacci = Number::getNthFibonacci($n);
                    break;
                case 'check':
                    $isFibonacci = Number::isFibonacci($n);
                    if ($isFibonacci) {
                        $position = Number::getFibonacciPosition($n);
                    }
                    break;
            }
        }
        
        return view('PBKK1.fibonacci', compact('fibonacciSequence', 'nthFibonacci', 'isFibonacci', 'position'));
    }

    public function primeNumber(Request $request){
        $primeSequence = [];
        $isPrime = null;
        $nthPrime = null;
        $position = null; 
        
        if ($request->has('n')) {
            $validatedData = $request->validate([
                'n' => 'required|integer|min:1',
                'mode' => 'required|in:sequence,check,nth'
            ]);
    
            $n = $validatedData['n'];
            $mode = $validatedData['mode'];
    
            switch ($mode) {
                case 'sequence':
                    $primeSequence = Number::getPrimeSequence($n);
                    break;
                case 'check':
                    $isPrime = Number::isPrime($n);
                    if ($isPrime) {
                        $position = Number::getPrimePosition($n);
                    }
                    break;
                case 'nth':
                    $nthPrime = Number::getNthPrime($n);
                    break;
            }
        }
        
        return view('PBKK1.prime-number', compact('primeSequence', 'isPrime', 'nthPrime', 'position'));
    }
    
    public function param1($param1 = ''){
        $data['param1'] = $param1;
        return view('PBKK1.param.param1',compact('data'));
    }

    public function param2($param1 ='', $param2 =''){
        $data['param1'] = $param1;
        $data['param2'] = $param2;
        return view('PBKK1.param.param2',compact('data'));
    }

}
