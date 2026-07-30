<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendChecklistIbadahJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tanggal;

    /**
     * Create a new job instance.
     */
    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Query distinct employees who have filled checklist ibadah for the specified date
        $users = DB::table('checklist_ibadah')
            ->join('karyawan', 'checklist_ibadah.npp', '=', 'karyawan.npp')
            ->join('checklist_ibadah_detail', 'checklist_ibadah.kode_checklist_ibadah', '=', 'checklist_ibadah_detail.kode_checklist_ibadah')
            ->where('checklist_ibadah.tanggal', $this->tanggal)
            ->orderBy('karyawan.nama_lengkap', 'asc')
            ->select('karyawan.nama_lengkap')
            ->distinct()
            ->get();

        // Query recap by Unit
        $unitRecap = DB::table('checklist_ibadah')
            ->join('karyawan', 'checklist_ibadah.npp', '=', 'karyawan.npp')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->where('checklist_ibadah.tanggal', $this->tanggal)
            ->select('unit.nama_unit', DB::raw('count(distinct checklist_ibadah.npp) as total'))
            ->groupBy('unit.nama_unit')
            ->orderBy('unit.nama_unit', 'asc')
            ->get();

        $formattedDate = date('d-m-Y', strtotime($this->tanggal));

        if ($users->isEmpty()) {
            $message = "Belum ada SDM yang mengisi Checklist Ibadah pada tanggal " . $formattedDate;
        } else {
            $message = "Daftar SDM Yang sudah Mengisi Checklist Ibadah (" . $formattedDate . "):\n";
            $i = 1;
            foreach ($users as $user) {
                $message .= $i . ". " . $user->nama_lengkap . "\n";
                $i++;
            }

            // Append unit recap table
            $message .= "\n*Rekapitulasi per Unit:*\n";
            $message .= "```\n";
            $message .= sprintf("%-18s | %s\n", "Unit", "Jumlah");
            $message .= str_repeat("-", 27) . "\n";
            foreach ($unitRecap as $recap) {
                // Limit unit name to 18 chars to prevent wrapping
                $unitName = strlen($recap->nama_unit) > 18 ? substr($recap->nama_unit, 0, 15) . '...' : $recap->nama_unit;
                $message .= sprintf("%-18s | %d\n", $unitName, $recap->total);
            }
            $message .= "```\n";
        }

        $pesan = [
            'api_key' => 'uxlLxWx36Q4KzaPlbFMCsuCRO7MvXn',
            'sender' => '6289670444321',
            // 'number' => '6285223368791-1504701755@g.us',
            'number' => '120363426127060329@g.us',
            'message' => $message
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wa.portalmp.com/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($pesan),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            Log::error("Curl error sending checklist notification: " . curl_error($curl));
        } else {
            Log::info("Checklist notification sent: " . $response);
        }
        curl_close($curl);
    }
}
