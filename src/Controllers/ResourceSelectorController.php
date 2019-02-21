<?php

namespace Infinety\TemplyResourcesSelector\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Infinety\TemplyResourcesSelector\Events\ResourceChangedEvent;

class ResourceSelectorController extends Controller
{
    /**
     * Get if type is activated or not
     *
     * @param string $type
     */
    public function getType(string $type)
    {
        if (setting('resource_'.$type, 'default') != 'default') {
            return response()->json(['exists' => (bool) setting('resource_'.$type)]);
        }

        return response()->json(['exists' => true]);
    }

    /**
     * Set value for given type
     *
     * @param Request $request
     * @param $type
     */
    public function setType(Request $request, $type)
    {
        $status = $request->get('value');
        setting(['resource_'.$type => $status]);
        setting()->save();

        event(new ResourceChangedEvent($type, $status));

        return response()->json(['success' => true]);
    }
}
