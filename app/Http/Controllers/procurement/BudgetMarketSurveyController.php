<?php
//
namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\ReuseableController;
use App\Http\Controllers\Controller;
use Session;
use File;
use Auth;
// use Barryvdh\DomPDF\Facade as PDF;
use PDF;
use DB;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\ExportTblmarketSurvey;
use App\Exports\ExportTblmarketSurvey;

use App\Models\TblmarketySurvey as TblmarketSurvey;
use Illuminate\Support\Facades\Log;

class BudgetMarketSurveyController extends Controller
{
    public function __construct() {}


    //create item page
    public function createSurvey01()
    {
        $data['getBudgetMarketSurvey'] = []; // Initialize the array
        try {

            $data['getBudgetItem']          = DB::table('tblitems')->get();
            $data['getCategory']            = DB::table('tblcategories')->get();
            $data['getSpecification']       = DB::table('tblspecifications')->get();
            $data['getBudgetMarketSurvey']  = DB::table('tblmarket_survey')
                ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblmarket_survey.categoryID')
                ->leftjoin('tblitems', 'tblitems.itemID', '=', 'tblmarket_survey.items')
                ->leftjoin('tblspecifications', 'tblspecifications.specificationID', '=', 'tblmarket_survey.specificationID')

                ->where('tblmarket_survey.status', 1)
                ->orderby('marketID', 'desc')
                ->get();
        } catch (\Throwable $e) {
            // Handle the exception if needed
        }
        //dd($data['getBudgetMarketSurvey']);

        return view('procurement.BudgetMarket.marketSurvey', $data);
    }
   
    public function createSurvey2()
    {
        $data['getBudgetMarketSurvey'] = []; // Initialize the array
        try {
            $data['getBudgetItem']          = DB::table('tblitems')->get();
            $data['getCategory']            = DB::table('tblcategories')->get();
            $data['getSpecification']       = DB::table('tblspecifications')->get();
            
            // Get market surveys with specifications
            $surveys = DB::table('tblmarket_survey')
                ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblmarket_survey.categoryID')
                ->leftJoin('tblitems', 'tblitems.itemID', '=', 'tblmarket_survey.items')
                ->leftJoin('tblspecifications', 'tblspecifications.specificationID', '=', 'tblmarket_survey.specificationID')
                ->where('tblmarket_survey.status', 1)
                ->orderBy('tblitems.item')
                ->orderBy('tblmarket_survey.marketID', 'desc')
                ->select(
                    'tblmarket_survey.*',
                    'tblitems.item',
                    'tblcategories.category',
                    'tblspecifications.specification'
                )
                ->get();
            
            // Group surveys by item and combine specifications
            $groupedSurveys = [];
            foreach ($surveys as $survey) {
                $itemId = $survey->items;
                
                if (!isset($groupedSurveys[$itemId])) {
                    $groupedSurveys[$itemId] = [
                        'item_id' => $itemId,
                        'item_name' => $survey->item,
                        'category' => $survey->category,
                        'category_id' => $survey->categoryID,
                        'specifications' => [],
                        'prices' => [],
                        'marketPrices' => [],
                        'survey_dates' => [],
                        'market_ids' => []
                    ];
                }
                
                // Add specification to the array
                if (!empty($survey->specification)) {
                    $groupedSurveys[$itemId]['specifications'][] = trim($survey->specification, '"');
                }
                
                // Store other data (you might want to handle multiple prices differently)
                $groupedSurveys[$itemId]['prices'][] = $survey->price;
                $groupedSurveys[$itemId]['marketPrices'][] = $survey->marketPrice;
                $groupedSurveys[$itemId]['survey_dates'][] = $survey->survey_date;
                $groupedSurveys[$itemId]['market_ids'][] = $survey->marketID;
            }
            
            $data['getBudgetMarketSurvey'] = $groupedSurveys;
                
        } catch (\Throwable $e) {
            \Log::error('Error in createSurvey: ' . $e->getMessage());
        }

        return view('procurement.BudgetMarket.marketSurvey', $data);
    }

