@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Lista de usuarios</h1>

                <table class="table table-responsive">
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Ações</th>

                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Luis</td>
                        <td>luvett11@gmail.com</td>
                        <td>
                            <a href="#">Detalhes</a>
                            <a href="#">Editar</a>
                            <a href="#">Excluir</a>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Meg</td>
                        <td>meg@gmail.com</td>
                        <td>
                            <a href="#">Detalhes</a>
                            <a href="#">Editar</a>
                            <a href="#">Excluir</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
