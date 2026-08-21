<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create program_kerja_group table
        Schema::create('program_kerja_group', function (Blueprint $table) {
            $table->char('kode_program_kerja_group', 15)->primary();
            $table->char('kode_unit', 3)->nullable();
            $table->char('kode_dept', 3);
            $table->char('kode_jabatan', 3);
            $table->char('kode_ta', 6);
            $table->bigInteger('id_user')->unsigned();

            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_dept')->references('kode_dept')->on('departemen')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_jabatan')->references('kode_jabatan')->on('jabatan')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_ta')->references('kode_ta')->on('konfigurasi_tahun_ajaran')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('id_user')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });

        // 2. Add kode_program_kerja_group column to program_kerja table
        Schema::table('program_kerja', function (Blueprint $table) {
            $table->char('kode_program_kerja_group', 15)->nullable()->after('kode_program_kerja');
        });

        // 3. Migrate existing data
        $oldProgs = DB::table('program_kerja')->get();
        foreach ($oldProgs as $p) {
            $unitPart = $p->kode_unit ?? 'U00';
            $groupId = substr($p->kode_ta . $p->kode_jabatan . $p->kode_dept . $unitPart, 0, 15);

            // Ensure group exists
            $groupExists = DB::table('program_kerja_group')->where('kode_program_kerja_group', $groupId)->exists();
            if (!$groupExists) {
                DB::table('program_kerja_group')->insert([
                    'kode_program_kerja_group' => $groupId,
                    'kode_unit' => $p->kode_unit,
                    'kode_dept' => $p->kode_dept,
                    'kode_jabatan' => $p->kode_jabatan,
                    'kode_ta' => $p->kode_ta,
                    'id_user' => $p->id_user,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Update program_kerja row to refer to the group
            DB::table('program_kerja')->where('kode_program_kerja', $p->kode_program_kerja)->update([
                'kode_program_kerja_group' => $groupId
            ]);
        }

        // 4. Set program_kerja column non-nullable, foreign key, and drop deprecated columns
        Schema::table('program_kerja', function (Blueprint $table) {
            try {
                $table->dropForeign(['kode_unit']);
            } catch (\Exception $e) {}
            try {
                $table->dropForeign(['kode_dept']);
            } catch (\Exception $e) {}
            try {
                $table->dropForeign(['kode_jabatan']);
            } catch (\Exception $e) {}
            try {
                $table->dropForeign(['kode_ta']);
            } catch (\Exception $e) {}
            try {
                $table->dropForeign(['id_user']);
            } catch (\Exception $e) {}

            $table->char('kode_program_kerja_group', 15)->nullable(false)->change();
            $table->foreign('kode_program_kerja_group')->references('kode_program_kerja_group')->on('program_kerja_group')->restrictOnDelete()->cascadeOnUpdate();

            $table->dropColumn(['kode_unit', 'kode_dept', 'kode_jabatan', 'kode_ta', 'id_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_kerja', function (Blueprint $table) {
            $table->dropForeign(['kode_program_kerja_group']);

            $table->char('kode_unit', 3)->nullable()->after('kode_program_kerja');
            $table->char('kode_dept', 3)->after('kode_unit');
            $table->char('kode_jabatan', 3)->after('kode_dept');
            $table->char('kode_ta', 6)->after('kode_jabatan');
            $table->bigInteger('id_user')->unsigned()->after('kode_ta');

            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_dept')->references('kode_dept')->on('departemen')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_jabatan')->references('kode_jabatan')->on('jabatan')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_ta')->references('kode_ta')->on('konfigurasi_tahun_ajaran')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('id_user')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
        });

        // Restore data
        $groups = DB::table('program_kerja_group')->get();
        foreach ($groups as $g) {
            DB::table('program_kerja')->where('kode_program_kerja_group', $g->kode_program_kerja_group)->update([
                'kode_unit' => $g->kode_unit,
                'kode_dept' => $g->kode_dept,
                'kode_jabatan' => $g->kode_jabatan,
                'kode_ta' => $g->kode_ta,
                'id_user' => $g->id_user
            ]);
        }

        Schema::table('program_kerja', function (Blueprint $table) {
            $table->dropColumn('kode_program_kerja_group');
        });

        Schema::dropIfExists('program_kerja_group');
    }
};