    public function createSurvey()
    {
        $data['getBudgetMarketSurvey'] = []; // Initialize the array
        try {
            $data['getBudgetItem']          = DB::table('tblitems')->get();
            $data['getCategory']            = DB::table('tblcategories')->get();
            $data['getSpecification']       = DB::table('tblspecifications')->get();
            
            // Get market surveys with specifications
            $surveys = DB::table('tblmarket_survey')
                ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblmarket_survey.categoryID')
                ->leftJoin('tblitems', 'tblitems.itemID', '=', 'tblmarket_survey.items')
                ->leftJoin('tblspecifications', 'tblspecifications.specificationID', '=', 'tblmarket_survey.specificationID')
                ->where('tblmarket_survey.status', 1)
                ->orderBy('tblitems.item')
                ->orderBy('tblmarket_survey.marketID', 'desc')
                ->select(
                    'tblmarket_survey.*',
                    'tblitems.item',
                    'tblcategories.category',
                    'tblspecifications.specification'
                )
                ->get();
            
            // Group surveys by item and combine specifications
            $groupedSurveys = [];
            foreach ($surveys as $survey) {
                $itemId = $survey->items;
                
                if (!isset($groupedSurveys[$itemId])) {
                    $groupedSurveys[$itemId] = [
                        'item_id' => $itemId,
                        'item_name' => $survey->item,
                        'category' => $survey->category,
                        'category_id' => $survey->categoryID,
                        'specifications' => [],
                        'prices' => [],
                        'marketPrices' => [],
                        'survey_dates' => [],
                        'market_ids' => []
                    ];
                }
                
                // Add specification to the array
                if (!empty($survey->specification)) {
                    $groupedSurveys[$itemId]['specifications'][] = trim($survey->specification, '"');
                }
                
                // Store other data
                $groupedSurveys[$itemId]['prices'][] = $survey->price;
                $groupedSurveys[$itemId]['marketPrices'][] = $survey->marketPrice;
                $groupedSurveys[$itemId]['survey_dates'][] = $survey->survey_date;
                $groupedSurveys[$itemId]['market_ids'][] = $survey->marketID;
            }
            
            $data['getBudgetMarketSurvey'] = $groupedSurveys;
                
        } catch (\Throwable $e) {
            \Log::error('Error in createSurvey: ' . $e->getMessage());
        }

        return view('procurement.BudgetMarket.marketSurvey', $data);
    }
    public function getItemsByCategory($itemID)
    {
        $items = DB::table("tblitems")
            ->where("categoryID", $itemID)
            ->pluck("item", "itemID");
        return response()->json($items);
    }


    public function getSpecByItem1($itemID)
    {
        $data['specifications'] = DB::table('tblspecifications')
            ->where("itemID", $itemID)
            ->get();

        return response()->json($data);
    }

    public function getSpecByItem($itemID)
    {
        $specifications = DB::table('tblspecifications')
            ->where("itemID", $itemID)
            ->get();
            
        // Also get the current specifications for this item from market_survey if needed
        $currentSpecs = DB::table('tblmarket_survey')
            ->where('items', $itemID)
            ->where('status', 1)
            ->pluck('specificationID')
            ->toArray();

        return response()->json([
            'specifications' => $specifications,
            'current_specs' => $currentSpecs
        ]);
    }

    public function getSpecByItem01($itemID)
    {
        $specifications = DB::table('tblspecifications')
            ->where("itemID", $itemID)
            ->get();
        
        return response()->json($specifications);
    }

