<?php

namespace App\Http\Controllers;

use App\Imports\TransactionsImport;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class TransactionController extends Controller
{
    /**
     * Sends email to the uploaded players
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function uploadContentWithPackage(Request $request)
    {
        if ($request->file) {
            $file = $request->file;
            $import = new TransactionsImport();
//            (new \Maatwebsite\Excel\Excel)->import($import, $request->file);
            Excel::import($import, $request->file);

            return response()->json([
                'message' => $import->data->count() ." records successfully uploaded"
            ]);
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

}
