<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class ExpenseController extends Controller
{
    //


    public function AddExpense(){
    
        return view('Expense.AddExpense');
    }


    public function StoreExpense(Request $request){

        $request->validate([
            'details' => 'required|string|max:255',
        ]);


        Expense::insert([
            'details' => $request->input('details'),
            'amount' => $request->input('amount'),
            'month' => $request->input('month'),
            'year' => $request->input('year'),
            'date' => $request->input('date'),
            'created_at' => Carbon::now(), 

        ]);


        $notification = array(
            'message' => 'Succesfully Inserted Expense',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }



    public function TodayExpense() {

            $date = date("d-m-Y");
            $TodaysData = Expense::where('date', $date)->get();
            return view('Expense.TodaysExpense', compact('TodaysData'));


          
    }



        
        public function MonthExpense() {

                $month = date("F");
                $MonthData = Expense::where('month', $month)->get();
                return view('Expense.MonthExpense', compact('MonthData'));


            
        }

        public function YearExpense() {

                $year = date("Y");
                $YearData = Expense::where('year', $year)->get();
                return view('Expense.YearExpense', compact('YearData'));


        }

}
