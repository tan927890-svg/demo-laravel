<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepositRequest;
use App\Mail\DepositConfirmationMail;
use App\Models\Car;
use App\Models\Deposit;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    public function create(string $slug)
    {
        $car = Car::where('slug', $slug)->firstOrFail();

        return view('deposits.create', compact('car'));
    }

    public function store(StoreDepositRequest $request, string $slug)
    {
        $car = Car::where('slug', $slug)->firstOrFail();

        DB::beginTransaction();
        try {
            $deposit = Deposit::create([
                'car_id'           => $car->id,
                'customer_name'    => $request->customer_name,
                'customer_email'   => $request->customer_email,
                'customer_phone'   => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'customer_id_card' => $request->customer_id_card,
                'deposit_amount'   => $request->deposit_amount,
                'payment_method'   => $request->payment_method,
                'note'             => $request->note,
                'status'           => 'pending',
            ]);

            DB::commit();

            // Gửi email xác nhận cho khách — lỗi mail không làm hỏng flow chính
            try {
                Mail::to($deposit->customer_email)
                    ->bcc(env('MAIL_GARAGE_EMAIL'))
                    ->send(new DepositConfirmationMail($deposit->load('car')));
            } catch (\Exception $mailEx) {
                Log::error('DepositMail failed: ' . $mailEx->getMessage(), [
                    'deposit_id' => $deposit->id,
                ]);
            }

            return redirect()->route('deposits.success', $deposit->transaction_code)
                ->with('success', 'Đặt cọc thành công! Chúng tôi sẽ liên hệ xác nhận trong vòng 24h.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Deposit store failed: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ hotline.')->withInput();
        }
    }

    public function success(string $transactionCode)
    {
        $deposit = Deposit::where('transaction_code', $transactionCode)
            ->with('car')
            ->firstOrFail();

        return view('deposits.success', compact('deposit'));
    }
}