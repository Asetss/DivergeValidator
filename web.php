<?php

Route::post('testValidation', function(Request $request) {

    $request->validate([
        'newPrice' => 'required',
        'currentPrice' => ['required', new DivergeValidator(5)]
    ]);

    return response()->json(['success' => true]);
});
