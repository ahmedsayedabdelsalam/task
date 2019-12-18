<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhraseAnalyserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->validateInput($request);

        $phrase = $request->phrase;

        $output = $this->analysePhrase($phrase);;

        $output = $this->format($output);

        return back()->with('output', $output);
    }

    /**
     * validate input
     */
    protected function validateInput(Request $request)
    {
        $request->validate([
            'phrase' => 'required|max:255'
        ]);
    }

    /**
     * analyse phrase and return each unique symbol 
     * (symbol, count, before chars, after chars)
     * complixty O(1)
     */
    protected function analysePhrase(string $phrase)
    {
        $phraseChars = str_split($phrase);
        $output = [];

        foreach ($phraseChars as $index => $char) {
            $output[$char]['symbol'] = $char;

            $output[$char]['count'] = isset($output[$char]['count']) ?
                $output[$char]['count'] += 1 : 1;

            $output[$char]['before'][] = isset($phraseChars[$index + 1]) ?
                $phraseChars[$index + 1] : 'none';

            $output[$char]['after'][] = isset($phraseChars[$index - 1]) ?
                $phraseChars[$index - 1] : 'none';
        }

        return $output;
    }

    /**
     * format the output
     * concat before chars and after chars into string
     */
    protected function format(array $output)
    {
        return array_map(function ($item) {
            return array_merge(
                $item,
                [
                    'before' => implode(',', $item['before']),
                    'after' => implode(',', $item['after']),
                ]
            );
        }, $output);
    }
}
