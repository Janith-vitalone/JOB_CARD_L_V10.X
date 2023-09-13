<?php

namespace App\Http\Controllers;

use App\Client;
use App\Finishing;
use App\Format;
use App\Job;
use App\JobHasProduct;
use App\JobHasTask;
use App\Lamination;
use App\Material;
use App\Printer;
use App\PrintType;
use App\Product;
use App\Unit;
use App\User;
use App\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use DataTables;
use App\StockProductCategory;
use App\Stock;
use App\SupplierProduct;
use App\Substock;
use App\Bank;
use App\Branch;
use App\Invoice;
use App\Payment;

class JobCardController extends Controller
{

    public function __construct()
    {
        $controller = explode('@', request()->route()->getAction()['controller'])[0];

        $this->middleware('allowed:' . $controller);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designers = User::whereHas('designation', function($q) {
            $q->where('id', 1);
        })->get();
        $clients = Client::all();

        return view('dashboard.job_management.job_card.index', [
            'clients' => $clients,
            'designers' => $designers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $messures = Unit::get();
        $printers = Printer::where('job_type', 'large_format')->get();
        $printTypes = PrintType::where('job_type', 'large_format')->get();
        $designers = User::whereHas('designation', function($q) {
            $q->where('id', 1);
        })->get();
        $formats = Format::where('job_type', 'large_format')->get();
        $products = Product::get();
        $categories = StockProductCategory::get();

        return view('dashboard.job_management.job_card.create', [
            'messures' => $messures,
            'printers' => $printers,
            'printTypes' => $printTypes,
            'designers' => $designers,
            'formats' => $formats,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::with('client', 'user', 'jobHasTasks', 'jobHasProducts', 'invoice')->findOrFail($id);
        $banks = Bank::all();
        $branches = Branch::all();

        return view('dashboard.job_management.job_card.show', [
            'job' => $job,
            'banks' => $banks,
            'branches' => $branches,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::with('client', 'jobHasTasks', 'jobHasProducts')->findOrFail($id);

        if($job->isInvoiced())
        {
            return abort(403, "Unable to edit Invoiced Jobs");
        }

        $messures = Unit::get();
        $printers = Printer::where('job_type', 'large_format')->get();
        $printTypes = PrintType::where('job_type', 'large_format')->get();
        $designers = User::whereHas('designation', function($q) {
            $q->where('id', 1);
        })->get();
        $formats = Format::where('job_type', 'large_format')->get();
        $products = Product::get();
        $categories = StockProductCategory::get();

        $job_image = '';

        if($job->screenshot != '')
        {
            $job_image = $job->screenshot;
        }

        return view('dashboard.job_management.job_card.edit', [
            'job' => $job,
            'messures' => $messures,
            'printers' => $printers,
            'printTypes' => $printTypes,
            'designers' => $designers,
            'formats' => $formats,
            'products' => $products,
            'screenshot' => $job_image,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job_task_count = JobHasTask::where('job_id',$id)->count();
        $job_product_count = JobHasProduct::where('job_id',$id)->count();
        if($job_task_count != 0){
            $job_tasks = JobHasTask::where('job_id',$id)->get();

            foreach($job_tasks as $job_task){
                $task = JobHasTask::findOrFail($job_task->id);
                if($task->stock_qty != 0 && $task->stock_qty != null){
                    $stock_product = Stock::where('supplier_product_id', $task->product_id)->get();
                    $stock = Stock::findOrFail($stock_product[0]->id);
                    $new_stock_qty = $stock->qty + $job_task->stock_qty;

                    $stock->update([
                        'qty' => $new_stock_qty,
                    ]);
                }
                $task->delete();
            }
        }
        if($job_product_count != 0){
            $job_products = JobHasProduct::where('job_id', $id)->get();

            foreach($job_products as $job_product){
                $product = JobHasProduct::findOrFail($job_product->id);
                $product->delete();
            }
        }

        $invoice_count = Invoice::where('job_id', $id)->count();

        if($invoice_count != 0){
            $invoices = Invoice::where('job_id', $id)->get();
            foreach($invoices as $invoice){
                $payment_count = Payment::where('invoice_id', $invoice->id)->count();
                if($payment_count != 0){
                    $payments = Payment::where('invoice_id', $invoice->id)->get();
                    foreach($payments as $payment){
                        $payment->delete();
                    }
                }
                $invoice->delete();
            }
        }
        $job->delete();

        session()->flash('success', 'Job Removed!');
        return redirect()->back();
    }

    // This will creates a new Job
    public function createJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'client_note' => 'nullable|string',
    		'screenshot' => 'nullable',
    		'designer' => 'required|exists:users,id',
    		'job_note' => 'nullable|string',
    		'finish_date' => 'required',
    		'finish_time' => 'required',
            'job_list' => 'required_if:product_list,null',
            'product_list' => 'required_if:job_list,null',
    	]);

        if($request->quote_no == 0){
            $quote_no = null;
        }else{
            $quote = Quotation::where('id',$request->quote_no)->get();
            $quote_no = $quote[0]->quote_no;
        }

    	if($validator->fails())
    	{
    		return response()->json(['error' => $validator->errors()], 200);
        }

        // Get the new Job No
        $job_no = $this->generateNewJobNo();
        $job_status = 'open';
        $imageName = null;
        $avatar_url = null;

        // if($request->screenshot != null)
            // {
            //     // Converting base64 encoded screentshot to image file & saving it on server
            //     $image = $request->screenshot;
            //     $image = str_replace('data:image/png;base64,', '', $image);
            //     $image = str_replace(' ', '+', $image);
            //     $imageName = $job_no . str_random(10).'.'.'png';

            //     Storage::disk('jobs')->put($job_no . '/' . $imageName, base64_decode($image));
        // }

        if($request->hasFile('screenshot'))
        {
            // Converting base64 encoded screentshot to image file & saving it on server
            $image = $request->file('screenshot');
            $directory = $job_no;
            $avatar_url = '/' . $directory . '/screenshot.png';

            Storage::disk('jobs')->putFileAs($directory, $image, 'screenshot.png');
        }
        //Creates a new Job
        $job = Job::create([
            'job_no' => $job_no,
            'job_note' => $request->job_note,
            'client_id' => $request->client_id,
            'client_note' => $request->client_note,
            'user_id' => $request->designer,
            'screenshot' => $avatar_url,
            'finishing_date' => $request->finish_date,
            'finishing_time' => $request->finish_time,
            'created_by' => Auth::user()->id,
            'job_status' => $job_status,
            'po_no' => $request->po_no,
            'quote_no' => $quote_no,
        ]);

        if ($request->job_list != null)
        {
            $decodeJobJsonArray = json_decode($request->job_list, true);

            // Saving Job Tasks
            foreach($decodeJobJsonArray as $task)
            {
                $lamination = Lamination::find($task['lamination']);
                $finishing = Finishing::find($task['finishing']);
                $material = Material::find($task['material']);
                $unit = Unit::where('slug', $task['messure'])->get();
                $printer = Printer::find($task['printer']);
                $print_type = PrintType::where('slug', $task['print_type'])->get();
                $format = Format::find($task['format']);
                $copies = $task['copies'];
                //get product category
                $stock_product_category = $task['stock_product_category'];
                //get product
                $stock_product = $task['stock_product'];
                //stock subtraction
                $stock_subtraction_qty = 0;

                // job has product variables

                //for lamination
                $lamination_id = 0;
                $lamination_name = '';
                $lamination_rate = 0;
                //for finishing
                $finishing_id = 0;
                $finishing_name = '';
                $finishing_rate = 0;
                //for printer
                $printer_id = 0;
                $printer_name = '';

                // for lamination
                if($lamination == null){
                    $lamination_details = Lamination::where('name','None')->get();
                    $lamination_id = $lamination_details[0]->id;
                    $lamination_name = $lamination_details[0]->name;
                    $lamination_rate = $lamination_details[0]->rate;
                } else{
                    $lamination_id = $task['lamination'];
                    $lamination_name = $lamination->name;
                    $lamination_rate = $lamination->rate;
                }
                // for finishing
                if($finishing == null){
                    $finishing_details = Finishing::where('name', 'None')->get();
                    $finishing_id = $finishing_details[0]->id;
                    $finishing_name = $finishing_details[0]->name;
                    $finishing_rate = $finishing_details[0]->rate;
                } else{
                    $finishing_id = $task['finishing'];
                    $finishing_name = $finishing->name;
                    $finishing_rate = $finishing->rate;
                }
                // for material
                if($material == null){
                    $material_details = Material::where('name', 'None')->get();
                    $material_product = SupplierProduct::findOrFail($stock_product);
                    $material_id = $material_details[0]->id;
                    $material_name = $material_product->name;
                    $material_product_id = $material_product->id;
                }
                // for printer
                if($printer == null){
                    $printer_details = Printer::where('name', 'None')->get();
                    $printer_id = $printer_details[0]->id;
                    $printer_name = $printer_details[0]->name;
                } else{
                    $printer_id = $task['printer'];
                    $printer_name = $printer->name;
                }
                // for printer type
                if(($print_type->isEmpty())){
                    $print_type_details = PrintType::where('name', 'None')->get();
                    $print_type_id = $print_type_details[0]->id;
                    $print_type_name = $print_type_details[0]->name;
                } else{
                    $print_type_id = $print_type[0]->id;
                    $print_type_name = $print_type[0]->name;
                }
                // for format
                if($format == null){
                    $format_details = Format::where('name', 'None')->get();
                    $format_id = $format_details[0]->id;
                    $format_name = $format_details[0]->name;
                } else{
                    $format_id = $task['format'];
                    $format_name = $format->name;
                }

                //stock caluculations- start
                //get current stock of this product
                $stock_deatils = Stock::where('supplier_product_id', $stock_product)->get();
                //get current stock by using stock id
                $stock = Stock::findOrFail($stock_deatils[0]->id);
                //calculate area with out-product width and height
                $squar_area = ($task['width'] * $task['height']);
                //get product details by using product id
                $supplier_product = SupplierProduct::where('id',$stock_product)->get();
                //calculate area by using product details
                $supplier_product_area = $supplier_product[0]->width * $supplier_product[0]->height;
                //get unit details by using product unit id
                $supplier_product_unit = Unit::where('id', $supplier_product[0]->unit_id)->get();

                //convert Job area to Millimeter
                if($unit[0]->slug == "cm"){
                    $squar_area = $squar_area * 10;
                }else if($unit[0]->slug == "ft"){
                    $squar_area = $squar_area * 304.8;//changed
                }else if($unit[0]->slug == "inch"){
                    $squar_area = $squar_area * 25.4;
                }else if($unit[0]->slug == "m"){
                    $squar_area = $squar_area * 1000;
                }else if($unit[0]->slug == "mm"){
                    $squar_area = $squar_area * 1;
                }else {
                    return response()->json([
                        'error' => true,
                        'messsage' => 'Invalide Messure',
                    ]);
                }

                //convert stock product area to Millimeter
                if($supplier_product_unit[0]->slug == "cm"){
                    $supplier_product_area = $supplier_product_area * 10;
                }else if($supplier_product_unit[0]->slug == "ft"){
                    $supplier_product_area = $supplier_product_area * 304.8;
                }else if($supplier_product_unit[0]->slug == "inch"){
                    $supplier_product_area = $supplier_product_area * 25.4;
                }else if($supplier_product_unit[0]->slug == "m"){
                    $supplier_product_area = $supplier_product_area * 1000;
                }else if($supplier_product_unit[0]->slug == "mm"){
                    $supplier_product_area = $supplier_product_area * 1;
                }else {
                    return response()->json([
                        'error' => true,
                        'messsage' => 'Unvalide Stock Product Messure',
                    ]);
                }
                //count have many print can be done in one product on stock product
                $howcan = $supplier_product_area / $squar_area;
                //conver decimal(2.71) to int(2)
                $howcan = (int)$howcan;

                if($howcan == 0){
                    return response()->json([
                        'error' => true,
                        'messsage' => 'Selected Product Size Not Enough',
                    ]);
                }
                //available substock check
                $substock_count = Substock::where('supplier_product_id', $stock_product)->count();
                // cando is done by using substock
                $cando = 0;
                //check the available parts not to full one
                if($substock_count != 0){
                    // if true, Found substock parts
                    //get substock parts maximum part first
                    $substock_qtys = Substock::where('supplier_product_id', $stock_product)->orderBy('available_area','DESC')->get();

                    foreach($substock_qtys as $substock_qty)
                    {
                        //get full print size by using on copy size multiply by number of copies
                        $full_copy_size = $squar_area * $copies;
                        //check available substock area is bigger than full copy size
                        if($substock_qty->available_area > $full_copy_size){
                            //if it true
                            // get substock balance by using available substock substraction by full copy size
                            $substock_available = $substock_qty->available_area - $full_copy_size;
                            // get substock by using substock id
                            $substock = Substock::findOrFail($substock_qty->id);

                            //update substock
                            $substock->update([
                                'available_area' => $substock_available,
                            ]);
                        }else {
                            // if it fales
                            // add 1 to cando
                            $cando = $cando + 1;
                        }
                        break;
                    }
                }else{
                    // if fales, Not found any substock parts
                    //check 1 paper can do copies amount($howcan) bigger than invoiced copies amount
                    if($howcan < $copies){
                        // if it true, $copies bigger than $howcan
                        $want_stock_qty = 0;
                        // get want quontites by using number of invoice copies($copies) divied by Number of cpies can print in a one sheet($howcan)
                        $want_qty = number_format($copies / $howcan, 2,'.','00');
                        // get int value to get qty frmo stock. like 3.6 => 3
                        $want_stock_qty = (int)$want_stock_qty + (int)$want_qty;
                        // get copies that have to print another sheet = number of copies subtracktion (Number of copes can print in one paper multiply by want stock qty)
                        $extra_copies = $copies - ($howcan * $want_stock_qty);
                        // want stock qty add 1
                        $want_stock_qty = $want_stock_qty + 1;
                        // get extra paper cut area by using one copy area multply by number of extra copies
                        $total_cut_area = $squar_area * $extra_copies;
                        // get the blance area of the extra copies print sheet by using size of product subtraction by size of all extra copies
                        $available_area_after_cut = $supplier_product_area - $total_cut_area;
                        // available stock qty
                        $stock_qty = $stock->qty;
                        // new stock = stock qty subtraction by wnat qty for the job
                        $new_stock_qty = $stock_qty - $want_stock_qty;
                        //for jobhastask
                        $stock_subtraction_qty = $want_stock_qty;
                        //stock update
                        $stock->update([
                            'qty' => $new_stock_qty,
                        ]);

                        //substock create
                        Substock::create([
                            'stock_id' => $stock_deatils[0]->id,
                            'stock_product_category_id' => $stock_product_category,
                            'supplier_product_id' => $stock_product,
                            'unit_id' => $supplier_product[0]->unit_id,
                            'available_area' => $available_area_after_cut,
                        ]);
                    } else{
                        // if it fales, $howcan bigger than $copies
                        // calculate full size for the job by using one print size multiply by number of copies
                        $total_cut_area = $squar_area * $copies;
                        // get balance of size after job done by using product size subtraction by full job size
                        $available_area_after_cut = $supplier_product_area - $total_cut_area;
                        // get available stock
                        $stock_qty = $stock->qty;
                        // new stock
                        $new_stock_qty = $stock_qty -1;
                        //for jobhastask
                        $stock_subtraction_qty = 1;
                        //stock update
                        $stock->update([
                            'qty' => $new_stock_qty,
                        ]);

                        //substock create
                        Substock::create([
                            'stock_id' => $stock_deatils[0]->id,
                            'stock_product_category_id' => $stock_product_category,
                            'supplier_product_id' => $stock_product,
                            'unit_id' => $supplier_product[0]->unit_id,
                            'available_area' => $available_area_after_cut,
                        ]);
                    }
                }
                // check we can do with new stock
                if($cando == 1){
                    // check number of job copies bigger than number of print can do in a 1 paper
                    if($howcan < $copies){
                        $want_stock_qty = 0;
                        //get want qty
                        $want_qty = number_format($copies / $howcan, 2,'.','00');
                        $want_stock_qty = (int)$want_stock_qty + (int)$want_qty;

                        $extra_copies = $copies - ($howcan * $want_stock_qty);
                        $want_stock_qty = $want_stock_qty + 1;

                        $total_cut_area = $squar_area * $extra_copies;
                        $available_area_after_cut = $supplier_product_area - $total_cut_area;

                        $stock_qty = $stock->qty;
                        $new_stock_qty = $stock_qty - $want_stock_qty;
                        //for jobhastask
                        $stock_subtraction_qty = $want_stock_qty;
                        //stock update
                        $stock->update([
                            'qty' => $new_stock_qty,
                        ]);

                        //substock create
                        Substock::create([
                            'stock_id' => $stock_deatils[0]->id,
                            'stock_product_category_id' => $stock_product_category,
                            'supplier_product_id' => $stock_product,
                            'unit_id' => $supplier_product[0]->unit_id,
                            'available_area' => $available_area_after_cut,
                        ]);
                    } else{
                        $total_cut_area = $squar_area * $copies;
                        $available_area_after_cut = $supplier_product_area - $total_cut_area;

                        $stock_qty = $stock->qty;
                        $new_stock_qty = $stock_qty -1;
                        //for jobhastask
                        $stock_subtraction_qty = +1;
                        //stock update
                        $stock->update([
                            'qty' => $new_stock_qty,
                        ]);

                        //substock create
                        Substock::create([
                            'stock_id' => $stock_deatils[0]->id,
                            'stock_product_category_id' => $stock_product_category,
                            'supplier_product_id' => $stock_product,
                            'unit_id' => $supplier_product[0]->unit_id,
                            'available_area' => $available_area_after_cut,
                        ]);
                    }
                }

                $jobSs = null;

                if($task['job_ss'] != '1')
                {
                    // Converting base64 encoded screentshot to image file & saving it on server
                    $image = $task['job_ss'];
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $jobSs = $job_no . str_random(10).'.'.'png';

                    Storage::disk('jobs')->put($job_no .  '/tasks/' . $jobSs, base64_decode($image));
                }

                JobHasTask::create([
                    'job_id' => $job->id,
                    'description' => $task['description'],
                    'width' => $task['width'],
                    'height' => $task['height'],
                    'unit_id' => $unit[0]->id,
                    'unit' => $task['messure'],
                    'copies' => $task['copies'],
                    'printer_id' => $printer_id,
                    'printer' => $printer_name,
                    'print_type_id' => $print_type_id,
                    'print_type' => $print_type_name,
                    'sqft_rate' => $task['sqft_rate'],
                    'material_id' => $material_id,
                    'materials' => $material_name,
                    'lamination_id' => $lamination_id,
                    'lamination' => $lamination_name,
                    'lamination_rate' => $lamination_rate,
                    'unit_price' => $task['unit_price'],
                    'total' => $task['total'],
                    'finishing_id' => $finishing_id,
                    'finishing_rate' => $finishing_rate,
                    'finishing' => $finishing_name,
                    'job_type' => $task['job_type'],
                    'job_ss' => $jobSs,
                    'format' => $format_name,
                    'format_id' => $format_id,
                    'product_id' => $material_product_id,
                    'product_category_id' => $stock_product_category,
                    'stock_qty' => $stock_subtraction_qty,
                ]);
            }
        }
        //product list
        if ($request->product_list != null)
        {
            $decodeProductJsonArray = json_decode($request->product_list, true);
            // Saving Products List
            foreach($decodeProductJsonArray as $product)
            {
                $item = Product::where('name', $product['product'])->get();

                JobHasProduct::create([
                    'job_id' => $job->id,
                    'name' => $item[0]->name,
                    'product_id' => $item[0]->id,
                    'price' => $product['price'],
                    'qty' => $product['qty'],
                    'total' => $product['price'] * $product['qty'],
                ]);
            }
        }

        return response()->json([
            'error' => false,
            'messsage' => 'Job Created',
            'job_id' => $job->id,
        ]);
    }

    // Updating Job
    public function updateJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'client_note' => 'nullable|string',
    		'designer' => 'required|exists:users,id',
    		'job_note' => 'nullable|string',
    		'finish_date' => 'required',
    		'finish_time' => 'required',
            'job_list' => 'required_if:product_list,null',
            'product_list' => 'required_if:job_list,null',
            'id' => 'required|exists:injobs,id',
    	]);

    	if($validator->fails())
    	{
    		return response()->json(['error' => $validator->errors()], 200);
        }

        $job = Job::with('jobHasTasks', 'jobHasProducts')->find($request->id);
        $job_no = $job->job_no;

        // $imageName = null;

        // if($request->screenshot != null)
        // {
        //     // Converting base64 encoded screentshot to image file & saving it on server
        //     $image = $request->screenshot;
        //     $image = str_replace('data:image/png;base64,', '', $image);
        //     $image = str_replace(' ', '+', $image);
        //     $imageName = $job_no . str_random(10).'.'.'png';

        //     Storage::disk('jobs')->put($job_no . '/' . $imageName, base64_decode($image));
        // }

        // Creates a new Job
        $job->update([
            'job_note' => $request->job_note,
            'client_id' => $request->client_id,
            'client_note' => $request->client_note,
            'user_id' => $request->designer,
            'finishing_date' => $request->finish_date,
            'finishing_time' => $request->finish_time,
            'created_by' => Auth::user()->id,
            'po_no' => $request->po_no,
        ]);

        // $job->jobHasTasks()->delete();
        // $job->jobHasProducts()->delete();

        if ($request->job_list != null)
        {
            // Saving Job Tasks
            foreach($request->job_list as $task)
            {
                dd($task);
                $lamination = Lamination::find($task['lamination']);
                $finishing = Finishing::find($task['finishing']);
                $material = Material::find($task['material']);
                $unit = Unit::where('slug', $task['messure'])->get();
                $printer = Printer::find($task['printer']);
                $print_type = PrintType::where('slug', $task['print_type'])->get();
                $format = Format::find($task['format']);

                $jobSs = null;

                if($task['job_ss'] != '1')
                {
                    // Converting base64 encoded screentshot to image file & saving it on server
                    $image = $task['job_ss'];
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $jobSs = $job_no . str_random(10).'.'.'png';

                    Storage::disk('jobs')->put($job_no .  '/tasks/' . $jobSs, base64_decode($image));
                }

                JobHasTask::create([
                    'job_id' => $job->id,
                    'description' => $task['description'],
                    'width' => $task['width'],
                    'height' => $task['height'],
                    'unit_id' => $unit[0]->id,
                    'unit' => $task['messure'],
                    'copies' => $task['copies'],
                    'printer_id' => $task['printer'],
                    'printer' => $printer->name,
                    'print_type_id' => $print_type[0]->id,
                    'print_type' => $task['print_type'],
                    'sqft_rate' => $task['sqft_rate'],
                    'material_id' => $task['material'],
                    'materials' => $material->name,
                    'lamination_id' => $task['lamination'],
                    'lamination' => $lamination->name,
                    'lamination_rate' => $lamination->rate,
                    'unit_price' => $task['unit_price'],
                    'total' => $task['total'],
                    'finishing_id' => $task['finishing'],
                    'finishing_rate' => $finishing->rate,
                    'finishing' => $finishing->name,
                    'job_type' => $task['job_type'],
                    'job_ss' => $jobSs,
                    'format' => $format->name,
                    'format_id' => $task['format'],
                ]);
            }
        }
        dd("end");
        if ($request->product_list != null)
        {
            // Saving Products List
            foreach($request->product_list as $product)
            {
                //dd($request->product_list);
                $item = null;
                $item_id = null;
                $item_name = null;

                if($product['product'] === 'Custom')
                {
                    $id = Product::where('name', $product['product'])->select('id')->get();
                    $item = Product::findOrFail($id[0]->id);
                    $item_id = $item->id;
                    $item_name = $item->name;
                }
                else
                {
                    $id = Product::where('name', $product['product'])->select('id')->get();
                    $item = Product::findOrFail($id[0]->id);
                    $item_id = $item->id;
                    $item_name = $item->name;
                }
                //dd("ok",$item_id, $item_name, $product['price'],$product['qty'],$product['description'],$product['price'] * $product['qty']);
                JobHasProduct::create([
                    'job_id' => $job->id,
                    'name' => $item_name,
                    'product_id' => $item_id,
                    'price' => $product['price'],
                    'qty' => $product['qty'],
                    'description' => $product['description'],
                    'total' => $product['price'] * $product['qty'],
                ]);
            }
        }

        return response()->json([
            'error' => false,
            'messsage' => 'Job Updated',
            'job_id' => $job->id,
        ]);
    }

    // Generate New Job Number
    public function generateNewJobNo()
    {
        // Get the last created job
        $lastJob = Job::orderBy('id', 'desc')->first();

        if (!$lastJob)
        {
            $number = 100;
        }
        else
        {
            $number = $lastJob->id;
        }

        return sprintf('%06d', intval($number) + 1);
    }

    public function getAllJobs(Request $request)
    {
        $jobs = Job::with('user', 'client', 'invoice');

        if($request->job_no)
        {
            $jobs->where('job_no', $request->job_no);
        }

        if($request->client_id)
        {
            $jobs->where('client_id', $request->client_id);
        }

        if($request->designer)
        {
            $jobs->where('user_id', $request->designer);
        }

        if($request->status)
        {
            $jobs->where('job_status', $request->status);
        }

        if($request->invoice_no)
        {
            $invoice = $request->invoice_no;

            $jobs->whereHas('invoice', function($q)use($invoice) {
                $q->where('invoice_no', $invoice);
            });
        }

        switch($request->payment_status)
        {
            case 'unpaid':
                $jobs->doesntHave('invoice')->orWhereHas('invoice', function($q) {
                    $q->where('payment_status', 'unpaid');
                });
                break;
            case 'partially_paid':
                $jobs->whereHas('invoice', function($q) {
                    $q->where('payment_status', 'partially_paid');
                });
                break;
            case 'paid':
                $jobs->whereHas('invoice', function($q) {
                    $q->where('payment_status', 'paid');
                });
                break;
            default:
                break;
        }

        return DataTables::of($jobs->get())->make();
    }

    public function changeStatus($id, $status)
    {
        $job = Job::findOrFail($id);

        $job->update([
            'job_status' => $status,
        ]);

        session()->flash('success', 'Job Status Changed!');
        return redirect()->back();
    }

    // Return Formats, Print Types and Printers according to Job Type
    public function getDataByJobType($type)
    {
        $formats = Format::where('job_type', $type)->get();
        $print_types = PrintType::where('job_type', $type)->get();
        $printers = Printer::where('job_type', $type)->get();

        return response()->json([
            'error' => false,
            'data' => [
                'formats' => $formats,
                'print_types' => $print_types,
                'printers' => $printers,
            ],
        ]);
    }
}
