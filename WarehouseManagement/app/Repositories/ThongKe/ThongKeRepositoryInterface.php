<?php

namespace App\Repositories\ThongKe;

use App\Repositories\RepositoryInterface;

interface ThongKeRepositoryInterface extends RepositoryInterface
{
    public function getNguyenLieuWithStats($request);
}
