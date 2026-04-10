<?php

namespace App\Dtos;

class ProductSearchResource
{
    public function __construct(
        public int $id,
        public string $nombre,
        public string $descripcion,
        public float $precio,
        public string $categoria,
        public int $stock
    ) {}


    public static function fromElastic(array $hit): self
    {
        $source = $hit['_source'];

        return new self(
            id: (int) ($source['id'] ?? $hit['_id']),
            nombre: $source['nombre'] ?? 'Sin nombre',
            descripcion: $source['descripcion'] ?? '',
            precio: (float) ($source['precio'] ?? 0),
            categoria: $source['categoria'] ?? 'General',
            stock: (int) ($source['stock'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'nombre'      => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio'      => $this->precio,
            'categoria'   => $this->categoria,
            'stock'       => $this->stock,
        ];
    }
}