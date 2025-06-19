<?php

namespace App\Repositories\CoSo;

use App\Repositories\BaseRepository;

class CoSoRepository extends BaseRepository implements CoSoRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\CoSo::class;
    }
}
