<?php
namespace Arrounded\Reflection\Dummies;

use Arrounded\Reflection\Entities\Traits\ReflectionModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Fluent;

class DummyReflectionModel extends Fluent
{
    use ReflectionModel;
}
