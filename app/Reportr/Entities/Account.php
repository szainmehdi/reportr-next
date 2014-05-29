<?php namespace Reportr\Entities;

class Account extends \Eloquent {

    /**
     * @var array
     * TODO: Set fillable property.
     */
    protected $fillable = [];


    /**
     * Enable soft-deletes.
     */
    protected $softDelete = true;


    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	| Set up all the relationships that this model has with other models.
	*/

    protected function users() {
        return $this->hasMany('Reportr\Entities\User');
    }

}