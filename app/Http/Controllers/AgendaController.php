<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $query = Agenda::query();
        $query->join('users', 'agenda.id_user', '=', 'users.id');
        $query->select('agenda.*', 'users.name as creator_name');

        if (!empty($request->cari)) {
            $query->where('agenda.nama_agenda', 'like', '%' . $request->agenda_search . '%');
        }

        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('agenda.tanggal', [$request->dari, $request->sampai]);
        }

        $query->orderBy('agenda.tanggal', 'desc');

        $data['agenda'] = $query->paginate(30)->appends($request->all());
        $data['user'] = $user;

        return view('agenda.index', $data);
    }

    public function create()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $data['user'] = $user;

        return view('agenda.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_agenda' => 'required',
            'tanggal' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'tempat' => 'nullable',
            'keterangan' => 'nullable',
        ]);

        try {
            Agenda::create([
                'nama_agenda' => $request->nama_agenda,
                'tanggal' => $request->tanggal,
                'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal,
                'jam_mulai' => !empty($request->jam_mulai) ? $request->jam_mulai : null,
                'jam_selesai' => !empty($request->jam_selesai) ? $request->jam_selesai : null,
                'tempat' => $request->tempat,
                'keterangan' => $request->keterangan,
                'id_user' => auth()->user()->id
            ]);

            $agent = new Agent();
            if ($agent->isMobile()) {
                return redirect()->route('agenda.index')->with(messageSuccess('Data Berhasil Disimpan'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data['user'] = User::where('id', auth()->user()->id)->first();
        $data['agenda'] = Agenda::where('id', $id)->first();

        return view('agenda.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'nama_agenda' => 'required',
            'tanggal' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'tempat' => 'nullable',
            'keterangan' => 'nullable',
        ]);

        try {
            $agenda = Agenda::find($id);
            $agenda->update([
                'nama_agenda' => $request->nama_agenda,
                'tanggal' => $request->tanggal,
                'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal,
                'jam_mulai' => !empty($request->jam_mulai) ? $request->jam_mulai : null,
                'jam_selesai' => !empty($request->jam_selesai) ? $request->jam_selesai : null,
                'tempat' => $request->tempat,
                'keterangan' => $request->keterangan,
                'id_user' => auth()->user()->id
            ]);

            $agent = new Agent();
            if ($agent->isMobile()) {
                return redirect()->route('agenda.index')->with('success', 'Data Berhasil Diupdate');
            }
            return Redirect::back()->with('success', 'Data Berhasil Diupdate');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            Agenda::where('id', $id)->delete();
            return Redirect::back()->with('success', 'Data Berhasil Dihapus');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    public function getEvents(Request $request)
    {
        $agendas = Agenda::all();
        $events = [];
        foreach ($agendas as $agenda) {
            $end_date = $agenda->tanggal_selesai ?? $agenda->tanggal;
            $allDay = ($agenda->jam_mulai && $agenda->jam_mulai !== '00:00:00') ? false : true;
            if ($allDay) {
                // Add 1 day to end date because FullCalendar's end date is exclusive for all-day events
                $end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
            }

            $events[] = [
                'id' => $agenda->id,
                'title' => $agenda->nama_agenda,
                'start' => $agenda->tanggal . ($agenda->jam_mulai ? 'T' . $agenda->jam_mulai : ''),
                'end' => $end_date . ($agenda->jam_selesai ? 'T' . $agenda->jam_selesai : ''),
                'description' => $agenda->keterangan,
                'location' => $agenda->tempat,
                'allDay' => $allDay,
                'extendedProps' => [
                    'encrypted_id' => Crypt::encrypt($agenda->id)
                ]
            ];
        }
        return response()->json($events);
    }

    public function updateDate(Request $request)
    {
        $id = $request->id;
        $agenda = Agenda::find($id);
        if ($agenda) {
            $agenda->update([
                'tanggal' => $request->tanggal,
                'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Agenda not found'], 404);
    }

    public function reset()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if (!$user->hasRole('super admin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            Agenda::query()->delete();
            return Redirect::back()->with(messageSuccess('Semua data agenda berhasil direset'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
