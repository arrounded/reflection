<?php
namespace Arrounded\Reflection\Entities\Traits;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

/**
 * A model with methods that connect to routes and controllers.
 */
trait ReflectionModel
{
    ////////////////////////////////////////////////////////////////////
    //////////////////////////////// STATE /////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Whether the model belongs to the currently authentified user.
     *
     * @return bool
     */
    public function belongsToCurrent()
    {
        return Auth::id() == $this->user_id;
    }

    ////////////////////////////////////////////////////////////////////
    ////////////////////////////// REFLECTION //////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Get the object's identifier.
     *
     * @return string|int
     */
    public function getIdentifier()
    {
        return $this->slug ?: $this->id;
    }

    /**
     * Get the model's class.
     *
     * @return string
     */
    public function getClass()
    {
        return get_class($this);
    }

    /**
     * Get the model's base class.
     *
     * @return string
     */
    public function getClassBasename()
    {
        return class_basename($this->getClass());
    }

    //////////////////////////////////////////////////////////////////////
    /////////////////////////////// TRAITS ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * Whether the model soft deletes or not.
     *
     * @return bool
     */
    public function softDeletes()
    {
        return $this->hasTrait(SoftDeletes::class);
    }

    /**
     * Check if the model uses a trait.
     *
     * @param string $trait
     *
     * @return bool
     */
    public function hasTrait($trait)
    {
        $traits = class_uses_recursive($this->getClass());

        return in_array($trait, $traits);
    }
}
