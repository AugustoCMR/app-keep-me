<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * Instância do model Eloquent.
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retorna todos os registros.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Busca um registro pelo ID.
     *
     * @param int|string $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Busca um registro pelo ID ou lança exception.
     *
     * @param int|string $id
     * @return Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Cria um novo registro.
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Atualiza um registro pelo ID.
     *
     * @param array $attributes
     * @param int|string $id
     * @return bool
     */
    public function update(array $attributes, $id): bool
    {
        $record = $this->findOrFail($id);
        return $record->update($attributes);
    }

    /**
     * Remove um registro pelo ID.
     *
     * @param int|string $id
     * @return bool|null
     */
    public function delete($id): ?bool
    {
        $record = $this->findOrFail($id);
        return $record->delete();
    }
}
