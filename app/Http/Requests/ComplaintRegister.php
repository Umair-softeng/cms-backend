<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComplaintRegister extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'cnic' => [
                'required',
                'min:13',
                'max:13',
                Rule::when(
                    request('cnic') !== '0000000000000',
                    Rule::unique('complaints', 'cnic')
                ),
            ],
            'mobileNo' => 'required|min:11|max:11',
            'branchID' => 'required',
            'complaint' => 'required|min:50',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '
          <span>
          Name is required
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          نام لازمی ہے
          </span>
          <hr>
          ',

            'cnic.required' => '
          <span>
          CNIC is required
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          شناختی کارڈ نمبر لازمی ہے
          </span>
          <hr>
          ',

            'cnic.unique' => '
          <span>
          This CNIC has already been used
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          یہ شناختی کارڈ پہلے استعمال ہو چکا ہے
          </span>
          <hr>
          ',

            'cnic.min' => '
          <span>
          Invalid CNIC format
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          شناختی کارڈ درست نہیں ہے
          </span>
          <hr>
          ',

            'cnic.max' => '
          <span>
          Invalid CNIC format
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          شناختی کارڈ درست نہیں ہے
          </span>
          <hr>
          ',

            'mobileNo.required' => '
          <span>
          Mobile number is required
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          موبائل نمبر لازمی ہے
          </span>
          <hr>
          ',

            'mobileNo.min' => '
          <span>
          Mobile number must be at least 11 digits
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          موبائل نمبر کم از کم 11 ہندسوں کا ہونا چاہیے
          </span>
          <hr>
          ',

            'mobileNo.max' => '
          <span>
          Mobile number must not exceed the limit
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          موبائل نمبر زیادہ نہیں ہو سکتا
          </span>
          <hr>
          ',

            'branchID.required' => '
          <span>
          Branch selection is required
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          محکمہ منتخب کرنا لازمی ہے
          </span>
          <hr>
          ',

            'complaint.required' => '
          <span>
          Complaint details are required
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          شکایت کی تفصیل لازمی ہے
          </span>
          <hr>
          ',

            'complaint.min' => '
          <span>
          Complaint must be at least 50 characters long
          </span>
          <br>
          <span style="font-family: \'Noto Nastaliq Urdu\', serif; font-size:16px;">
          شکایت کم از کم 50 حروف پر مشتمل ہونی چاہیے
          </span>
          <hr>
          ',

        ];
    }
}
