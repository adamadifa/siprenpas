<?php

namespace App\View\Composers;

use App\Models\PengaturanUmum;
use Illuminate\View\View;

class PengaturanUmumComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $pengaturan = PengaturanUmum::first();
        $view->with('pengaturan', $pengaturan);
    }
}

