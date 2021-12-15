<?php

namespace Modules\TcbAmazonSync\Listeners;

use App\Events\Module\SettingShowing as Event;

class ShowInSettingsPage
{
    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        $event->modules->settings['tcb-amazon-sync'] = [
            'name' => trans('tcb-amazon-sync::general.settings.apisetting.name'),
            'description' => trans('tcb-amazon-sync::general.settings.apisetting.desc'),
            'url' => route('tcb-amazon-sync.amazon.apisettings.updatesp'),
            'icon' => 'fa fa-pen',
        ];
    }
}