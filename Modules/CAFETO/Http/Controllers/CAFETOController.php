<?php

namespace Modules\CAFETO\Http\Controllers;

use Illuminate\Routing\Controller;

class CAFETOController extends Controller
{
    /**
     * Display the main page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $view = [
            'titlePage' => trans('cafeto::mainPage.TitlePage') ?: 'Welcome to CAFETO',
            'titleView' => trans('cafeto::mainPage.TitleWelcome') ?: 'Welcome'
        ];
        return view('cafeto::index', compact('view'));
    }

    /**
     * Display the developers page.
     *
     * @return \Illuminate\View\View
     */
    public function devs()
    {
        $view = [
            'titlePage' => trans('cafeto::controllers.CAFETO_devs_title_page') ?: 'Developers',
            'titleView' => trans('cafeto::controllers.CAFETO_devs_title_view') ?: 'Our Team'
        ];
        return view('cafeto::developers.index', compact('view'));
    }

    /**
     * Display the information page.
     *
     * @return \Illuminate\View\View
     */
    public function info()
    {
        $view = [
            'titlePage' => trans('cafeto::controllers.CAFETO_info_title_page') ?: 'Information',
            'titleView' => trans('cafeto::controllers.CAFETO_info_title_page') ?: 'About Us'
        ];
        return view('cafeto::information.index', compact('view'));
    }

    /**
     * Display the configuration page.
     *
     * @return \Illuminate\View\View
     */
    public function configuration()
    {
        $view = [
            'titlePage' => trans('cafeto::controllers.CAFETO_configuration_title_page') ?: 'Configuration',
            'titleView' => trans('cafeto::controllers.CAFETO_configuration_title_view') ?: 'Settings'
        ];
        return view('cafeto::configuration.index', compact('view'));
    }

    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        $view = [
            'titlePage' => trans('cafeto::controllers.CAFETO_admin_title_page') ?: 'Admin Dashboard',
            'titleView' => trans('cafeto::controllers.CAFETO_admin_title_view') ?: 'Admin Panel'
        ];
        return view('cafeto::admin-index', compact('view'));
    }

    /**
     * Display the cashier dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function cashier()
    {
        $view = [
            'titlePage' => trans('cafeto::controllers.CAFETO_cashier_title_page') ?: 'Cashier Dashboard',
            'titleView' => trans('cafeto::controllers.CAFETO_cashier_title_view') ?: 'Cashier Panel'
        ];
        return view('cafeto::cashier-index', compact('view'));
    }

    /**
     * Display the instructor dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function instructor()
    {
        $view = [
            'titlePage' => trans('cafeto::mainPage.TitlePage') ?: 'Instructor Dashboard',
            'titleView' => trans('cafeto::mainPage.TitleWelcome') ?: 'Welcome Instructor'
        ];
        return view('cafeto::instructor-index', compact('view'));
    }
}
?>