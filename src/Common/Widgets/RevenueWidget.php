<?php

namespace Corals\Modules\Payment\Common\Widgets;

use Corals\Modules\Payment\Common\Models\Invoice;

class RevenueWidget
{
    public function __construct()
    {
    }

    public function run($args)
    {
        $revenue = Invoice::where('status', 'paid')->sum('total');
        ;

        return ' <!-- small box -->
            <div class="card">
                <div class="small-box bg-red card-body">
                    <div class="inner">
                        <h3>' . \Payments::admin_currency($revenue) . '</h3>
                        <p>' . trans('Payment::labels.widgets.revenue') . '</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="' . url('invoices') . '" class="small-box-footer">
                        ' . trans('Payment::labels.widgets.more_info') . '
                    </a>
                </div>
            </div>';
    }
}
