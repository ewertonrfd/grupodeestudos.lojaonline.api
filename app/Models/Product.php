<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nome', 'descricao', 'preco', 'estoque'])]
class Product extends Model
{
    //
}
