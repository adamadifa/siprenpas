<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KonfirmasiPembayaranRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Atau tambahkan logic authorization jika diperlukan
    }

    public function rules()
    {
        return [
            'tanggal_pembayaran' => [
                'required',
                'date',
                'before_or_equal:today', // Tidak boleh lebih dari hari ini
            ],
            'jumlah_pembayaran' => [
                'required',
                'numeric',
                'min:1',
            ],
            'metode_pembayaran' => [
                'required',
                'string',
                Rule::in(['transfer', 'tunai']),
            ],
            'bukti_pembayaran' => [
                'required',
                'file',
                'mimes:jpeg,jpg,png,pdf',
                'max:5120', // Max 5MB
            ],
            'keterangan' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public function messages()
    {
        return [
            'tanggal_pembayaran.required' => 'Tanggal pembayaran wajib diisi',
            'tanggal_pembayaran.date' => 'Format tanggal pembayaran tidak valid',
            'tanggal_pembayaran.before_or_equal' => 'Tanggal pembayaran tidak boleh lebih dari hari ini',
            'jumlah_pembayaran.required' => 'Jumlah pembayaran wajib diisi',
            'jumlah_pembayaran.numeric' => 'Jumlah pembayaran harus berupa angka',
            'jumlah_pembayaran.min' => 'Jumlah pembayaran minimal 1',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload',
            'bukti_pembayaran.file' => 'Bukti pembayaran harus berupa file',
            'bukti_pembayaran.mimes' => 'Format file tidak didukung. Gunakan JPG, PNG, atau PDF',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 5MB',
            'keterangan.max' => 'Keterangan maksimal 500 karakter',
        ];
    }
}

