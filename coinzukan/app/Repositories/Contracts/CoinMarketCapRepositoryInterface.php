<?php
namespace App\Repositories\Contracts;

interface CoinMarketCapRepositoryInterface
{
    public function insert($data);

    public function update($data, $id);

    public function delete($id);

    public function find($id);

}