    //save item
    public function saveSurveyOLD(Request $request)
    {
        // dd($request->all());
        // Validation rules



        $this->validate($request, [
            'budgetItem'     => 'required',
            'budgetCategory' => 'required',
            'budgetPrice'    => 'required',
            'marketPrice'    => 'required',
            'surveyDate'     => 'required'
        ]);

        if ($request['surveyDate'] > date('Y-m-d')) {
            return redirect()->back()->with('error', 'Survey date cannot be more than today! Please select a previous date or today and try again.');
        }


        // Check if "Others" is selected in the specification dropdown
        if ($request->input('specification') === "Others") {
            // Insert the other specification into the tblspecifications table
            $otherSpecification = $request->input('otherSpecification');

            $otherSpecID = DB::table('tblspecifications')->insertGetId([
                'itemID'         => $request['budgetItem'], // You may need to replace this with the correct value
                'specification'  => $otherSpecification,
            ]);

            if (!$otherSpecID) {
                return redirect()->back()->with('error', 'Failed to insert other specification.');
            }

            try {

                // Insert new record into tblmarket_survey
                $recordIDS = DB::table('tblmarket_survey')->insertGetId([
                    'items'           => $request['budgetItem'],
                    'price'           => str_replace(',', '', $request['budgetPrice']),
                    'marketPrice'     => str_replace(',', '', $request['marketPrice']),
                    'categoryID'      => $request['budgetCategory'],
                    'specificationID' => $otherSpecID, // Add other specification ID here
                    'survey_date'      => \Carbon\Carbon::parse($request['surveyDate'])->format('Y-m-d'),
                    'created_at'      => date('Y-m-d')
                ]);

                if ($recordIDS) {
                    return redirect()->back()->with('message', 'Your record was created successfully.');
                } else {
                    return redirect()->back()->with('error', 'Failed to create your record. Please try again.');
                }
            } catch (\Throwable $e) {
                // Handle exceptions
                return redirect()->back()->with('error', 'An error occurred. Please try again later.');
            }
        } else {

            $recordID = $request['recordID'];
            if ($recordID) {
                $data['getMarketSurvey'] = DB::table('tblmarket_survey')->where('marketID',  '=', $recordID)->orderby('marketID', 'desc')->first();

                // Insert into history table // create an archieve from an existing survey data
                DB::table('tblmarket_survey_history')->insert([
                    'tblmarket_survey_id'   => $data['getMarketSurvey']->marketID,
                    'items'                 => $data['getMarketSurvey']->items,
                    'categoryID'            => $data['getMarketSurvey']->categoryID,
                    'specificationID'       => $data['getMarketSurvey']->specificationID,
                    'price'                 => $data['getMarketSurvey']->price,
                    'marketPrice'           => $data['getMarketSurvey']->marketPrice,
                    'date'                  => $data['getMarketSurvey']->created_at,
                    'survey_date'           => $data['getMarketSurvey']->survey_date,
                    'created_at'            => date('Y-m-d')
                ]);
                // Update specifications


                // if(count($request->input('specification'))> 0)

                if ($request->input('specification') != null) {


                    foreach ($request->input('specification') as $key => $spec) {
                        DB::table('tblspecifications')
                            ->where('specificationID', $request->input('specificationID.' . $key))
                            ->update([
                                'itemID' => $recordID,
                                'specification' => $spec,
                            ]);
                    }
                } else {
                }
                //Update if existing records
                // dd($request);
                $success = DB::table('tblmarket_survey')->where('marketID', $recordID)->update([
                    'items'         => $request['budgetItem'],
                    'price'         => str_replace(',', '', $request['budgetPrice']),
                    'marketPrice'   => str_replace(',', '', $request['marketPrice']),
                    'categoryID'    => $request['budgetCategory'],
                    'specificationID' => $request['specification'], // Add specification here
                    'survey_date'      => \Carbon\Carbon::parse($request['surveyDate'])->format('Y-m-d')
                ]);

                return redirect()->back()->with('message', 'Your record was created/updated successfully.');
            } else {

                $success = DB::table('tblmarket_survey')->insertGetId([
                    'items'         => $request['budgetItem'],
                    'price'         => str_replace(',', '', $request['budgetPrice']),
                    'marketPrice'   => str_replace(',', '', $request['marketPrice']),
                    'categoryID'    => $request['budgetCategory'],
                    'specificationID' => $request['specification'], // Add specification here
                    'survey_date'      => \Carbon\Carbon::parse($request['surveyDate'])->format('Y-m-d'),
                    'created_at'    => date('Y-m-d')
                ]);
                // return redirect()->back()->with('message', 'Your record was created successfully.');
            }

            if ($success) {
                return redirect()->back()->with('message', 'Your record was created/updated successfully.');
            }
            return redirect()->back()->with('error', 'Sorry, we cannot create your record now. Please try again.');
        }
    }

