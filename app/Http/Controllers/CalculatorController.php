<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('calculator');
    }

    public function calculate(Request $request)
    {
        $display = $request->input('display');

        // Validasi angka hanya sampai 8 digit
        if (strlen(preg_replace('/\D/', '', $display)) > 8) {
            return response()->json(['result' => 'ERR']);
        }

        // Proses perhitungan tanpa eval
        try {
            $result = $this->evaluateExpression($display);
            if (strlen((string)$result) > 8) {
                return response()->json(['result' => 'ERR']);
            }
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['result' => 'ERR']);
        }
    }

    private function evaluateExpression($expr)
    {
        // Kalkulasi manual (misalnya dengan regex + stack)
        // Sementara versi sederhana:
        $expr = preg_replace('/[^0-9+\-\/.*]/', '', $expr); // Hindari karakter aneh
        $tokens = preg_split('/([+\-\/])/', $expr, -1, PREG_SPLIT_DELIM_CAPTURE);

        $result = (int)$tokens[0];
        for ($i = 1; $i < count($tokens); $i += 2) {
            $operator = $tokens[$i];
            $number = (int)$tokens[$i + 1];

            switch ($operator) {
                case '+': $result += $number; break;
                case '-': $result -= $number; break;
                case '/': $result = ($number == 0) ? 0 : intdiv($result, $number); break;
            }
        }

        return $result;
    }
}