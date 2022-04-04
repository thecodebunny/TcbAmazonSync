<?php

namespace Modules\TcbAmazonSync\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;

class Admin
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return mixed
     */
    public function compose(View $view)
    {
            $view->getFactory()->startPush('css', view('tcb-amazon-sync::layouts.maincss'));
            $view->getFactory()->startPush('scripts_start', view('tcb-amazon-sync::layouts.mainjs'));

        if ($view->getName() == 'partials.admin.footer') {
            $view->setPath(view('tcb-amazon-sync::layouts.footer')->getPath());
        }
    }
}