    public function saveSurvey(Request $request)
    {
        // Validation rules
        $this->validate($request, [
            'budgetItem'     => 'required',
            'budgetCategory' => 'required',
            'budgetPrice'    => 'required',
            'marketPrice'    => 'required',
            'surveyDate'     => 'required'
        ]);

        if ($request['surveyDate'] > date('Y-m-d')) {
            return redirect()->back()->with('error', 'Survey date cannot be more than today! Please select a previous date or today and try again.');
        }

        $recordID = $request['recordID'];
        
        try {
            DB::beginTransaction();
            
            if ($recordID) {
                // This is an update - ONLY update the record with the given ID
                $existingSurvey = DB::table('tblmarket_survey')->where('marketID', $recordID)->first();
                
                if ($existingSurvey) {
                    // Insert into history before making changes
                    DB::table('tblmarket_survey_history')->insert([
                        'tblmarket_survey_id' => $existingSurvey->marketID,
                        'items' => $existingSurvey->items,
                        'categoryID' => $existingSurvey->categoryID,
                        'specificationID' => $existingSurvey->specificationID,
                        'price' => $existingSurvey->price,
                        'marketPrice' => $existingSurvey->marketPrice,
                        'date' => $existingSurvey->created_at,
                        'survey_date' => $existingSurvey->survey_date,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    // Update ONLY the main record
                    DB::table('tblmarket_survey')
                        ->where('marketID', $recordID)
                        ->update([
                            'price' => str_replace(',', '', $request['budgetPrice']),
                            'marketPrice' => str_replace(',', '', $request['marketPrice']),
                            'survey_date' => \Carbon\Carbon::parse($request['surveyDate'])->format('Y-m-d'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    
                    DB::commit();
                    return redirect()->back()->with('message', 'Survey updated successfully.');
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Survey record not found.');
                }
            } else {
                // This is a new record - check if item already exists (UNIQUE ITEM CHECK)
                $itemId = $request['budgetItem'];
                $selectedSpecs = $request->input('specifications', []);
                
                // Check if specifications exist and is an array
                if (empty($selectedSpecs) || !is_array($selectedSpecs)) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Please select at least one specification.');
                }
                
                // Check if this item already has a survey (UNIQUE ITEM VALIDATION)
                $existingItem = DB::table('tblmarket_survey')
                    ->where('items', $itemId)
                    ->where('status', 1)
                    ->first();
                
                if ($existingItem) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'This item already has a survey record.');
                }
                
                // Get all specifications for this item to verify they belong to the item
                $validSpecs = DB::table('tblspecifications')
                    ->whereIn('specificationID', $selectedSpecs)
                    ->where('itemID', $itemId)
                    ->pluck('specificationID')
                    ->toArray();
                
                if (count($validSpecs) != count($selectedSpecs)) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Invalid specifications selected for this item.');
                }
                
                // Create ONE record for the item with all specifications
                // We'll store the specifications as a comma-separated string or handle them appropriately
                // Option 1: Create multiple records (one per specification)
                foreach ($selectedSpecs as $specId) {
                    DB::table('tblmarket_survey')->insert([
                        'items' => $itemId,
                        'price' => str_replace(',', '', $request['budgetPrice']),
                        'marketPrice' => str_replace(',', '', $request['marketPrice']),
                        'categoryID' => $request['budgetCategory'],
                        'specificationID' => $specId,
                        'survey_date' => \Carbon\Carbon::parse($request['surveyDate'])->format('Y-m-d'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'status' => 1
                    ]);
                }
                
                DB::commit();
                return redirect()->back()->with('message', 'Survey created successfully for item with ' . count($selectedSpecs) . ' specification(s).');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Error in saveSurvey: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    

    //Delete Market Survey
    public function deleteMarketSurvey($marketID = null)
    {
        $marketID = base64_decode($marketID);
        if ($marketID) {
            $success = null;
            try {
                $success = DB::table('tblmarket_survey')->where('marketID', $marketID)->delete();
            } catch (\Throwable $e) {
            }
            if ($success) {
                return redirect()->back()->with('message', 'Your record was deleted successfully.');
            }
        }
        return redirect()->back()->with('error', 'Sorry, we are unable to delete your record. Please try again.');
    }


    public function generatePDF111(Request $request)
    {

        try {
            // $rowData = $request->input('data');
            $requestData = json_decode($request->getContent(), true);
            $rowData = $requestData['data'];
            Log::info($rowData);
            // Pass the data to the view
            $pdf = PDF::loadView('BudgetMarket.pdf.export', compact('rowData'))
                ->setPaper('A4', 'portrait')->setOptions([
                    'tempDir' => public_path(), // to load images in the pdf page
                    'chroot' => public_path() // to load images in the pdf page
                ]);

            // Generate a timestamp to append to the filename
            $timestamp = now()->format('Y_m_d_His');

            // Define the filename with a timestamp
            $filename = 'exported_rows_' . $timestamp . '.pdf';

            // Download the PDF with the modified filename
            return $pdf->download($filename);


            // Optionally, you can save the PDF or stream it to the browser
            // $pdf->save('path_to_save_pdf.pdf');
            // return $pdf->stream('exported_rows.pdf');

            // return $pdf->download('invoice.pdf');
        } catch (\Exception $e) {
            // Log the exception for further investigation
            \Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Error generating PDF'], 500);
        }
    }

    public function getBudgetMarketSurveyData()
    {
        return DB::table('tblmarket_survey')->orderby('marketID', 'desc')
            ->leftJoin('tblitems', 'tblitems.itemID', '=', 'tblmarket_survey.items')
            ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblmarket_survey.categoryID')
            ->leftJoin('tblspecifications', 'tblspecifications.specificationID', '=', 'tblmarket_survey.specificationID')
            ->where('tblmarket_survey.status', 1)
            ->get();
    }
    public function getBudgetMarketSurveyArchiveData()
    {
        return DB::table('tblmarket_survey_history')->orderby('id', 'desc')
            ->leftJoin('tblitems', 'tblitems.itemID', '=', 'tblmarket_survey_history.items')
            ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblmarket_survey_history.categoryID')
            ->leftJoin('tblspecifications', 'tblspecifications.specificationID', '=', 'tblmarket_survey_history.specificationID')
            ->where('tblmarket_survey_history.status', 1)
            ->get();
    }

    public function generatePDF(Request $request)
    {
        try {

            $rowData = $this->getBudgetMarketSurveyData();

            // Pass the data to the view
            $pdf = PDF::loadView('procurement.BudgetMarket.pdf.export', compact('rowData'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'tempDir' => public_path(), // to load images in the pdf page
                    'chroot' => public_path()   // to load images in the pdf page
                ]);

            // Generate a timestamp to append to the filename
            $timestamp = now()->format('Y_m_d_His');

            // Define the filename with a timestamp
            $filename = 'exported_rows_' . $timestamp . '.pdf';

            // Download the PDF with the modified filename
            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Log the exception for further investigation
            Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Error generating PDF'], 500);
        }
    }

    public function generatePDFOLD(Request $request)
    {
        try {
            $rowData = $this->getBudgetMarketSurveyData();

            $pdf = \PDF::loadView('procurement.BudgetMarket.pdf.export', compact('rowData'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'tempDir' => public_path(),
                    'chroot'  => public_path(),
                ]);

            $timestamp = now()->format('Y_m_d_His');
            $filename  = 'exported_rows_' . $timestamp . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            // 👇 Temporarily display the real error (for testing only)
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }


    public function archiveGeneratePDF(Request $request)
    {
        try {

            $rowData = $this->getBudgetMarketSurveyArchiveData();




            // Pass the data to the view
            $pdf = PDF::loadView('procurement.BudgetMarket.pdf.export', compact('rowData'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'tempDir' => public_path(), // to load images in the pdf page
                    'chroot' => public_path()   // to load images in the pdf page
                ]);

            // Generate a timestamp to append to the filename
            $timestamp = now()->format('Y_m_d_His');

            // Define the filename with a timestamp
            $filename = 'exported_rows_' . $timestamp . '.pdf';

            // Download the PDF with the modified filename
            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Log the exception for further investigation
            Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Error generating PDF'], 500);
        }
    }

    public function allBudgetSurveyArchive()
    {
        try {
            $data['getBudgetMarketSurvey']  = DB::table('tblmarket_survey_history')->orderby('id', 'desc')
                ->leftJoin('tblitems', 'tblitems.itemID', '=', 'tblmarket_survey_history.items')
                ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblmarket_survey_history.categoryID')
                ->leftJoin('tblspecifications', 'tblspecifications.specificationID', '=', 'tblmarket_survey_history.specificationID')
                ->where('tblmarket_survey_history.status', 1)
                ->select(
                    'tblmarket_survey_history.id',
                    'tblmarket_survey_history.items',
                    'tblmarket_survey_history.price',
                    'tblmarket_survey_history.marketPrice',
                    'tblmarket_survey_history.date',
                    'tblmarket_survey_history.created_at',
                    'tblmarket_survey_history.tblmarket_survey_id',

                    'tblitems.item',
                    'tblcategories.category',
                    'tblspecifications.specification'
                )
                ->get();
        } catch (\Throwable $e) {
        }

        return view('procurement.BudgetMarket.marketSurveyArchive', $data);
    }

    public function getBudgetSurveyArchive($id)
    {
        try {
            $data['getBudgetMarketSurvey']  = DB::table('tblmarket_survey_history')->orderby('id', 'desc')
                ->leftJoin('tblitems', 'tblitems.itemID', '=', 'tblmarket_survey_history.items')
                ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblmarket_survey_history.categoryID')
                ->leftJoin('tblspecifications', 'tblspecifications.specificationID', '=', 'tblmarket_survey_history.specificationID')
                ->where('tblmarket_survey_history.status', 1)
                ->where('tblmarket_survey_history.tblmarket_survey_id', $id)
                ->select(
                    'tblmarket_survey_history.id',
                    'tblmarket_survey_history.items',
                    'tblmarket_survey_history.price',
                    'tblmarket_survey_history.marketPrice',
                    'tblmarket_survey_history.date',
                    'tblmarket_survey_history.created_at',
                    'tblmarket_survey_history.tblmarket_survey_id',

                    'tblitems.item',
                    'tblcategories.category',
                    'tblspecifications.specification'
                )
                ->get();
        } catch (\Throwable $e) {
        }
        //dd($data['getBudgetMarketSurvey']);
        return view('procurement.BudgetMarket.marketSurveyArchive', $data);
    }

    public function exportSurveyExcel(Request $request)
    {
        return \Excel::download(new ExportTblmarketSurvey, 'market_survey.xlsx');
    }

    public function deleteAllItemSurveys($itemId)
    {
        try {
            $itemId = base64_decode($itemId);
            DB::table('tblmarket_survey')->where('items', $itemId)->delete();
            return redirect()->back()->with('message', 'All survey entries for this item have been deleted successfully!');
        } catch (\Throwable $e) {
            \Log::error('Error deleting all item surveys: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting survey entries!');
        }
    }
}//end class
