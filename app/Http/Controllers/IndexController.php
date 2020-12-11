<?php

namespace App\Http\Controllers;

use App\Domain\ImportXmlService;
use App\Services\ImportationsProcessor;
use Exception;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function upload(Request $request)
    {
        try {
            if (!$request->hasFile('xml')) {
                throw new FileExistsException('XML is empty.');
            }
            $async = (bool) $request->post('async');
            $processor = new ImportationsProcessor();
            $importations =  $processor->createProcessFromXmlFile($request->file('xml'), $async);

            if ($importations) {
                $link = url('api/importations', ['id' => $importations->id]);
                
                return back()
                    ->withTitle('Success')
                    ->withSuccess("File is in processing queue. Check <a href='$link' target='_blank'>here</a>.");
            } else {
                return back()
                    ->withTitle('Warning')
                    ->withError('Something wrong with importation.');
            }
        } catch (Exception $exception) {
            return back()->withTitle('Error')->withError($exception->getMessage());
        }
    }
}
