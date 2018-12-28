<?php
/**
 * File: AbstracRepositoryInterface.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:30
 * Project: lacc_acl
 * Copyright: 2018
 */

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AbstracRepositoryInterface
{
    public function all( string $column = 'id', string $order = 'ASC' ): Collection;

    public function paginate( int $paginate = 10, string $column = 'id', string $order = 'ASC' ): LengthAwarePaginator;

    public function findWhereLike( array $columns, string $search, string $column = 'id', string $order = 'ASC' ): Collection;

    public function create( array $data ): Bool;

    public function find( int $id );

    public function update( array $data, int $id ): Bool;

    public function delete( int $id ): Bool;
}