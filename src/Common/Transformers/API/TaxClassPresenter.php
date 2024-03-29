<?php

namespace Corals\Modules\Payment\Common\Transformers\API;

use Corals\Foundation\Transformers\FractalPresenter;

class TaxClassPresenter extends FractalPresenter
{
    /**
     * @return TaxClassTransformer
     */
    public function getTransformer()
    {
        return new TaxClassTransformer();
    }
}
