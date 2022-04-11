<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Redirect;
use Validator;
use Cache;
use Session;
use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Display Homepage view.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        try {

            // get all currencies
            $currencies = $this->getCurrencies();
             
            // validate limit
            if ($this->exceedLimit($currencies)) {
                return $this->exceedLimit($currencies);
            }
            
            return view('home', [
                'currencies' => $currencies,
                'from' => 'USD'
            ]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Convert currencies
     * @param Request $request
     * @return boolean
     */
    public function convert(Request $request) {
        try {

            // get all currencies
            $currencies = $this->getCurrencies();

            // increment requests session
            Session::increment('count');
            
            // validate limit
            if ($this->exceedLimit($currencies)) {
                return $this->exceedLimit($currencies);
            }

            // validate request params 
            $validator = Validator::make($request->all(), [
                        'amount' => 'required|numeric',
                        'from' => 'required|string',
                        'to' => 'required|string'
            ]);

            if ($validator->fails()) {
                return view('home', [
                    'error' => $validator->errors()->first(),
                    'currencies' => $currencies
                ]);
            }


            // Get request params
            $amount = $request->input('amount');
            $from = $request->input('from');
            $to = $request->input('to');


            // validate currencies 
            if (!$this->filter_currency($from) || !$this->filter_currency($to)) {

                return view('home', [
                    'error' => 'Select a valid currency',
                    'currencies' => $currencies
                ]);
            }

            return view('home', [
                'total' => $this->getAmountCurrency($from, $to),
                'currency' => $this->filter_currency($to),
                'amount' => $amount,
                'from' => $from,
                'to' => $to,
                'currencies' => $currencies
            ]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Get the amount from the api
     * @param type $amount
     * @param type $from
     * @param type $to
     * @return boolean
     */
    public function getAmountCurrency($from, $to) {

        try {
            $query = urlencode($from) . '_' . urlencode($to);
            $total = 0;
            $response = Http::get('https://free.currconv.com/api/v7/convert?q=' . $query . '&compact=ultra&apiKey=' . env('CURRENCY_API_KEY'));
            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody(), true);
                $total = floatval($response["$query"]);
            }
            return $total;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Get All currencies from Api
     * @return boolean
     */
    public function getCurrencies() {
        try {
            // Store currencies in the cache
            $currencies = Cache::rememberForever('all_currencies', function () {
                        $response = Http::get('https://free.currconv.com/api/v7/currencies?apiKey=' . env('CURRENCY_API_KEY'));
                        $response = json_decode($response->getBody(), FALSE);
                        return $response->results;
                    });

            return (object) $currencies;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /*     * *
     * Filter currency by ID
     * Review the list of all currencies and validate if it exists
     * @return boolean
     */

    public function filter_currency($currency) {
        try {
            $collection = collect($this->getCurrencies());
            return $collection->firstWhere('id', $currency);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * validate convertions limit by session
     * @param type $currencies
     * @return boolean
     */
    public function exceedLimit($currencies) {
        try {
            // validate convertions limit 
            if (Session::get('count') > env('LIMIT_CURRENCY_API')) {
                return view('home', [
                    'error' => 'You have exceeded the conversion limit',
                    'limit' => true,
                    'currencies' => $currencies
                ]);
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
