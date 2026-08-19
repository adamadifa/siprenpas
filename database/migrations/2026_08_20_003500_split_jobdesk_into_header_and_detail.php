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
        // 1. Create jobdesk_group table
        Schema::create('jobdesk_group', function (Blueprint $table) {
            $table->char('kode_jobdesk_group', 10)->primary();
            $table->char('kode_unit', 3)->nullable();
            $table->char('kode_dept', 3);
            $table->char('kode_jabatan', 3);
            
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_dept')->references('kode_dept')->on('departemen')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_jabatan')->references('kode_jabatan')->on('jabatan')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });

        // 2. Add kode_jobdesk_group column to jobdesk table
        Schema::table('jobdesk', function (Blueprint $table) {
            $table->char('kode_jobdesk_group', 10)->nullable()->after('kode_jobdesk');
        });

        // 3. Migrate existing data
        $oldJobdesks = DB::table('jobdesk')->get();
        foreach ($oldJobdesks as $jd) {
            $unitPart = $jd->kode_unit ?? 'U00';
            $groupId = substr($jd->kode_jabatan . $jd->kode_dept . $unitPart, 0, 10);

            // Ensure group exists
            $groupExists = DB::table('jobdesk_group')->where('kode_jobdesk_group', $groupId)->exists();
            if (!$groupExists) {
                DB::table('jobdesk_group')->insert([
                    'kode_jobdesk_group' => $groupId,
                    'kode_unit' => $jd->kode_unit,
                    'kode_dept' => $jd->kode_dept,
                    'kode_jabatan' => $jd->kode_jabatan,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Update jobdesk row to refer to the group
            DB::table('jobdesk')->where('kode_jobdesk', $jd->kode_jobdesk)->update([
                'kode_jobdesk_group' => $groupId
            ]);
        }

        // 4. Set jobdesk column non-nullable, foreign key, and drop deprecated columns
        Schema::table('jobdesk', function (Blueprint $table) {
            // First drop existing foreign key for kode_unit if exists
            // Since we added it in a separate migration, it is named jobdesk_kode_unit_foreign
            try {
                $table->dropForeign(['kode_unit']);
            } catch (\Exception $e) {
                // Ignore if it doesn't exist
            }

            $table->char('kode_jobdesk_group', 10)->nullable(false)->change();
            $table->foreign('kode_jobdesk_group')->references('kode_jobdesk_group')->on('jobdesk_group')->restrictOnDelete()->cascadeOnUpdate();
            
            $table->dropColumn(['kode_unit', 'kode_dept', 'kode_jabatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobdesk', function (Blueprint $table) {
            $table->dropForeign(['kode_jobdesk_group']);
            
            $table->char('kode_unit', 3)->nullable()->after('kode_jobdesk');
            $table->char('kode_dept', 3)->after('kode_unit');
            $table->char('kode_jabatan', 3)->after('kode_dept');
            
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->restrictOnDelete()->cascadeOnUpdate();
        });

        // Restore data
        $groups = DB::table('jobdesk_group')->get();
        foreach ($groups as $g) {
            DB::table('jobdesk')->where('kode_jobdesk_group', $g->kode_jobdesk_group)->update([
                'kode_unit' => $g->kode_unit,
                'kode_dept' => $g->kode_dept,
                'kode_jabatan' => $g->kode_jabatan
            ]);
        }

        Schema::table('jobdesk', function (Blueprint $table) {
            $table->dropColumn('kode_jobdesk_group');
        });

        Schema::dropIfExists('jobdesk_group');
    }
};
