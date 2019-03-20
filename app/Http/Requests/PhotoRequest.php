<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//データ操作の権限の確認。トークン？使用とか。
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()//バリデーションルールの記載
    {
        return [
            'photo'.'*'=>[//ここの『photo』はvueで送るデータの名前を一致させる必要があるため、『*』のワイルドカードが必要。
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
//                 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png,jpg,gif',

                'max:2048'
            ]
        ];
    }
}
