<?php
/**
 * File: AbstractRepository.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:32
 * Project: lacc_acl
 * Copyright: 2018
 */

namespace App\Repositories\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    public function all( string $column = 'id', string $order = 'ASC' ): Collection
    {
        return $this->model->orderBy( $column, $order )->get();
    }

    public function paginate( $paginate = 10, string $column = 'id', string $order = 'ASC' ): LengthAwarePaginator
    {
        return $this->model->orderBy( $column, $order )->paginate( $paginate );
    }

    public function findWhereLike( array $columns, string $search, string $column = 'id', string $order = 'ASC' ): Collection
    {
        $query = $this->model;
        
        foreach ( $columns as $key => $value ):
            $query = $query->orWhere( $value, 'like', '%' . $search . '%' );
        endforeach;

        return $query->orderby( $column, $order )->get();
    }

    public function create( array $data ): Bool
    {
        return (bool)$this->model->create( $data );
    }

    public function find( int $id )
    {
        return $this->model->find( $id );
    }

    public function update( array $data, int $id ): Bool
    {
        $register = $this->find( $id );

        return $register ? (bool)$register->update( $data ) : false;
    }

    public function delete( int $id ): Bool
    {
        $register = $this->find( $id );

        return $register ? (bool)$register->delete() : false;
    }

    protected function resolveModel()
    {
        return app( $this->model );
    }
}