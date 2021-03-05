<?php 

class AdminEnqueueCest
{
    public function _before(AcceptanceTester $I)
    {
        // will be executed at the begining of each test.
        $I->loginAsAdmin();
        $I->am('administrator');
    }

    public function enqueue_script_test(AcceptanceTester $I)
    {
        $I->wantTo('Check admin script on the plugins page');
        $I->amOnAdminPage('admin.php?page=invoice_system_for_woocommere_menu');
        $I->seeInSource('invoice-system-for-woocommere-admin.js');
        $I->seeInSource('invoice-system-for-woocommere-select2.js');
    }

    public function enqueue_style_test(AcceptanceTester $I)
    {
        $I->wantTo('Check admin styles on the plugins page');
        $I->amOnAdminPage('admin.php?page=invoice_system_for_woocommere_menu');
        $I->seeInSource('invoice-system-for-woocommere-admin.scss');
        $I->seeInSource('invoice-system-for-woocommere-select2.css');
    }
}
