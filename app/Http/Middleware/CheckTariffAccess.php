<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\Tariff;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\TariffModule;

class CheckTariffAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $menu = $request->route()->parameters();
        if (!empty($menu)) {
            $menu_id = $menu['menu'];
        } else {
            $menu_id = $request->menu_id;
        }

        $moduleCode = explode('.', $request->route()->getAction()['as'])[0];
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $menu = Menu::where('id', $menu_id)->where('user_id', $user->id)->first();
        if (!$menu) {
            return response()->json(['message' => __('menu.not_found')], 403);
        }
        $tariff_id = $menu->tariff_id;

        $tariff = Tariff::find($tariff_id);

        if (!$tariff) {
            return response()->json(['message' => __('tariff.not_found')], 403);
        }


        $module = TariffModule::where('code', $moduleCode)->first();
        if (!$module) {
            return response()->json(['message' => __('module.not_found')], 403);
        }

        $hasAccess = $tariff->access()->where('tariff_module_id', $module->id)->exists();

        if (!$hasAccess) {
            return response()->json(['message' => __('menu.tariff_access_denied')], 403);
        }

        return $next($request);
    }
}
