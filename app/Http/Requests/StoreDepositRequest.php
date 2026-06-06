<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name'    => ['required', 'string', 'max:100'],
            'customer_email'   => ['required', 'email', 'max:150'],
            'customer_phone'   => ['required', 'string', 'regex:/^(0[3|5|7|8|9])+([0-9]{8})$/', 'max:20'],
            'customer_address' => ['nullable', 'string', 'max:255'],
            'customer_id_card' => ['nullable', 'string', 'max:20'],
            'deposit_amount'   => ['required', 'numeric', 'min:1000000'],
            'payment_method'   => ['required', 'in:bank_transfer,cash,momo,vnpay'],
            'note'             => ['nullable', 'string', 'max:500'],
            'agree_terms'      => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required'    => 'Vui lòng nhập họ và tên.',
            'customer_email.required'   => 'Vui lòng nhập email.',
            'customer_email.email'      => 'Email không đúng định dạng.',
            'customer_phone.required'   => 'Vui lòng nhập số điện thoại.',
            'customer_phone.regex'      => 'Số điện thoại không hợp lệ (VD: 0912345678).',
            'deposit_amount.required'   => 'Vui lòng nhập số tiền đặt cọc.',
            'deposit_amount.min'        => 'Số tiền đặt cọc tối thiểu là 1.000.000đ.',
            'payment_method.required'   => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in'         => 'Phương thức thanh toán không hợp lệ.',
            'agree_terms.accepted'      => 'Bạn phải đồng ý với điều khoản đặt cọc.',
        ];
    }
}
